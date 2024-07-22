<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\LanguagesTrait;
use App\Http\Traits\ArraySliceTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOptionsResource extends JsonResource
{

    use ArraySliceTrait;
    use ImagesTrait;
    use LanguagesTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [

            "id" => $this->id,
            "name_ar" => $this->name_ar,
            "name_en" => $this->name_en,
            "price" => $this->price,
            "price_unit_ar" => $this->price_unit_ar,
            "price_unit_en" => $this->price_unit_en,
            "product" =>  [
                "id" => $this->product->id,
                "name_ar" => $this->product->name_ar,
                "name_en" => $this->product->name_en,
                "img_path" => $this->imageUrl($this->product->img_path)
            ]
        ];
    }
}
