<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class CompaniesWorkingWithDriverManagerResource extends JsonResource
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
            "company" =>  [
                "id" => $this->company->user_id,
                "name" => $this->company->user->name,
                "logo_path"  =>   $this->imageUrl($this->company->logo_path)
            ],
            "created_at" => $this->created_at
        ];
    }
}
