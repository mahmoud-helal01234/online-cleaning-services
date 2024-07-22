<?php

namespace App\Http\Controllers\Countries;


use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\Governorate\StoreRequest;
use App\Http\Requests\Governorate\UpdateRequest;
use App\Http\Services\Countries\GovernoratesService;


class GovernoratesController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $governoratesService;

    public function __construct(){

        $this->governoratesService = new GovernoratesService();
    }

    public function get($countryId){

        $governorates = $this->governoratesService->get($countryId);
        return $this->apiResponse($governorates);
    }

    public function create(StoreRequest $request){

        $data = $request->validated();
        $this->governoratesService->create($data);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request){

        $governorate = $request->validated();
        $this->governoratesService->update($governorate);
        return $this->apiResponse();
    }
    public function toggleActivation($id, $activationStatus)
    {

        $this->governoratesService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->governoratesService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}

