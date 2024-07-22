<?php

namespace App\Http\Resources;

use App\Http\Traits\LanguagesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryTypesResource extends JsonResource
{

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
            "name_ar" => $this->name_ar ,
            "name_en" => $this->name_en,
            "description_ar" => $this->description_ar ,
            "description_en" => $this->description_en,
            "added_value_type"  => $this->added_value_type,
            "added_value"  => $this->added_value,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
