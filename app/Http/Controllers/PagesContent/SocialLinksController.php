<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\SocialLink\StoreRequest;
use App\Http\Requests\SocialLink\UpdateRequest;
use App\Http\Services\PagesContent\SocialLinksService;

class SocialLinksController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $socialLinksService;

    public function __construct()
    {

        $this->socialLinksService = new SocialLinksService();
    }


    public function get(){

        $socialLinks = $this->socialLinksService->get();
        return $this->apiResponse($socialLinks );
    }

    public function create(StoreRequest $request)
    {

        $socialLink = $request->validated();
        $createdSocialLink = $this->socialLinksService->create($socialLink);
        return $this->apiResponse($createdSocialLink);
    }

    public function update(UpdateRequest $request)
    {

        $socialLink = $request->validated();

        $updatedSocialLink = $this->socialLinksService->update($socialLink);

        return $this->apiResponse($updatedSocialLink);

    }

    public function delete($id)
    {

        $this->socialLinksService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}
