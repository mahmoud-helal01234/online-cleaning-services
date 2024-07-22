<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\NavbarFooterContent\UpdateRequest;
use App\Http\Services\PagesContent\NavbarFooterContentService;

class NavbarFooterContentController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $navbarFooterContentService;

    public function __construct()
    {

        $this->navbarFooterContentService = new NavbarFooterContentService();
    }

    public function get()
    {

        $navbarFooterContent = $this->navbarFooterContentService->get();
        return $this->apiResponse($navbarFooterContent);
    }

    public function update(UpdateRequest $request)
    {

        $navbarFooterContent = $request->validated();
        $this->navbarFooterContentService->update($navbarFooterContent);
        return $this->apiResponse();
    }

}
