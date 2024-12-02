<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\Orders\RegionsService;
// use App\Http\Resources\RegionsResource;
// use App\Http\Requests\Region\StoreRequest;
// use App\Http\Requests\Region\UpdateRequest;


class RegionsController extends Controller
{
    use ResponsesTrait;
    private $regionsService;

    public function __construct()
    {

        $this->regionsService = new RegionsService();
    }

    public function get()
    {

        $regions = $this->regionsService->get();
        return $this->apiResponse($regions);
    }

    // public function create(StoreRequest $request)
    // {

    //     $data = $request->validated();
    //     $this->regionsService->create($data);
    //     return $this->apiResponse();
    // }

    // public function update(UpdateRequest $request){

    //     $region = $request->validated();
    //     $this->regionsService->update($region);
    //     return $this->apiResponse();
    // }

    // public function toggleActivation($id, $activationStatus)
    // {

    //     $this->regionsService->toggleActivation($id, $activationStatus);
    //     return $this->apiResponse();
    // }

    // public function delete($id){

    //     $this->regionsService->delete($id);
    //     return $this->apiResponse(null, true, __('deleted'));
    // }
}
