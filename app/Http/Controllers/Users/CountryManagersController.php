<?php

namespace App\Http\Controllers\Users;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\CountryManager\StoreRequest;
use App\Http\Requests\CountryManager\UpdateRequest;
use App\Http\Services\Users\CountryManagersService;

class CountryManagersController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $countryManagersService;
    public function __construct()
    {

        $this->countryManagersService = new CountryManagersService();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->countryManagersService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

    public function create(StoreRequest $request)
    {

        $countryManager = $request->validated();
        $this->countryManagersService->create($countryManager);
        return $this->apiResponse();
    }

    public function get()
    {

        $users = $this->countryManagersService->get(countryId: request('country_id'));
        return $this->apiResponse($users);
    }

    public function update(UpdateRequest $request)
    {

        $user = $request->validated();

        $this->countryManagersService->update($user);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->countryManagersService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}
