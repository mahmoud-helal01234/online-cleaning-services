<?php

namespace App\Http\Controllers\Users;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\DriversManager\StoreRequest;
use App\Http\Requests\DriversManager\UpdateRequest;
use App\Http\Services\Users\DriversManagersService;

class DriversManagersController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $driversManagersService;
    public function __construct()
    {

        $this->driversManagersService = new DriversManagersService();

    }

    public function get()
    {

        $driversManager = $this->driversManagersService->get(countryId : request('country_id'));
        return $this->apiResponse($driversManager);
    }
    public function toggleActivation($id, $activationStatus)
    {

        $this->driversManagersService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function create(StoreRequest $request)
    {

        $driverManager = $request->validated();
         $this->driversManagersService->create($driverManager);
        return $this->apiResponse();
    }

    // nothing to update for now
    public function update(UpdateRequest $request){
         $driverManager = $request->validated();
         $this->driversManagersService->update($driverManager);
         return $this->apiResponse();
     }

    public function delete($id)
    {

        $this->driversManagersService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
