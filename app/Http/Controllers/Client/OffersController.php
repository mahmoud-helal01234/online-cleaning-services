<?php

namespace App\Http\Controllers\Client;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Client\OffersService;

class OffersController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $offersService;

    public function __construct()
    {

        $this->offersService = new OffersService();
    }

    public function get()
    {

        $offersPageContent = $this->offersService->get();
        return $this->apiResponse($offersPageContent);
    }

}
