<?php

namespace App\Http\Services\Orders;

use Exception;
use App\Models\Order;
use App\Models\EasyOrder;
use App\Models\OrderItem;
use App\Models\PromoCode;
use App\Models\ClientOrder;
use App\Models\ProductOption;
use App\Models\ClientLocation;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\ArraySliceTrait;

use App\Http\Traits\LoggedInUserTrait;
use App\Models\OrderHaveBaseOrdersRate;
use App\Http\Services\Orders\OrdersService;
use App\Http\Resources\ClientOrdersResource;
use App\Http\Constants\OrderStatusesConstant;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientOrdersService
{

    use ResponsesTrait, ArraySliceTrait;
    use LoggedInUserTrait;
    private $ordersService;
    public function __construct()
    {

        $this->ordersService = new OrdersService();
    }



    public function getClientOrdersInCartNum($clientId = null)
    {
        $loggedInUser = $this->getLoggedInUser();
        if($loggedInUser->role == "client")
            $clientId = $loggedInUser->id;

        $ordersNum = ClientOrder::where('client_id', $clientId)->whereHas('order', function ($query) {
            $query->where('status', 'in_cart');
        })->count();

        return $ordersNum;
    }
    public function getClientOrdersInCart($clientId = null)
    {
        $loggedInUser = $this->getLoggedInUser();
        if($loggedInUser->role == "client")
            $clientId = $loggedInUser->id;

        $ordersInCart = ClientOrder::where('client_id', $clientId)->whereHas('order', function ($query) {
            $query->where('status', 'in_cart');
        })->with([
            'order.items.product',
            'order.items.productOption',
            'company.user'
        ])
        ->get();
        return $ordersInCart;
    }
    public function getClientOrders($orderId = null)
    {
        $loggedInUser = $this->getLoggedInUser();
        if ($loggedInUser->role == "client") {
            $clientId = $loggedInUser->id;
        }

        $clientOrders = Order::when($orderId != null, function ($query) use ($orderId) {
                $query->where('id', $orderId);
            })
            ->with(['clientOrder.company.user' , 'items'])
            ->whereHas('clientOrder', function ($query) use ($clientId) {
                $query->where('client_id', $clientId);
            })
            ->where('status', '!=', 'in_cart')
            ->get();
        return $clientOrders;
    }

    public function get($statuses = null, $whereNotStatus = null, $companyId = null, $clientId = null, $from = null, $to = null)
    {


        $orders = Order::where("role","client")->when(
            $statuses != null,
            function ($query) use ($statuses) {
                $query->whereIn('status', $statuses)->select();
            }
        )
            ->with([
                'pickupTrasportationPeriodAssignedToDriver.driver.user',
                'deliveryTrasportationPeriodAssignedToDriver.driver.user',
                'easyOrder',
                'items',
                'clientOrder'
                => function ($query) {

                    $query->with([
                        'client:id,name',
                        'company.user:id,name',
                        'deliveryType',
                        'clientLocation',
                        'invoice',
                        'promoCode']);
                }

            ])

            ->select(
                'id',
                'role',
                'status',
                'type',
                'special_instructions',
                'comment',
                'pickup_date',
                'delivery_date',
                'actual_delivery_start_date_time',
                'actual_delivery_end_date_time',
                'actual_pickup_start_date_time',
                'actual_pickup_end_date_time',
                'pickup_driver_assigned_to_transportation_period_id',
                'drivers_manager_id',
                'price',
                'discount_value',
                'discount_value_type',
                'delivery_driver_assigned_to_transportation_period_id',
                'created_at'
            );
            $loggedInUser = $this->getLoggedInUser();

        $orders = $this->getOrderBasedonRole($orders, $loggedInUser);

        // case "client":

        // $easyOrders = Order::when($status != null, function ($query) use ($status) {
        //     $query->whereIn('status', $status);
        // })->when($whereNotStatus != null, function ($query) use ($whereNotStatus) {
        //     $query->whereNotIn('status', $whereNotStatus);
        // })->with(['deliveryType', 'company', 'easyOrder'])->where('type', 'easy')->get();
        // $orders = $easyOrders;
        // break;

        // $orders = Order::with(['pickupDriver' => function ($query) {

        //     $query->with('user:id,name')->select('id', 'user_id');

        // }, 'deliveryDriver' => function ($query) {
        //     $query->with('user:id,name')->select('id', 'user_id');
        // }, 'company' => function ($query) {
        //     $query->with('user:id,name')->select('id', 'user_id');
        // }, 'client:id,name', 'clientLocation:id,phone_number,detailed_address'])->when($status != null, function ($query) use ($status) {
        //     $query->where('status', $status);

        // })->when($clientId != null, function ($query) use($clientId) {
        //     $query->where('client_id',$clientId);

        // })->when($companyId != null, function ($query) use($companyId) {
        //     $query->where('company_id',$companyId);

        // })->when($from != null, function ($query) use($from) {
        //     $query->where(DB::raw('Date(created_at)'), '>=' ,$from);

        // })->when($to != null, function ($query) use($to) {
        //     $query->where(DB::raw('Date(created_at)'), '<=' ,$to);
        // })->when($clientId != null, function ($query) use ($clientId) {
        //     $query->where('client_id', $clientId);
        // })->when($companyId != null, function ($query) use ($companyId) {
        //     $query->where('company_id', $companyId);
        // })->when($from != null, function ($query) use ($from) {
        //     $query->where(DB::raw('Date(created_at)'), '>=', $from);
        // })->when($to != null, function ($query) use ($to) {
        //     $query->where(DB::raw('Date(created_at)'), '<=', $to);
        // })

        //     ->select('created_at', 'status', 'price', 'id', 'company_id', 'pickup_driver_id', 'delivery_driver_id', 'client_id', 'client_location_id')->get();
        return ClientOrdersResource::collection($orders->orderBy('id', 'DESC')->get());
        // return $orders;
    }

    public function getOrderBasedonRole($orders, $loggedInUser)
    {

        switch ($loggedInUser->role) {
            case "admin":
                break;
            // case "country_manager":

            //     $orders = $orders->where(

            //         function ($query) use ($loggedInUser) {

            //             $query->where(function ($query) use ($loggedInUser) {

            //                 $query->whereHas('clientOrder.company', function ($query) use ($loggedInUser) {

            //                     $query->where('country_id', $loggedInUser->countryManager->country_id);
            //                 })
            //                     ->orWhereHas('driversAppOrder.user.company', function ($query) use ($loggedInUser) {

            //                         $query->where('country_id', $loggedInUser->countryManager->country_id);
            //                     })
            //                     ->orWhereHas('driversAppOrder', function ($query) use ($loggedInUser) {

            //                         $query->where('user_id', $loggedInUser->id);
            //                     })
            //                     ->orWhereHas('driversAppOrder.user.driversManager', function ($query) use ($loggedInUser) {

            //                         $query->where('country_id', $loggedInUser->countryManager->country_id);
            //                     });
            //             });
            //         }
            //         // add drivers managers country_id and check
            //     );
            //     break;

            case "company":

                $orders = $orders->where('role', 'client')->WhereHas('clientOrder', function ($query) use ($loggedInUser) {

                    $query->where('company_id', $loggedInUser->id);
                });

                break;
            case "drivers_manager":
                $orders = $orders->where(function ($query) use ($loggedInUser) {

                    $query->where('drivers_manager_id', $loggedInUser->id);
                });

                break;
            //  case "client":


            //     $orders = $orders->whereHas('clientOrder', function ($query) use($loggedInUser){
            //         $query->where('client_id', $loggedInUser->id);
            //     });
            //     break;

        }
        return $orders;
    }

    public function getCartOrderDetails($orderId)
    {

        $loggedInUser = $this->getLoggedInUser();
        switch ($loggedInUser->role) {

            case "client":

                $order = Order::with(['promoCode', 'clientLocation', 'company' => function ($query) {

                    $query->select('id', 'name_ar', 'name_en', 'logo_path');
                }])->where('client_id', $loggedInUser->id)->where('id', $orderId)->first();

                $order->client_locations = ClientLocation::where('client_id', $loggedInUser->id)->get();

                switch ($order->type) {

                    case "items":

                        $order->items = OrderItem::with(['productOption' => function ($query) {
                            $query->select('id', 'price', 'product_id');
                        }, 'productOption.product'])->where('order_id', $order->id)->get();

                        foreach ($order->items as $key => $item) {

                            $order->items[$key]['total'] = $item->productOption['price'] * $item['quantity'];
                        }
                        if ($order->promoCode != null) {
                            throw new HttpResponseException($this->apiResponse(null, false, $order->promoCode));
                        }

                        break;
                }
                break;
        }
        return $order;
    }

    public function getOrderDetails($id)
    {

        $loggedInUser = $this->getLoggedInUser();
        switch ($loggedInUser->role) {

            case "client":

                $order = Order::with(['clientLocation', 'company' => function ($query) {
                    $query->select('id', 'name_ar', 'name_en', 'logo_path');
                }])->where('client_id', $loggedInUser->id)->where('id', $id)->first();
                $order->client_locations = ClientLocation::where('client_id', $loggedInUser->id)->get();
                switch ($order->type) {

                    case "items":

                        $order->items = OrderItem::with(['productOption.product'])->where('order_id', $order->id)->get();

                        break;
                }
                break;
        }
        return $order;
    }

    public function getById($id)
    {

        $order = ClientOrder::find($id);
        if ($order == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $order;
    }

    public function orderFilter()
    {

        $loggedInUser = $this->getLoggedInUser();
        switch ($loggedInUser->role) {
            case "admin":

                $order = Order::with(['client', 'company'])

                    ->get();
                break;
        }
        return $order;
    }

    public function create($order)
    {

        $loggedInUser = $this->getLoggedInUser();
        switch ($loggedInUser->role) {
            case "client":
                $order['client_id'] = $loggedInUser->id;
                break;
        }
        // $createdOrder = Order::create($order);


        ClientOrder::create($this->array_slice_assoc($order, [
            'order_id',
            'client_id',
            'company_id',
            'delivery_type_id',
            'client_location_id'
        ]));

        try {
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
        }
    }


    public function update($newOrder)
    {

        $order = $this->getById($newOrder['id']);

        // update in orders service
        /**
         *
         */
        //update order client
        $sliceorder = $this->array_slice_assoc($newOrder, [

            'client_id',
            'type',
            'company_id',
            'delivery_type_id',
            'promo_code_id',
            'client_location_id',
            'invoice_id',

        ]);

        $order->update($sliceorder);

        try {
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }


    public function addItemsToCart($data)
    {

        try {

            $loggedInUser = $this->getLoggedInUser();

            $data['client_id'] = $loggedInUser->id;


            DB::transaction(function () use ($data) {

                $order = Order::firstOrNew(
                    ['client_id' => $data['client_id'], 'company_id' => $data['company_id'], 'status' => 'in_cart', 'type' => 'items']
                );
                if (isset($data['special_instructions']) && $data['special_instructions'] != null) {
                    if ($order->special_instructions != null) {

                        $order->update(['special_instructions' => $order->special_instructions . " " . $data['special_instructions']]);
                    } else {
                        $order->update(['special_instructions' => $data['special_instructions']]);
                    }
                }


                foreach ($data['items'] as $item) {

                    $orderItem = OrderItem::where('order_id', $order['id'])->where('product_option_id', $item['id'])->first();

                    if ($orderItem == null) {

                        OrderItem::create(['product_option_id' => $item['id'], 'order_id' => $order['id'],  'quantity' => $item['quantity']]);
                    } else {

                        $orderItem->update(['quantity' => $orderItem->quantity + $item['quantity']]);
                    }
                }
            });

            return;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function deleteOrderItem($id)
    {

        try {
            $loggedInUser = $this->getLoggedInUser();
            switch ($loggedInUser->role) {
                case "client":

                    $orderItem = OrderItem::find($id);
                    if ($orderItem == null || $orderItem->order->client_id != $loggedInUser->id ||  $orderItem->order->status != 'in_cart')
                        throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
                    break;
            }

            $orderItem->delete();

            return;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function updateOrderItemQuantity($newOrderItem)
    {

        try {
            $loggedInUser = $this->getLoggedInUser();
            switch ($loggedInUser->role) {
                case "client":

                    $orderItem = OrderItem::find($newOrderItem['id']);
                    // validate if he can do this
                    if ($orderItem == null || $orderItem->order->client_id != $loggedInUser->id ||  $orderItem->order->status != 'in_cart')
                        throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
                    break;
            }

            $orderItem->update($newOrderItem);

            return;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function changeCompany($order)
    {

        try {
            $newCompanyId = $order['company_id'];
            $order = $this->getById($order['id']);
            switch ($order['type']) {

                case "easy":

                    $order->update(['company_id' => $newCompanyId]);
                    break;
                case "items":

                    DB::transaction(function () use ($order) {
                        $order->update(['type' => 'easy']);
                        $content = '';
                        foreach ($order->items as $item) {

                            $content .= $item->productOption->name_ar . ' => ' . $item->quantity . ' \n ';
                        }

                        EasyOrder::create(["order_id" => $order->id, "content" => $content]);
                        OrderItem::where('order_id', $order->id)->delete();
                    });

                    break;
            }

            return;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }
    public function addPromoCodeToOrder($data){

        $promoCode = PromoCode::where('code' , $data['promo_code'])->first();
        $discount['value'] = $promoCode->value;
        $discount['value_type'] = $promoCode->value_type;

        ClientOrder::where('order_id', $data['order_id'])->update(['promo_code_id' => $promoCode->id]);
        Order::where('id', $data['order_id'])->update(['discount_value' => $discount['value'], 'discount_value_type' => $discount['value_type']]);
        return true;
    }
    public function getOrderFromCart($clientId, $companyId){

        $isOrderInCart = Order::with('items')->whereHas('clientOrder', function ($query) use ($clientId,$companyId) {
            $query->where('client_id', $clientId)->where('company_id' , $companyId);
        })->where('status', 'in_cart')->first();
        return $isOrderInCart;
    }

    public function addProductOptionsToCart($newOrderItems)
    {

        $loggedInUser = $this->getLoggedInUser();
        if ($loggedInUser->role == "client")
                $newOrderItems['client_id'] = $loggedInUser->id;

        $clientId = $newOrderItems['client_id'];
        $companyId = $newOrderItems['company_id'];

        // get order for this (client_id and company_id) with items
        $order = $this->getOrderFromCart(clientId: $clientId, companyId: $companyId);

        // if no order then create one
        if($order == null) {
            $createdOrder = Order::create([
                'role' => 'client',
                'status' => 'in_cart'
            ]);

            ClientOrder::create([
                'order_id' => $createdOrder->id,
                'client_id' => $clientId,
                'company_id' => $companyId
            ]);
            $order = $createdOrder;
        }

        // $order->items
       // throw new HttpResponseException($this->apiResponse(null, false, $order));

        // $order->items order items from order

        // get the product options from the product options table to get name and price
        $productOptionIds = array_column($newOrderItems['items'], 'product_option_id');
        $productOptions = ProductOption::whereIn('id', $productOptionIds)->get()->keyBy('id');

        foreach($newOrderItems['items'] as &$orderItem){

            $productOption = $productOptions[$orderItem['product_option_id']];
            $orderItem['product_id'] = $productOption->product_id;
            $orderItem['name'] = $productOption->name_en;
            $orderItem['price'] = $productOption->price;
        }






        foreach($newOrderItems['items'] as $newOrderItem){

            $inOrderItems = false;

            foreach($order->items as $orderItem){


               if($orderItem->product_option_id == $newOrderItem['product_option_id']){

                OrderItem::where('order_id', $order->id)->where('product_option_id', $orderItem->product_option_id)->
                update([

                    'order_id' => $order->id,
                    'name' => $newOrderItem['name'],
                    'price' => $newOrderItem['price'],
                    'quantity' => $newOrderItem['quantity'] + $orderItem->quantity ,
                    'product_option_id' => $orderItem->product_option_id,
                    'product_id' => $newOrderItem['product_id']
                ]);
                   $inOrderItems = true;
                   break;
               }
            }

            if(!$inOrderItems){

                // create
                OrderItem::create([
                    'order_id' => $order->id,
                    'name' => $newOrderItem['name'],
                    'price' => $newOrderItem['price'],
                    'quantity' => $newOrderItem['quantity'] ,
                    'product_option_id' => $newOrderItem['product_option_id'],
                    'product_id' => $newOrderItem['product_id']
                ]);
            }


        }

            try {
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
        }
    }
    public function canClientCheckout($orderId){
        $order = $this->ordersService->getById($orderId);
        $clientOrder = $this->getById($orderId);
        $loggedInUser = $this->getLoggedInUser();

        if(!($order->status == 'in_cart' && $clientOrder->client_id == $loggedInUser->id)){
            throw new HttpResponseException($this->apiResponse(null, false, __('order status not in cart or that order not belong to you')));
        }else{
            return true;
        }
    }
    public function checkOut($checkOutOrder)
    {
        $order = $this->ordersService->getById($checkOutOrder['order_id']);

        //$this->checkDriverCapacity($order);
        if(isset($checkOutOrder['promo_code']) && $checkOutOrder['promo_code'] != null){

            $discount = $this->ordersService->getDiscountViaPromoCode($checkOutOrder['promo_code']);
            $checkOutOrder['discount_value'] = $discount['value'];
            $checkOutOrder['discount_value_type'] = $discount['value_type'];
            $promoCode = PromoCode::where('code', $checkOutOrder['promo_code'])->first();
            $checkOutOrder['promo_code_id'] = $promoCode->id;
        }

        try {
            DB::transaction(function () use ($order, $checkOutOrder) {
                // update in orders table
                // change status


                // update in client_order table
                $sliceorder = $this->array_slice_assoc($checkOutOrder, [

                    'delivery_type_id',
                    'promo_code_id',
                    'client_location_id',

                ]);

                ClientOrder::where('order_id', $order->id)->update($sliceorder);

                // delete the exist items for this order and create the new items
                $productOptionIds = array_column($checkOutOrder['items'], 'product_option_id');
                $productOptions = ProductOption::whereIn('id', $productOptionIds)->get();

                OrderItem::where('order_id', $order->id)->delete();

                $totalPrice = 0;
                foreach ($checkOutOrder['items'] as $orderItem) {

                    $productOption = $productOptions->where('id', $orderItem['product_option_id'])->first();
                    $price = $productOption->price * $orderItem['quantity'];


                    $totalPrice += $price;

                    OrderItem::create([

                        'order_id' => $order->id,
                        'name' => $productOption['name_ar'],
                        'price' => $productOption['price'],
                        'quantity' => $orderItem['quantity'],
                        'product_option_id' => $orderItem['product_option_id'],
                    ]);
                }
                $checkOutOrder['status'] = 'in_picking';
                $checkOutOrder['price'] = $totalPrice;
                $order->update($checkOutOrder);
            });

            return true;

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }
    public function deleteProductOptionFromCart($id, $companyId){
        $user = $this->getLoggedInUser();
        if($user->role == 'client')
            $clientId = $user->id;

        $order = $this->getOrderFromCart(clientId:$clientId, companyId:$companyId);
        if($order){
            OrderItem::where('order_id', $order->id)->where('product_option_id', $id)->delete();
        }else{
            throw new HttpResponseException($this->apiResponse(null, false, "order not found"));
        }

    }
    public function rate($data)
    {

        try {

            $loggedInUser = $this->getLoggedInUser();
            switch ($loggedInUser->role) {
                case "client":

                    $data['client_id'] = $loggedInUser->id;
                    if (isset($data['comment']) && $data['comment'] != null) {

                        $order = $this->getById($data['order_id']);
                        $order->update(['comment' => $data['comment']]);
                    }
                    foreach ($data['rates'] as $rate) {

                        OrderHaveBaseOrdersRate::updateOrCreate([
                            'base_orders_rate_id' => $rate['base_orders_rate_id'],
                            'order_id' => $data['order_id']
                        ], ['value' => $rate['value']]);
                    }

                    break;
            }

            return;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function delete($id)
    {



            $order = $this->getById($id);
            $order->delete();
            //$loggedInUser = $this->getLoggedInUser();
            // switch ($loggedInUser->role) {
            //     case "client":

            //         if ($order->client_id != $loggedInUser->id || $order->status != "in_cart")
            //              throw new Exception();

            //         break;
            //     case 'admin':

            //         $this->ordersService->delete($order->id);
            // }
                try {
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

    public function canUserUpdateOrder($user, $order)
    {

        switch ($user->role) {
            case "admin":
                return true;

            case "country_manager":
                return $order->clientOrder->company->country_id == $user->countryManager->country_id;

            case "company":
                return $order->clientOrder->company_id == $user->id;
        }
        return false;
    }
    public function canUserAccessOrderDetails($order , $user){
        switch ($user->role) {
            case "client":
                return $order->role == "client" && $order->clientOrder->client_id == $user->id;
            case "admin":
                return true;
            case "company":
                return $order->clientOrder->company_id == $user->id;
            default:
                return false;
        }
    }
    public function canLoggedInUserChangeOrderStatusTo($order, $loggedInUser, $status)
    {
        if ($order->status == "in_cart"){
            if($order->clientOrder->client_id != $loggedInUser->id){
                throw new HttpResponseException($this->apiResponse(null, false, __('this order is in cart and only user can change its status')));
            }else{
                for ($i = 0; $i < count(OrderStatusesConstant::statuses); $i++) {

                    if (OrderStatusesConstant::statuses[$i] == $order->status) {
                        break;
                    }
                    if (OrderStatusesConstant::statuses[$i] == $status)
                        throw new HttpResponseException($this->apiResponse(status: false, message: __('validation.cannot_move_to_this_status')));
                }
                return true;
            }
        }

        switch ($loggedInUser->role) {

            case "admin":

                return true;
            case "country_manager":

                return $loggedInUser->countryManager->country_id == $order->clientOrder->company->country_id;

            case "company":

                return $loggedInUser->id == $order->clientOrder->company_id;
            case "driver":
                if (
                    $order->deliveryTrasportationPeriodAssignedToDriver->driver_id == $loggedInUser->id ||
                    $order->pickupTrasportationPeriodAssignedToDriver->driver_id == $loggedInUser->id
                ) {
                    for ($i = 0; $i < count(OrderStatusesConstant::statuses); $i++) {

                        if (OrderStatusesConstant::statuses[$i] == $order->status) {
                            break;
                        }
                        if (OrderStatusesConstant::statuses[$i] == $status)
                            throw new HttpResponseException($this->apiResponse(status: false, message: __('validation.cannot_move_to_this_status')));
                    }
                    return true;
                }
        }

        return false;
    }
}
