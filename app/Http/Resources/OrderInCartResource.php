<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderInCartResource extends JsonResource
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
            'order_id' => $this->order->id,
            'client_id' => $this->order->client_id,
            'order' => [
                'id' => $this->order->id,
                'role' => $this->order->role,
                'status' => $this->order->status,
                'items' => $this->order->items->map(function ($item) {
                    return [

                        'product' => [
                            'id' => $item->product->id,
                            'name_ar' => $item->product->name_ar,
                            'name_en' => $item->product->name_en,
                            'img_path' => $item->product->img_path,
                            'product_option' => [
                                'id' => $item->productOption->id,
                                'product_id' => $item->productOption->product_id,
                                'name_ar' => $item->productOption->name_ar,
                                'name_en' => $item->productOption->name_en,
                                'price_unit_ar' => $item->productOption->price_unit_ar,
                                'price_unit_en' => $item->productOption->price_unit_en,
                                'price' => $item->productOption->price,
                                'quantity' => $item->quantity,
                            ],
                        ],

                    ];
                }),
            ],
            'company' => [
                'user_id' => $this->company->user_id,
                'name_ar' => $this->company->name_ar,
                'name_en' => $this->company->name_en,
                'logo_path' => $this->company->logo_path,
                'user' => [
                    'id' => $this->company->user->id,
                    'phone' => $this->company->user->phone,
                ],
            ],
        ];
    }

}
