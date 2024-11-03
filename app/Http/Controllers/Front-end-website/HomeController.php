<?php

namespace App\Http\Controllers\DriversApp;

use App\Http\Controllers\Controller;

use App\Http\Requests\DriversApp\Client\StoreRequest;
use App\Http\Requests\DriversApp\Client\UpdateRequest;
use App\Http\Traits\ResponsesTrait;

use App\Http\Services\DriversApp\HomeService;
use App\Http\Services\Products\CategoriesService;

class HomeController extends Controller
{

    use ResponsesTrait;
    private $categoriesService;
    public function __construct()
    {

        $this->categoriesService = new CategoriesService();
    }

    public function view(){

        $categories = $this->categoriesService->get();
        return view('index',["categories"=> $categories]);
    }

    // public function create(StoreRequest $request)
    // {

    //     $driver_app_clients = $request->validated();

    //     $this->clientsService->create($driver_app_clients);

    //     return $this->apiResponse();
    // }

    // public function update(UpdateRequest $request)
    // {

    //     $driver_app_clients = $request->validated();

    //     $this->clientsService->update($driver_app_clients);

    //     return $this->apiResponse();

    // }

    // public function delete($id)
    // {

    //     $this->clientsService->delete($id);
    //     return $this->apiResponse();
    // }
}
