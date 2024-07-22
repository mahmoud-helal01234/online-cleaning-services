<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriversManagersWorkingWithCompanyResource extends JsonResource
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
            "drivers_manager" =>  [
                "id" => $this->driverManager->id,
                "name" => $this->driverManager->user->name,
                "created_at" => $this->driverManager->user->created_at,
                "updated_at" => $this->driverManager->user->updated_at
            ],

            "created_at" => $this->created_at
        ];
    }
}
