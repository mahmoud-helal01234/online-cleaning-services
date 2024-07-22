<?php

namespace App\Http\Controllers\Users;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Requests\Company\ClientRateCompany;
use App\Http\Services\Users\CompaniesService;
use App\Http\Requests\Company\StoreRequest;
use App\Http\Requests\Company\UpdateRequest;
use App\Http\Services\Products\CompaniesCategoriesService;
use App\Http\Controllers\Controller;

class CompaniesController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $companiesCategoriesService;
    private $companiesService;
    public function __construct()
    {

        $this->companiesService = new CompaniesService();

        $this->companiesCategoriesService = new CompaniesCategoriesService();
    }

    public function getCompanyRates()
    {

        $data = $this->companiesService->getCompanyRates(request('company_id'));
        return $this->apiResponse($data);
    }

    public function get()
    {

    $data = $this->companiesService->get(categoryId: request('category_id'), countryId: request('country_id'), companyId: request('company_id'), cityId: request('city_id'));
        return $this->apiResponse($data);
    }

    public function create(StoreRequest $request)
    {
        $company = $request->validated();
        $this->companiesService->create($company);
        return $this->apiResponse();
    }

    public function createClientRate(ClientRateCompany $request)
    {

        $data = $request->validated();
        $this->companiesService->createClientRate($data);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request){

        $company = $request->validated();
        $this->companiesService->update($company);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->companiesService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }


}
