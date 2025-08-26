<?php

namespace App\Http\Controllers\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\FloatingSocialLink\StoreRequest;
use App\Http\Requests\FloatingSocialLink\UpdateRequest;
use App\Http\Services\PagesContent\FloatingSocialLinksService;

class FloatingSocialLinksController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;
    private $floatingSocialLinksService;

    public function __construct()
    {

        $this->floatingSocialLinksService = new FloatingSocialLinksService();
    }


    public function get(){

        $floatingSocialLinks = $this->floatingSocialLinksService->get();
        return $this->apiResponse($floatingSocialLinks );
    }

    public function create(StoreRequest $request)
    {

        $floatingSocialLink = $request->validated();
        $createdFloatingSocialLink = $this->floatingSocialLinksService->create($floatingSocialLink);
        return $this->apiResponse($createdFloatingSocialLink);
    }

    public function update(UpdateRequest $request)
    {

        $floatingSocialLink = $request->validated();

        $updatedFloatingSocialLink = $this->floatingSocialLinksService->update($floatingSocialLink);

        return $this->apiResponse($updatedFloatingSocialLink);

    }

    public function delete($id)
    {

        $this->floatingSocialLinksService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}
