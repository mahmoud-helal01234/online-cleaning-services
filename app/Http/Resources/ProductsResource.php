<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\LanguagesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            "name" => $this->name,
            "options" => $this->options,
            // "options" => SystemProductOptionsResource::collection($this->options),
            "img_path"  => $this->img_path,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
