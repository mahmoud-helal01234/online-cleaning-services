<?php

namespace App\Http\Services\Orders;

use App\Models\Order;
use App\Models\OrderLocation;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Models\OrderLocationStopPoint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderLocationsService
{

    use ResponsesTrait;
    use LoggedInUserTrait;

    public function get($orderId = null, $atDate = null)
    {

        $user = $this->getLoggedInUser();
        switch ($user->role) {

            case "admin":
                $orderLocations = Order::with('locations')->when($orderId != null, function ($query) use ($orderId) {
                    $query->where('order_id', $orderId);
                })->when($atDate != null, function ($query) use ($atDate) {
                    $query->where('Date(created_at)', $atDate);
                })->orderBy('created_at', 'DESC')->get();
                // $orderLocations = OrderLocation::when($orderId != null, function ($query) use ($orderId) {
                //     $query->where('order_id', $orderId);
                // })->when($atDate != null, function ($query) use ($atDate) {
                //     $query->where('Date(created_at)', $atDate);
                // })->orderBy('created_at', 'DESC')->get();
                break;
        }

        return $orderLocations;
    }

    public function getById($id)
    {

        $orderLocation = OrderLocation::find($id);

        if ($orderLocation == null)

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $orderLocation;
    }

    public function create($orderLocation)
    {

        $user = $this->getLoggedInUser();
        if ($user->role == "client")
            $orderLocation['order_id'] = $user->id;

        try {

            $createdOrderLocation = OrderLocation::create($orderLocation);
            return $createdOrderLocation;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));
        }
    }

    // public function update($newOrderLocation){

    //     $orderLocation = $this->getById($newOrderLocation['id']);
    //     try{

    //         $orderLocation->update($newOrderLocation);
    //         return $orderLocation;
    //     }catch(\Exception $ex){

    //         throw new HttpResponseException($this->apiResponse(status:false));;
    //     }
    // }

    public function delete($id)
    {

        $orderLocation = $this->getById($id);
        try {

            $orderLocation->delete();
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
    // public function deleteChildern($orderId){
    //     $location = OrderLocation::where('order_id',$orderId)->get();


    // }

    public function deleteAll()
    {

        Schema::disableForeignKeyConstraints();
        OrderLocationStopPoint::query()->truncate();
        OrderLocation::query()->truncate();
        Schema::enableForeignKeyConstraints();

    }

}
