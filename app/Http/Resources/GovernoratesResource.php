<?php

namespace App\Http\Resources;

use App\Http\Traits\LanguagesTrait;
use App\Http\Resources\CountriesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GovernoratesResource extends JsonResource
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
            "name_ar" => $this->name_ar,
            "name_en" => $this->name_en,
            "country" => [
                "id" => $this->country->id,
                "name_ar" => $this->country->name_ar,
                "name_en" => $this->country->name_en
            ],
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,

        ];
    }
}
