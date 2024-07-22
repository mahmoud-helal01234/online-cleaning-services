<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoicesResource extends JsonResource
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
            "discount_value_type"       => $this->discount_value_type,
            "discount_value"            => $this->discount_value,
            "tax_value_type"            => $this->tax_value_type,
            "tax_value"                 => $this->tax_value,
            "minimum_charge"            => $this->minimum_charge,

            "client_id"                 =>$this->client_id,
        
            "items" => $this->items,
            "sub_total"     => $this->subTotal(),
            "total_price"   => $this->totalPrice(),
            "created_at"    =>  $this->created_at->format('Y-m-d'),
            "deleted_at"    =>  $this->deleted_at != null ? $this->deleted_at->format('Y-m-d') : $this->deleted_at
        ];
    }

    private function subTotal(){

        $total = 0;
        foreach($this->items as $item)
        {

            $total += $item->price * $item->quantity;
        }

        return $total;

    }

    private function totalPrice(){

        $total = 0;
        foreach($this->items as $item)
        {

            $total += $item->price * $item->quantity;
        }

        $discount = $this->discount_value_type == "constant" ? $this->discount_value : $this->discount_value / 100 * $total;
        $tax = $this->tax_value_type == "constant" ? $this->tax_value : $this->tax_value / 100 * $total;
        $total = ($total - $discount + $tax);
        return  $total < $this->minimum_charge ? $this->minimum_charge : $total;

    }
}
