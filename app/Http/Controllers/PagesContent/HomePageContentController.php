<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\HomePageContent\UpdateRequest;
use App\Http\Services\PagesContent\HomePageContentService;

class HomePageContentController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $homePageContentService;

    public function __construct()
    {

        $this->homePageContentService = new HomePageContentService();
    }

    public function get()
    {
       
        $homePageContent = $this->homePageContentService->get();
        return $this->apiResponse($homePageContent);
    }

    public function update(UpdateRequest $request)
    {

        $homePageContent = $request->validated();
        $updatedHomePageContent = $this->homePageContentService->update($homePageContent);
        return $this->apiResponse($updatedHomePageContent);
    }

}
