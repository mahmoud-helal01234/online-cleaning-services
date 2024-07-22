<?php

namespace App\Http\Controllers\Products;

use App\Http\Traits\ResponsesTrait;
use App\Http\Resources\CategoryCountriesResource;
use App\Http\Resources\CountryCategoriesResource;
use App\Http\Services\Products\CountriesCategoriesService;
use App\Http\Requests\CategoryInCountryRelation\StoreRequest;
use App\Http\Controllers\Controller;

class CountriesHaveCategoriesController extends Controller
{
    use ResponsesTrait;
    private $countriesCategoriesService;

    public function __construct()
    {
        $this->countriesCategoriesService = new CountriesCategoriesService();
    }

    public function getCategoryCountries($categoryId)
    {

        $countries = $this->countriesCategoriesService->getCategoryCountries($categoryId);
        return $this->apiResponse(CategoryCountriesResource::collection($countries));
    }

    public function getCountryCategories($countryId)
    {

        $categories = $this->countriesCategoriesService->getCountryCategories($countryId);
        return $this->apiResponse(CountryCategoriesResource::collection($categories));
    }

    public function addCategoryInCountry(StoreRequest $request)
    {

        $data = $request->validated();
        $this->countriesCategoriesService->addCategoryInCountry($data);

        return $this->apiResponse();
    }

    public function deleteCategoryInCountryRelation($id)
    {

        $this->countriesCategoriesService->deleteCategoryInCountryRelation($id);
        return $this->apiResponse(null,true,__('success.deleted'));
    }
}
