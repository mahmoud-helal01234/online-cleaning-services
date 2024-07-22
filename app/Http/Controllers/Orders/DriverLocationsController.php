<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Orders\DriverLocationsService;
use App\Http\Requests\DriverLocation\StoreRequest;

use App\Http\Controllers\Controller;

class DriverLocationsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $driverLocationsService;

    public function __construct()
    {

        $this->driverLocationsService = new DriverLocationsService();
    }

    public function get()
    {

        $driverLocations = $this->driverLocationsService->get(request('driver_id'));
        return $this->apiResponse($driverLocations);
    }

    public function create(StoreRequest $request)
    {

        $driverLocation = $request->validated();

         $this->driverLocationsService->create($driverLocation);

        return $this->apiResponse();
    }

    // public function update(UpdateRequest $request)
    // {

    //     $driverLocation = $request->validated();

    //     $this->driverLocationsService->update($driverLocation);

    //     return $this->apiResponse();
    // }

    public function delete($id)
    {

        $this->driverLocationsService->delete($id);

        return $this->apiResponse(null, true, __('deleted'));
    }

    public function deleteAll()
    {




        return $this->apiResponse(null, true, __('deleted'));
    }
}

