<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Orders\TransportationPeriodsService;
use App\Http\Requests\TransportationPeriod\StoreRequest;
use App\Http\Requests\TransportationPeriod\UpdateRequest;
use App\Http\Controllers\Controller;

class TransportationPeriodsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $transportationPeriodsService;

    public function __construct()
    {

        $this->transportationPeriodsService = new TransportationPeriodsService();
    }


    public function get(){

        $transportationPeriods = $this->transportationPeriodsService->get(userId: request('user_id'));
        return $this->apiResponse($transportationPeriods );
    }

    public function create(StoreRequest $request)
    {

        $transportationPeriod = $request->validated();
        $this->transportationPeriodsService->create($transportationPeriod);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $transportationPeriod = $request->validated();

        $this->transportationPeriodsService->update($transportationPeriod);

        return $this->apiResponse();

    }

    public function delete($id)
    {

        $this->transportationPeriodsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->transportationPeriodsService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

}
