<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\LanguagesTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOptionsForProductResource extends JsonResource
{

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
            "price_unit_en" => $this->price_unit_en
        ];
    }
}
