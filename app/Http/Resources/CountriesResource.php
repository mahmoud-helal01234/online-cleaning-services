<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class CountriesResource extends JsonResource
{
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
            "img_path"  => $this->img_path,
            "governorates"  =>  $this->governorates,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,

        ];
    }
}
