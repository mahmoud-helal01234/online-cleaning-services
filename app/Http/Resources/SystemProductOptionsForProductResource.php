<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\LanguagesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemProductOptionsForProductResource extends JsonResource
{
    use LanguagesTrait;
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
            "name_en" => $this->name_en
        ];
    }
}
