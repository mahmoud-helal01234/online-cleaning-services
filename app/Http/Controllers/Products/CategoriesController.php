<?php

namespace App\Http\Controllers\Products;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Products\CategoriesService;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $categoriesService;
    public function __construct()
    {

        $this->categoriesService = new CategoriesService();

    }

    public function get()
    {

        $categories = $this->categoriesService->get(request('main_category_id'));
        return $this->apiResponse($categories);
    }
    public function categoryParent($categoryId)
    {

        $categoryParent = $this->categoriesService->categoryParent($categoryId);
        return $this->apiResponse($categoryParent);
    }
    public function getCategoriesWithSubcategories()
    {

        $categoryWithSub = $this->categoriesService->getCategoriesWithSubcategories();
        return $this->apiResponse($categoryWithSub);
    }
    public function selectCategories()
    {

        $categories = $this->categoriesService->selectCategories(companyId:request('company_id'), haveSubCategories:request('have_sub_categories'), parentId:request('parent_id'));
        return $this->apiResponse($categories);
    }

    public function create(StoreRequest $request)
    {

        $category = $request->validated();
        $this->categoriesService->create($category);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $category = $request->validated();
        $this->categoriesService->update($category);
        return $this->apiResponse();
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


