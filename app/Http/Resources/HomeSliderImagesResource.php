<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSliderImagesResource extends JsonResource
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

            "id" => $this->id,
            "img_path"  => $this->imageUrl($this->img_path),
            "active"    => $this->active,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
