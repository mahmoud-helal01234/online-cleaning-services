<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientOrdersResource extends JsonResource
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

            "delivery_date"                => $this->delivery_date,

            "delivery_trasportation_period_assigned_to_driver"  => $this->deliveryTrasportationPeriodAssignedToDriver != null ?[
                "driver" => $this->deliveryTrasportationPeriodAssignedToDriver->driver,
                "transportation_period_id" => $this->deliveryTrasportationPeriodAssignedToDriver->transportationPeriod,
                "capacity" => $this->deliveryTrasportationPeriodAssignedToDriver->capacity
            ]: null,
            "pickup_trasportation_period_assigned_to_driver"  =>  $this->pickupTrasportationPeriodAssignedToDriver != null ? [
                "driver" => $this->pickupTrasportationPeriodAssignedToDriver->driver,
                "transportation_period_id" => $this->pickupTrasportationPeriodAssignedToDriver->transportationPeriod,
                "capacity" => $this->pickupTrasportationPeriodAssignedToDriver->capacity
            ] : null,
            // "delivery_trasportation_period_assigned_to_driver"  =>  $this->deliveryTrasportationPeriodAssignedToDriver != null? driver,

            "price"                 => $this->price,
            "easy_order"            => $this->easy_order,
            "items"                 => $this->items,
            "client_order"          =>  $this->clientOrder,
            "total_price"   => $this->totalPrice(),
            "created_at"    =>  $this->created_at->format('Y-m-d'),
            // "deleted_at"    =>  $this->deleted_at != null ? $this->deleted_at->format('Y-m-d') : $this->deleted_at
        ];
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
