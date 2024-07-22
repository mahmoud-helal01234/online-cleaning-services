<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    use ImagesTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */



    public function toArray($request)
    {
        

        return [

<<<<<<< HEAD
            $this->collection];
        //     ->map(function ($order) {
        //         return [
=======
            "id"                        => $this->id,
            "role"                      => $this->role,
            "status"                    => $this->status,
            "type"                      => $this->type,
            "special_instructions"      => $this->special_instructions,
            "comment"                   => $this->comment,

            "actual_delivery_start_date_time"   => $this->actual_delivery_start_date_time,
            "actual_delivery_end_date_time"     => $this->actual_delivery_end_date_time,
            "actual_pickup_start_date_time"     => $this->actual_pickup_start_date_time,
            "actual_pickup_end_date_time"       => $this->actual_pickup_end_date_time,
            "drivers_manager_id"                => $this->drivers_manager_id,
            "pickup_date"                => $this->pickup_date,
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

        //             "id"                        => $order->id,
        //             "role"                      => $order->role,
        //             "status"                    => $order->status,
        //             "type"                      => $order->type,
        //             "special_instructions"      => $order->special_instructions,
        //             "comment"                   => $order->comment,
        //             "actual_delivery_start_date_time"   => $order->actual_delivery_start_date_time,
        //             "actual_delivery_end_date_time"     => $order->actual_delivery_end_date_time,
        //             "actual_pickup_start_date_time"     => $order->actual_pickup_start_date_time,
        //             "actual_pickup_end_date_time"       => $order->actual_pickup_end_date_time,
        //             "drivers_manager_id"                => $order->drivers_manager_id,
        //             "pickup_date"                => $order->pickup_date,
        
        //             "delivery_date"                => $order->delivery_date,
        
        //             "delivery_trasportation_period_assigned_to_driver"  => $order->deliveryTrasportationPeriodAssignedToDriver != null ?[
        //                 "driver" => $order->deliveryTrasportationPeriodAssignedToDriver->driver,
        //                 "transportation_period_id" => $order->deliveryTrasportationPeriodAssignedToDriver->transportationPeriod,
        //                 "capacity" => $order->deliveryTrasportationPeriodAssignedToDriver->capacity
        //             ]: null,
        //             "pickup_trasportation_period_assigned_to_driver"  =>  $order->pickupTrasportationPeriodAssignedToDriver != null ? [
        //                 "driver" => $order->pickupTrasportationPeriodAssignedToDriver->driver,
        //                 "transportation_period_id" => $order->pickupTrasportationPeriodAssignedToDriver->transportationPeriod,
        //                 "capacity" => $order->pickupTrasportationPeriodAssignedToDriver->capacity
        //             ] : null,
        //             // "delivery_trasportation_period_assigned_to_driver"  =>  $this->deliveryTrasportationPeriodAssignedToDriver != null? driver,
        
        //             "price"                             => $this->price,
        //             "easy_order"            => $this->easy_order,
        //             "items"                 => $this->items,
        //             "client_order"          =>  $this->clientOrder,
        //             "drivers_app_order"     => $this->driversAppOrder,
        //             "total_price"   => $this->totalPrice(),
        //             "created_at"    =>  $this->created_at->format('Y-m-d'),
        //             // "deleted_at"    =>  $this->deleted_at != null ? $this->deleted_at->format('Y-m-d') : $this->deleted_at
        //         ];
        //     }),
        //     'pagination' => [
        //         'total' => $this->total(),
        //         'per_page' => $this->perPage(),
        //         'current_page' => $this->currentPage(),
        //         'last_page' => $this->lastPage(),
        //     ],
        // ];

<<<<<<< HEAD
=======
            "delivery_trasportation_period_assigned_to_driver"  => $this->deliveryTrasportationPeriodAssignedToDriver != null ?[
                'id' => $this->deliveryTrasportationPeriodAssignedToDriver->id,
                "driver" => $this->deliveryTrasportationPeriodAssignedToDriver->driver,
                "transportation_period_id" => $this->deliveryTrasportationPeriodAssignedToDriver->transportationPeriod,
                "capacity" => $this->deliveryTrasportationPeriodAssignedToDriver->capacity
            ]: null,
            "pickup_trasportation_period_assigned_to_driver"  =>  $this->pickupTrasportationPeriodAssignedToDriver != null ? [
                'id' => $this->pickupTrasportationPeriodAssignedToDriver->id,
                "driver" => $this->pickupTrasportationPeriodAssignedToDriver->driver,
                "transportation_period_id" => $this->pickupTrasportationPeriodAssignedToDriver->transportationPeriod,
                "capacity" => $this->pickupTrasportationPeriodAssignedToDriver->capacity
            ] : null,
            // "delivery_trasportation_period_assigned_to_driver"  =>  $this->deliveryTrasportationPeriodAssignedToDriver != null? driver,
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

        
    }



    private function totalPrice()
    {

        $total = $this->price;
        $discount = 0;
        if (isset($this->discount_value)) {

            $discount = $this->discount_value_type == "constant" ?
                $this->discount_value :
                $this->discount_value / 100 * $total;
        }

        $total -= $discount;
        return  $total;
    }
}
