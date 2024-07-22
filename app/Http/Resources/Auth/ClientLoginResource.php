<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientLoginResource extends JsonResource
{

    public function toArray($request)
    {

        return [

            "id"    => $this->id,
            "name"  => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "token" => $this->token,
            "country_id"    => $this->country_id,
            // "country_name_ar"    => $this->country->name_ar,
            // "country_name_en"    => $this->country->name_en
        ];
    }
}
