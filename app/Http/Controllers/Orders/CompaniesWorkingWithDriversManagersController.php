<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Services\Orders\CompaniesWorkingWithDriverManagersService;
use App\Http\Requests\CompanyWorkingWithDriversManagerRelation\StoreRequest;
use App\Http\Controllers\Controller;

class CompaniesWorkingWithDriversManagersController extends Controller
{

    use ResponsesTrait;
    private $companiesWorkingWithDriverManagersService;

    public function __construct()
    {
        $this->companiesWorkingWithDriverManagersService = new CompaniesWorkingWithDriverManagersService();
    }

    public function get()
    {

        $driversManagersWorkingWithCompanies = $this->companiesWorkingWithDriverManagersService->get(driversManagerId: request('drivers_manager_id'), companyId: request('company_id'));
        return $this->apiResponse($driversManagersWorkingWithCompanies);
    }

    public function getCompaniesWorkingWithDriversManager($driverManagerId)
    {

        $driverManagerCompanies = $this->companiesWorkingWithDriverManagersService->getCompaniesWorkingWithDriverManager($driverManagerId);
        return $this->apiResponse($driverManagerCompanies);
    }

    public function getDriverManagersWorkingWithCompany($companyId)
    {

        $companyDriverManagers = $this->companiesWorkingWithDriverManagersService->getDriverManagersWorkingWithCompany($companyId);
        return $this->apiResponse($companyDriverManagers);
    }

    public function addDriversManagerWorkingWithCompanyRelation(StoreRequest $request)
    {

        $data = $request->validated();
        $this->companiesWorkingWithDriverManagersService->addDriversManagerWorkingWithCompanyRelation($data);

        return $this->apiResponse(message: __('success.added'));
    }

    public function deleteDriversManagerWorkingWithCompanyRelation($id)
    {

        $this->companiesWorkingWithDriverManagersService->deleteDriversManagerWorkingWithCompanyRelation($id);
        return $this->apiResponse(null, true, __('success.deleted'));
    }
}
