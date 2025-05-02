<?php

namespace App\Http\Services\Products;

use Exception;
use App\Models\MainCategory;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Services\Products\CategoriesService;

class MainCategoriesService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;

    private $companiesMainCategoriesService;
    private $categoriesService;
    public function get()
    {

        Log::info("start get categories");


        $categories = MainCategory::with('categories.products.options')
            ->get();
        return $categories;
    }



    public function getById($id)
    {

        Log::info("start get category by id");


        $category = MainCategory::find($id);

        if ($category == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $category;
    }



    public function create($category)
    {

        try {
            Log::info("start create category");

            MainCategory::create($category);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }


    public function update($newMainCategory)
    {

        Log::info("start update category");

        $category = $this->getById($newMainCategory['id']);


        try {
            $category->update($newMainCategory);
            return $category;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        Log::info("start toggleActivation category");

        $category = $this->getById($id);
        try {

            $category->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function delete($id)
    {

        Log::info("start delete category");

        $category = $this->getById($id);

        try {

            $this->deleteRelationsWithMainCategory($category->id);
            $category->delete();

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

    public function deleteRelationsWithMainCategory($mainCategoryId)
    {

        $this->categoriesService = new CategoriesService;
        $this->categoriesService->deleteChildren(mainCategoryId: $mainCategoryId);
    }
}
