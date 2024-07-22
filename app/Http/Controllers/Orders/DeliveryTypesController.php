<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\Orders\DeliveryTypesService;
use App\Http\Resources\DeliveryTypesResource;
use App\Http\Requests\DeliveryType\StoreRequest;
use App\Http\Requests\DeliveryType\UpdateRequest;


class DeliveryTypesController extends Controller
{
    use ResponsesTrait;
    private $deliveryTypesService;

    public function __construct()
    {

        $this->deliveryTypesService = new DeliveryTypesService();
    }

    public function get()
    {

        $deliveryTypes = $this->deliveryTypesService->get();
        return $this->apiResponse($deliveryTypes);
    }

    public function create(StoreRequest $request)
    {

        $data = $request->validated();
        $this->deliveryTypesService->create($data);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request){

        $deliveryType = $request->validated();
        $this->deliveryTypesService->update($deliveryType);
        return $this->apiResponse();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->deliveryTypesService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->deliveryTypesService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
