<?php

namespace App\Http\Controllers\Products;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Products\MainCategoriesService;
use App\Http\Requests\MainCategory\StoreRequest;
use App\Http\Requests\MainCategory\UpdateRequest;
use App\Http\Controllers\Controller;

class MainCategoriesController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $categoriesService;
    public function __construct()
    {

        $this->categoriesService = new MainCategoriesService();

    }

    public function get()
    {

        $categories = $this->categoriesService->get();
        return $this->apiResponse($categories);
    }

    public function create(StoreRequest $request)
    {

        $mainCategory = $request->validated();
        $createdMainCategory = $this->categoriesService->create($mainCategory);
        return $this->apiResponse($createdMainCategory);
    }

    public function update(UpdateRequest $request)
    {

        $mainCategory = $request->validated();
        $updatedMainCategory = $this->categoriesService->update($mainCategory);
        return $this->apiResponse($updatedMainCategory);
    }

    public function delete($id)
    {

        $this->categoriesService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->categoriesService->toggleActivation($id, $activationStatus);
        return $this->apiResponse();
    }

}


