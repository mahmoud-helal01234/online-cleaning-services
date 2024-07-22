<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use App\Http\Traits\LanguagesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyCategoriesResource extends JsonResource
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

            "id"            =>  $this->id,
            "category_id"   =>  $this->category->id,
            "img_path"      =>  $this->imageUrl($this->category->img_path),
            "name_ar" => $this->category->name_ar ,
            "name_en" => $this->category->name_en,
            "created_at"    =>  $this->created_at
        ];
    }
}
