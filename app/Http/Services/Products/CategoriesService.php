<?php

namespace App\Http\Services\Products;

use Exception;
use App\Models\Category;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Services\Products\CompaniesCategoriesService;

class CategoriesService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;

    private $companiesCategoriesService;
    private $proudctsService;
    public function get()
    {

        Log::info("start get categories");


        $categories = Category::select('categories.id', 'name_ar', 'name_en', 'img_path')
            ->get();
        return $categories;
    }



    public function getById($id)
    {

        Log::info("start get category by id");


        $category = Category::find($id);

        if ($category == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $category;
    }



    public function create($category)
    {

        try {
            Log::info("start create category");

            Category::create($category);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }


    public function update($newCategory)
    {

        Log::info("start update category");

        $category = $this->getById($newCategory['id']);


        try {
            $category->update($newCategory);
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

            $this->deleteRelationsWithCategory($category->id);
            $category->delete();

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

    public function deleteRelationsWithCategory($categoryId)
    {

        $this->proudctsService = new ProductsService;
        $this->proudctsService->deleteChildren(categoryId: $categoryId);
    }
}
