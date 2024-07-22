<?php

namespace App\Http\Services\DriversApp;

use Exception;


use App\Models\DriversApp\Order;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponsesTrait;

use App\Http\Services\Orders\OrdersService;

use App\Http\Traits\LoggedInUserTrait;
use App\Http\Services\Orders\NotificationsService;
use App\Http\Constants\OrderStatusesConstant;
use Illuminate\Http\Exceptions\HttpResponseException;

class DriversAppOrdersService
{

    use ResponsesTrait;
    use LoggedInUserTrait;
    private $notificationsService;
    private $ordersService;
    public function __construct()
    {

        $this->ordersService = new OrdersService();
        $this->notificationsService = new NotificationsService();
    }

    public function get($statuses = null)
    {


        $loggedInUser = $this->getLoggedInUser();
        switch ($loggedInUser->role) {

            case "driver":
                $orders = Order::when($statuses != null, function ($query) use ($statuses) {
                    $query->whereIn('status', $statuses)->select();
                })->with('items')->where('user_id', $loggedInUser->id)->orderBy('created_at', 'desc')->get();
                break;

            case "admin":
                $orders = Order::when($statuses != null, function ($query) use ($statuses) {
                    $query->where('status', $statuses)->select();
                })->with('items')->get();

                //$orders = Order::with('items')->get();
                break;
        }
        return $orders;
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

        $loggedInUser = $this->getLoggedInUser();
        $order['user_id'] = $loggedInUser->id;
        try {

            if (!(isset($order['price']) && $order['price'] != null && $order['price'] != 0)) {

                //
                $order['price'] = 0;

                if (isset($order['items']))
                    foreach ($order['items'] as $item) {

                        $order['price'] += $item['price'] * $item['quantity'];
                    }
            }


            DB::transaction(function () use ($order) {

                $order['status'] = 'confirmed';

                Order::create($order);
            });
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
        }
    }
    public function update($newOrder)
    {

        $order = $this->getById($newOrder['id']);


        if (!(isset($newOrder['price']) && $newOrder['price'] != null && $newOrder['price'] != 0)) {

            $newOrder['price'] = 0;
            if (isset($newOrder['items'])) {

                foreach ($newOrder['items'] as $item) {

                    $newOrder['price'] += $item['price'] * $item['quantity'];
                }
            }
        }

<<<<<<< HEAD
=======
        }

>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

        DB::transaction(function () use ($order, $newOrder) {

            $order->update($newOrder);
           // $this->ordersService->update($newOrder);
        });

        try {

            return $order;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
        }
    }



    public function changeOrderStatus($id, $status)
    {

        if (!in_array($status, OrderStatusesConstant::statuses))
            throw new HttpResponseException($this->apiResponse(status: false, message: __('validation.not_exist')));

        $order = $this->getById($id);


        $loggedInUser = $this->getLoggedInUser();
        switch ($loggedInUser->role) {
            case "driver":

                for ($i = 0; $i < count(OrderStatusesConstant::statuses); $i++) {

                    if (OrderStatusesConstant::statuses[$i] == $order->status) {
                        break;
                    }
                    if (OrderStatusesConstant::statuses[$i] == $status)
                        throw new HttpResponseException($this->apiResponse(status: false, message: __('validation.cannot_move_to_this_status')));
                }
                break;
        }
        try {

            $order->update(['status' => $status]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    // private function getDeviceTokensForOrderStatusChangedNotification($order)
    // {

    //     $userIdsToNotify[] = $order->delivery_driver_id;

    //     $userIdsToNotify[] = $order->pickup_driver_id;

    //     return UserDeviceToken::whereIn('user_id', $userIdsToNotify)->pluck('device_token')->get();
    // }

    public function canUserUpdateOrder($user, $order)
    {

        switch ($user->role) {
            case "admin":
                return true;

            case "country_manager":
                return
                    $order->driversAppOrder->user_id == $user->id
                    || $order->driversAppOrder->user->driversManager->country_id == $user->countryManager->country_id
                    || $order->driversAppOrder->user->company->country_id == $user->countryManager->country_id;

            // case 'drivers_app':
            //     return
            //         $order->driversAppOrder->user_id == $user->id;

            case "company":

                return $order->driversAppOrder->user_id == $user->id;

            case "drivers_manager":
                return $order->driversAppOrder->user_id == $user->id;
        }


        return false;
    }

    public function canLoggedInUserChangeOrderStatusTo($order, $loggedInUser, $status)
    {

        if ($status == 'in_cart' || !in_array($status, OrderStatusesConstant::statuses)) {
            throw new HttpResponseException($this->apiResponse(message: "cant move order status"));
        }
        switch ($loggedInUser->role) {

                // case "admin":

                //     return true;

                // case "country_manager":

                //     if ($order->driversAppOrder->user->role == "company") {
                //         if ($loggedInUser->countryManager->country_id == $order->driversAppOrder->user->company->country_id) {
                //             return true;
                //         }
                //     } else if ($order->user->role == "drivers_manager") {
                //         if ($loggedInUser->driversManager->country_id == $order->driversAppOrder->user->driversManager->country_id) {
                //             return true;
                //         }
                //     }
                //     return $loggedInUser->id == $order->driversAppOrder->user_id;

            case "admin":
            case "country_manager":
            case "company":
            case "drivers_manager":
                return $loggedInUser->id == $order->driversAppOrder->user_id;

<<<<<<< HEAD
            case "driver":


                if (
                    $order->pickupTrasportationPeriodAssignedToDriver->driver_id == $loggedInUser->id &&
                    (
                        ($order->status == 'confirmed' && $status == 'in_picking') || 
                        ($order->status == 'in_picking' && $status == 'picked_up') ||
                        ($order->status == 'picked_up' && $status == 'in_processing')
                        )
                )
                    return true;


                if (
                    $order->deliveryTrasportationPeriodAssignedToDriver->driver_id == $loggedInUser->id &&
                    (($order->status == 'processing_done' && $status == 'in_delivery_box') ||
                        ($order->status == 'in_delivery_box' && $status == 'in_delivery') ||
                        ($order->status == 'in_delivery' && $status == 'delivered'))
                )
=======
                        if (OrderStatusesConstant::statuses[$i] == $order->status) {
                            break;
                        }
                        if (OrderStatusesConstant::statuses[$i] == $status)
                            throw new HttpResponseException($this->apiResponse(status: false, message:  __('validation.cannot_move_to_this_status')));
                    }
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6
                    return true;
        }

        return false;
    }

    public function canUserAccessOrderDetails($order , $user){
        switch ($user->role) {
            case "company":
                case "drivers_manager":
                return $order->driversAppOrder->user_id == $user->id;
            case "driver":
                return $order->deliveryTrasportationPeriodAssignedToDriver->driver_id == $user->id || $order->pickupTrasportationPeriodAssignedToDriver->driver_id == $user->id;
        }
    }

    public function delete($id)
    {



        $order = $this->getById($id);
        $order->delete();
        $loggedInUser = $this->getLoggedInUser();
        // switch ($loggedInUser->role) {
        //     case "client":

        //         if ($order->client_id != $loggedInUser->id || $order->status != "in_cart")
        //              throw new Exception();

        // if ($order->client_id != $loggedInUser->id || $order->status != "in_cart")
        //     throw new Exception();

        //         break;
        //     case 'admin':

        //         $this->ordersService->delete($order->id);
        // }
        try {
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
