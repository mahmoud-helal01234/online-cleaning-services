<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\ClientLocation\StoreRequest;
use App\Http\Requests\ClientLocation\UpdateRequest;
use App\Http\Services\Users\ClientLocationsService;


class ClientLocationsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $clientLocationsService;

    public function __construct()
    {

        $this->clientLocationsService = new ClientLocationsService();
    }

    public function get(Request $request)
    {

        $clientLocations = $this->clientLocationsService->get(request('client_id'));
        return $this->apiResponse($clientLocations);
    }

    public function selectClientLocations($clientId)
    {

        $clientLocations = $this->clientLocationsService->selectClientLocation($clientId);
        return $this->apiResponse($clientLocations);
    }

    public function create(StoreRequest $request)
    {

        $clientLocation = $request->validated();

         $this->clientLocationsService->create($clientLocation);

        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $clientLocation = $request->validated();

        $this->clientLocationsService->update($clientLocation);

        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->clientLocationsService->delete($id);

        return $this->apiResponse(null, true, __('deleted'));
    }

}

