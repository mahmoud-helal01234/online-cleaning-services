<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\DriversApp\Client\StoreRequest;
use App\Http\Requests\DriversApp\Client\UpdateRequest;
use App\Http\Traits\ResponsesTrait;

use App\Http\Services\DriversApp\HomeService;
use App\Http\Services\Products\CategoriesService;

class WebsitePagesController extends Controller
{

    use ResponsesTrait;
    private $categoriesService;
    public function __construct()
    {

        $this->categoriesService = new CategoriesService();
    }

    public function homePage()
    {
       
        $categories = $this->categoriesService->get();
        return view('index', ["categories" => $categories]);
    }
}
