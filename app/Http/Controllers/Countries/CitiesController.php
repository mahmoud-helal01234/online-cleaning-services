<?php

namespace App\Http\Controllers\Countries;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\City\StoreRequest;
use App\Http\Requests\City\UpdateRequest;
use App\Http\Services\Countries\CitiesService;


class CitiesController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $citiesService;

    public function __construct()
    {

        $this->citiesService = new CitiesService();
    }

    public function get($governorateId)
    {

        $cities = $this->citiesService->get($governorateId);
        return $this->apiResponse($cities);
    }

    public function create(StoreRequest $request)
    {

        $city = $request->validated();

        $this->citiesService->create($city);

        return $this->apiResponse();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->citiesService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }


    public function update(UpdateRequest $request)
    {

        $city = $request->validated();

        $this->citiesService->update($city);

        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->citiesService->delete($id);

        return $this->apiResponse(null, true, __('deleted'));
    }

}

