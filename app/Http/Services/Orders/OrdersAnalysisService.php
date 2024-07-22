<?php

namespace App\Http\Services\Orders;

use App\Http\Constants\OrderStatusesConstant;
use App\Models\Order;
use App\Models\EasyOrder;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Models\ClientLocation;
use App\Models\OrderHaveBaseOrdersRate;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrdersAnalysisService
{

    use ResponsesTrait;
    use LoggedInUserTrait;

    public function get()
    {

        $loggedInUser = $this->getLoggedInUser();
        $orders = [];
        switch ($loggedInUser->role) {
            case "admin":
                $ordersPerStatuses = Order::select('id', 'status')
                    ->get()
                    ->groupBy('status')
                    ->toArray();

                $ordersPerStatuses = array_map(function ($status) use ($ordersPerStatuses) {
                    return [$status => $ordersPerStatuses[$status] ?? []];
                }, OrderStatusesConstant::statuses);

                $orders["orders_per_statuses"] = $ordersPerStatuses;
                $orders["orders_pickup_delivery_status"] = Order::select(
                    'id',
                    'delivery_start_date_time',
                    'delivery_end_time',
                    'actual_delivery_start_date_time',
                    'actual_delivery_end_time',
                    'pickup_start_date_time',
                    'pickup_end_time',
                    'actual_pickup_start_date_time',
                    'actual_pickup_end_time',
                    DB::raw('CASE
                    WHEN (actual_delivery_start_date_time IS NOT NULL AND actual_delivery_end_time IS NULL) OR
                         (actual_pickup_start_date_time IS NOT NULL AND actual_pickup_end_time IS NULL)
                         THEN "in_way"
                    WHEN (delivery_start_date_time < "' . Carbon::now()->addHours(1) . '" AND DATE(delivery_start_date_time) = "' . Carbon::now()->format('Y-m-d') . '" AND delivery_end_time > "' . Carbon::now()->format("H:i") . '") OR
                         (pickup_start_date_time < "' . Carbon::now()->addHours(1) . '" AND DATE(pickup_start_date_time) = "' . Carbon::now()->format('Y-m-d') . '" AND pickup_end_time > "' . Carbon::now()->format("H:i") . '")
                         THEN "should_start"
                    WHEN (delivery_start_date_time < "' . Carbon::now()->addHours(1) . '" AND actual_delivery_end_time IS NULL) OR
                         (pickup_start_date_time < "' . Carbon::now()->addHours(1) . '" AND actual_pickup_end_time IS NULL)
                         THEN "late_and_should_start"
                    WHEN ((actual_delivery_end_time IS NOT NULL AND actual_delivery_end_time > delivery_end_time AND DATE(delivery_start_date_time) = "' . Carbon::now()->format('Y-m-d') . '") OR DATE(delivery_start_date_time) < actual_delivery_start_date_time) OR
                         ((actual_pickup_end_time IS NOT NULL AND actual_pickup_end_time > pickup_end_time AND DATE(pickup_start_date_time) = "' . Carbon::now()->format('Y-m-d') . '") OR DATE(pickup_start_date_time) < actual_pickup_start_date_time)
                         THEN "delivered_or_pickedup_late"
                    WHEN (delivery_start_date_time > "' . Carbon::now()->addHours(1) . '" AND actual_delivery_start_date_time IS NULL ) OR
                         (pickup_start_date_time > "' . Carbon::now()->addHours(1) . '" AND actual_pickup_start_date_time IS NULL )
                         THEN "not_yet"
                        ElSE "delivered_successfully_or_not_specified"
                END AS delivery_status')
                    // WHEN (actual_delivery_start_date_time NOT NULL AND actual_delivery_start_date_time > delivery_start_date_time AND actual_delivery_end_time IS NOT NULL AND actual_delivery_end_time < delivery_end_time) OR
                    //     (actual_pickup_start_date_time NOT NULL AND actual_pickup_start_date_time > pickup_start_date_time AND actual_pickup_end_time IS NOT NULL AND actual_pickup_end_time < pickup_end_time)
                    //     THEN "late"
                    //     WHEN actual_delivery_end_time IS NOT NULL AND actual_delivery_end_time <= delivery_end_time THEN "delivered_on_time"
                    //     ELSE "not_delivered_yet"
                )
                    ->get();

                // foreach ($orders as $order) {
                //     switch ($order->delivery_status) {
                //         case 'delivered_late':
                //             // Order was delivered late
                //             break;
                //         case 'delivered_on_time':
                //             // Order was delivered on time
                //             break;
                //         case 'not_delivered_yet':
                //             // Order has not been delivered yet
                //             break;
                //     }
        }

        // $orderStatuses = array_map(function ($status) use ($orderStatuses) {
        //     return [$status => $orderStatuses[$status] ?? []];
        // }, $statuses);

        // return response()->json($orderStatuses);



        return $orders;
    }

    public function getOrdersAnalysisPerCompany($companyId = null, $from = null, $to = null)
    {

        $companyOrdersChart = DB::table('orders')->when($companyId != null, function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })
            ->when($from != null, function ($q) use ($from) {
                $q->where('created_at', '>', $from);
            })
            ->when($to != null, function ($q) use ($to) {
                $q->where('created_at', '<', $to);
            })
            ->select(
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(status = "delivered") as completed_orders'),
                DB::raw('SUM(status != "delivered") as not_completed_orders')
            )
            ->first();

        return $companyOrdersChart;
    }

    public function getOrdersCountForWeek($startingDate)
    {

        $endDate = Carbon::createFromFormat("Y-m-d", $startingDate)->addDays(7)->format("Y-m-d");
        $ordersCountForWeek = DB::table('orders')->where("created_at", ">=", $startingDate)
            ->where("created_at", "<", $endDate)
            ->select(
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('Date(created_at) as date')
            )->groupBy('date')->first();

        return $ordersCountForWeek;
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

        $order = Order::find($id);
        if ($order == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $order;
    }

    public function create($order)
    {

        try {

            $loggedInUser = $this->getLoggedInUser();
            switch ($loggedInUser->role) {
                case "client":
                    $order['client_id'] = $loggedInUser->id;
                    break;
            }
            switch ($order['type']) {

                case "items":
                    DB::transaction(function () use ($order) {


                        $createdOrder = Order::create($order);

                        foreach ($order['items'] as $item) {

                            OrderItem::create(['product_option_id' => $item['id'], 'order_id' => $createdOrder['id'], 'quantity' => $item['quantity']]);
                        }
                    });

                    break;
                case "easy":

                    DB::transaction(function () use ($order) {
                        $createdOrder = Order::create($order);

                        EasyOrder::create(["order_id" => $createdOrder->id, "content" => $order['content']]);
                    });
                    break;
            }

            return;
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

    public function addItem($order)
    {

        try {

            $loggedInUser = $this->getLoggedInUser();
            switch ($loggedInUser->role) {
                case "client":
                    $order['client_id'] = $loggedInUser->id;
                    break;
            }
            switch ($order['type']) {
                case "products":
                    $createdOrder = null;

                    break;
                case "easy":

                    $createdOrder = Order::create($order);

                    EasyOrder::create(["order_id" => $createdOrder->id, "content" => $order['content']]);
                    break;
            }

            return;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
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




    public function update($newOrder)
    {

        $order = $this->getById($newOrder['id']);
        try {

            $order->update($newOrder);
            return $order;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function delete($id)
    {

        try {

            $order = $this->getById($id);
            $loggedInUser = $this->getLoggedInUser();
            switch ($loggedInUser->role) {
                case "client":
                    if ($order->client_id != $loggedInUser->id || $order->status != "in_cart")
                        throw new Exception();
                    $order->delete();
                    break;
            }
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
