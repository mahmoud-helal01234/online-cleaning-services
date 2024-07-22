<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Orders\TransportationPeriodsAssignedToDriversService;
use App\Http\Requests\TransportationPeriodsAssignedToDriver\StoreRequest;
use App\Http\Requests\TransportationPeriodsAssignedToDriver\UpdateRequest;
use App\Http\Controllers\Controller;

class TransportationPeriodsAssignedToDriversController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $transportationPeriodsAssignedToDrivers;


    public function __construct()
    {

        $this->transportationPeriodsAssignedToDrivers = new TransportationPeriodsAssignedToDriversService();
    }


    public function getDriverForTransportationPeriod($transportationPeriodId){

        $transportationPeriods = $this->transportationPeriodsAssignedToDrivers->getByTransportationPeriodId($transportationPeriodId);
        return $this->apiResponse($transportationPeriods );
    }
    public function get(){

        $transportationPeriods = $this->transportationPeriodsAssignedToDrivers->get();
        return $this->apiResponse($transportationPeriods );
    }
    public function selectPeriodsWithCapacity(){

        $transportationPeriodsWithCapacity = $this->transportationPeriodsAssignedToDrivers->selectPeriodsWithCapacity(request('user_id'), request('date'));
        return $this->apiResponse($transportationPeriodsWithCapacity );
    }

    public function create(StoreRequest $request)
    {

        $transportationPeriod = $request->validated();
        $this->transportationPeriodsAssignedToDrivers->create($transportationPeriod);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $transportationPeriod = $request->validated();
        $this->transportationPeriodsAssignedToDrivers->update($transportationPeriod);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->transportationPeriodsAssignedToDrivers->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}
