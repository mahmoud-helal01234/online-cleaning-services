<?php

namespace App\Http\Services\Products;

use App\Models\Company;
use App\Models\Category;
use App\Http\Traits\ResponsesTrait;
use App\Models\CompaniesCategories;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompaniesCategoriesService
{

    use ResponsesTrait;

    public function getById($id)
    {

        $companyCategoryRelation = CompaniesCategories::find($id);

        if ($companyCategoryRelation == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $companyCategoryRelation;
    }

    public function getCategoryCompanies($categoryId)
    {


        // $data = [];
        // $categoryCompanies = $this->categoriesService->getById($categoryId)->companies;
        /**
         *
         *
         *$data['category_companies'] = Category::where('have_sub_categories' , 0)->whereHas('companies', function($query) use($categoryId){
             *    return $query->where('category_id', $categoryId);
             *})->get();
             */
            // if( $data['category_companies'] == [null]){
                //     throw new HttpResponseException($this->apiResponse("category have subcategory , or didnt have companies"));
                // }
            $data['category_companies'] = CompaniesCategories::with(['company.clientOrders.rate'])->where('category_id', $categoryId)->get();
            $data['companies_select'] = Company::companiesWithoutCategory($categoryId)->pluck('user_id','name_en');

            return $data;
    }

    public function getCategoriesCompanies($categoryId)
    {
        $data = CompaniesCategories::with(['company.clientOrders.rate', 'company.categories'])->where('category_id', $categoryId)->get();

        return $data;
    }

    public function getCategoriesWithCompaniesSelect()
    {

        // $data = [];
        // $categoryCompanies = $this->categoriesService->getById($categoryId)->companies;
        $data = Category::with(['companies' => function ($query){

            $query->select("user_id",
            "name_ar",
            "name_en");
        }])->select("id",
        "name_ar",
        "name_en")->get();

        return $data;
    }

    public function getCompanyCategories($companyId)
    {

        // $companyCategories = $this->companiesService->getById($companyId)->categories;
        $companyCategories = CompaniesCategories::with('category')->where('company_id', $companyId)->get();
        return $companyCategories;
    }


    public function addCategoryToCompany($data)
    {

        $createdCompanyCategoryRelation = CompaniesCategories::firstOrCreate($data, $data);
        return $createdCompanyCategoryRelation;
    }

    public function deleteCompanyCategoryRelation($id)
    {

        $companyCategory = $this->getById($id);
        $companyCategory->delete();
    }

    public function deleteChildren($categoryId = null , $companyId = null)
    {

        $compainesCategories = CompaniesCategories::where('category_id', $categoryId)->orWhere('company_id', $companyId)->get();
        foreach ($compainesCategories as $compainyCategory){

            $compainyCategory->delete();
        }
    }
}
