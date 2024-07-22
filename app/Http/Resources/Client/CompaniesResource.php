<?php

namespace App\Http\Resources\Client;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class CompaniesResource extends JsonResource
{

    use ResponsesTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [

            
        ];
    }
}
