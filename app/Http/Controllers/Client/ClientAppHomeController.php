<?php

namespace App\Http\Controllers\Client;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\Client\ClientAppHomeService;
use App\Http\Traits\FileUploadTrait;

class ClientAppHomeController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $clientAppHomeService;

    public function __construct()
    {

        $this->clientAppHomeService = new ClientAppHomeService();
    }

    public function get()
    {

        $offersPageContent = $this->clientAppHomeService->get();
        return $this->apiResponse($offersPageContent);
    }

}
