<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\HomeSliderImage\StoreRequest;
use App\Http\Requests\HomeSliderImage\UpdateRequest;
use App\Http\Services\PagesContent\HomeSliderImagesService;

class HomeSliderImageController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $homeSliderImagesService;
    public function __construct()
    {

        $this->homeSliderImagesService = new HomeSliderImagesService();

    }

    public function get()
    {

        $homeSliderImages = $this->homeSliderImagesService->get();
        return $this->apiResponse($homeSliderImages);
    }

    public function create(StoreRequest $request)
    {

        $homeSliderImage = $request->validated();
        $this->homeSliderImagesService->create($homeSliderImage);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $homeSliderImage = $request->validated();
        $this->homeSliderImagesService->update($homeSliderImage);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->homeSliderImagesService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}


