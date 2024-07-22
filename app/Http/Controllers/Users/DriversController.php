<?php

namespace App\Http\Controllers\Users;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Users\DriversService;
use App\Http\Resources\DriversResource;
use App\Http\Requests\Driver\StoreRequest;
use App\Http\Requests\Driver\UpdateRequest;
use App\Http\Requests\Driver\ClientRateDriver;

class DriversController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $driversService;
    public function __construct()
    {

        $this->driversService = new DriversService();

    }
    public function createClientRate(ClientRateDriver $request)
    {

        $data = $request->validated();
        $this->driversService->createClientRate($data);
        return $this->apiResponse();
    }

    public function get()
    {

        $drivers = $this->driversService->get(managerId: request('manager_id'));
        //return $this->apiResponse(DriversResource::collection($drivers));
        return $this->apiResponse($drivers);
    }

    public function myDrivers()
    {
        $drivers = $this->driversService->myDrivers(managerId: request('manager_id'));
        return $this->apiResponse($drivers);

    }
    public function create(StoreRequest $request)
    {
        $driverManager = $request->validated();
        $this->driversService->create($driverManager);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request){

        $driverManager = $request->validated();
        $this->driversService->update($driverManager);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->driversService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
