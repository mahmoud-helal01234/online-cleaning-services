<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\LanguagesTrait;
use App\Http\Traits\ArraySliceTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemProductOptionsResource extends JsonResource
{

    use LanguagesTrait;
    use ArraySliceTrait;
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

            "id" => $this->id,
            "name_ar" => $this->name_ar,
            "name_en" => $this->name_en,
            "system_product" =>  [
                "id" => $this->systemProduct->id,
                "name_ar" => $this->systemProduct->name_ar,
                "name_en" => $this->systemProduct->name_en,
                "img_path" => $this->imageUrl($this->systemProduct->img_path)
            ],
        ];
    }
}
