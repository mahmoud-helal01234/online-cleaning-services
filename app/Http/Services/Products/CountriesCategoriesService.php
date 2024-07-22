<?php

namespace App\Http\Services\Products;

use App\Models\CountryCategory;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class CountriesCategoriesService
{

    use ResponsesTrait;

    public function getById($id)
    {

        $countryCategoryRelation = CountryCategory::find($id);

        if ($countryCategoryRelation == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $countryCategoryRelation;
    }

    public function getCategoryCountries($categoryId)
    {

        // $categoryCountries = $this->categoriesService->getById($categoryId)->countries;
        $categoryCountries = CountryCategory::with('country')->where('category_id', $categoryId)->get();
        return $categoryCountries;
    }

    public function getCountryCategories($countryId)
    {

        // $countryCategories = $this->countriesService->getById($countryId)->categories;
        $countryCategories = CountryCategory::with('category')->where('country_id', $countryId)->get();
        return $countryCategories;
    }

    public function addCategoryInCountry($data)
    {

        $createdCountryCategoryRelation = CountryCategory::firstOrCreate($data, $data);
        return $createdCountryCategoryRelation;
    }

    public function deleteCategoryInCountryRelation($id)
    {

        $countryCategory = $this->getById($id);
        $countryCategory->delete();
    }

}
