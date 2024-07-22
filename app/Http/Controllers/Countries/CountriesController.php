<?php

namespace App\Http\Controllers\Countries;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\Country\StoreRequest;
use App\Http\Requests\Country\UpdateRequest;
use App\Http\Services\Countries\CountriesService;

class CountriesController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $countriesService;

    public function __construct()
    {

        $this->countriesService = new CountriesService();
    }


    public function get(){

        
        $countries = $this->countriesService->get();
        return $this->apiResponse($countries );
    }

    public function create(StoreRequest $request)
    {

        $country = $request->validated();

        $this->countriesService->create($country);

        return $this->apiResponse();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->countriesService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $country = $request->validated();

        $this->countriesService->update($country);

        return $this->apiResponse();

    }

    public function delete($id)
    {

        $this->countriesService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }



}
