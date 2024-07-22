<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\AboutUsContent\UpdateRequest;
use App\Http\Services\PagesContent\AboutUsContentService;

class AboutUsContentController extends Controller
{

    use ResponsesTrait;

    use FileUploadTrait;
    private $aboutUsContentService;

    public function __construct()
    {

        $this->aboutUsContentService = new AboutUsContentService();
    }

    public function get()
    {

        $aboutUsContent = $this->aboutUsContentService->get();
        return $this->apiResponse($aboutUsContent);
    }

    public function update(UpdateRequest $request)
    {

        $aboutUsContent = $request->validated();
        $this->aboutUsContentService->update($aboutUsContent);
        return $this->apiResponse();
    }

}
