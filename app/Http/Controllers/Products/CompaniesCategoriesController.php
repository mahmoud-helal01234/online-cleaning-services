<?php

namespace App\Http\Controllers\Products;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyOrderRateResource;
use App\Http\Resources\CompanyCategoriesResource;
use App\Http\Services\Products\CompaniesCategoriesService;
use App\Http\Requests\Category\AddCategoryToCompanyRequest;

class CompaniesCategoriesController extends Controller
{
    use ResponsesTrait;
    private $companiesCategoriesService;

    public function __construct()
    {
        $this->companiesCategoriesService = new CompaniesCategoriesService();
    }

    public function getCategoryCompanies($categoryId)
    {
        $companies = $this->companiesCategoriesService->getCategoryCompanies($categoryId);
        return $this->apiResponse(CompanyOrderRateResource::collection($companies['category_companies']),$companies['companies_select']);
    }

    public function getCategoriesCompanies($categoryId)
    {

        $companiesData = $this->companiesCategoriesService->getCategoriesCompanies($categoryId);
        return $this->apiResponse(status: true, data: CompanyOrderRateResource::collection($companiesData));

    }

    public function getCategoriesWithCompaniesSelect()
    {

        $categoriesWithCompaniesSelect = $this->companiesCategoriesService->getCategoriesWithCompaniesSelect();
        return $this->apiResponse($categoriesWithCompaniesSelect);
    }

    public function getCompanyCategories($companyId)
    {

        $categories = $this->companiesCategoriesService->getCompanyCategories($companyId);
        return $this->apiResponse(CompanyCategoriesResource::collection($categories));
    }

    public function addCategoryToCompany(AddCategoryToCompanyRequest $request)
    {

        $data = $request->validated();
        $this->companiesCategoriesService->addCategoryToCompany($data);

        return $this->apiResponse();
    }

    public function deleteCompanyCategoryRelation($id)
    {

        $this->companiesCategoriesService->deleteCompanyCategoryRelation($id);
        return $this->apiResponse(null,true,__('success.deleted'));
    }
}
