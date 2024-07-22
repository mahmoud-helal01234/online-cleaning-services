<?php

namespace App\Http\Controllers\DriversApp;

use App\Http\Controllers\Controller;

use App\Http\Requests\DriversApp\Client\StoreRequest;
use App\Http\Requests\DriversApp\Client\UpdateRequest;
use App\Http\Traits\ResponsesTrait;

use App\Http\Services\DriversApp\ClientsService;


class ClientsController extends Controller
{

    use ResponsesTrait;
    private $clientsService;
    public function __construct()
    {

        $this->clientsService = new ClientsService();
    }

    public function get(){


        $driver_app_clients = $this->clientsService->get();
        return $this->apiResponse($driver_app_clients );
    }

    public function create(StoreRequest $request)
    {

        $driver_app_clients = $request->validated();

        $this->clientsService->create($driver_app_clients);

        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $driver_app_clients = $request->validated();

        $this->clientsService->update($driver_app_clients);

        return $this->apiResponse();

    }

    public function delete($id)
    {

        $this->clientsService->delete($id);
        return $this->apiResponse();
    }
}
