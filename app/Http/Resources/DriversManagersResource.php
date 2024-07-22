<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriversManagersResource extends JsonResource
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
            "user" =>  ["id" => $this->user->id,"name" => $this->user->name,"email" => $this->user->email,"phone" => $this->user->phone],
            "created_at" => $this->user->created_at,
            "updated_at" => $this->user->updated_at
        ];
    }
}
