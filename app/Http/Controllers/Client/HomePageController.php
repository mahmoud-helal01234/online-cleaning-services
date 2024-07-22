<?php

namespace App\Http\Controllers\Client;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Client\HomePageService;

class HomePageController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $homePageService;

    public function __construct()
    {

        $this->homePageService = new HomePageService();
    }

    public function get()
    {

        $homePageContent = $this->homePageService->get();
        return $this->apiResponse($homePageContent);
    }

}
