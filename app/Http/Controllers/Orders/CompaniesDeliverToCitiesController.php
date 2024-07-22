<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Services\Orders\CompaniesDeliverToCitiesService;
use App\Http\Resources\CompaniesDeliverToCityResource;
use App\Http\Requests\CompanyDeliverToCityRelation\StoreRequest;
use App\Http\Controllers\Controller;

class CompaniesDeliverToCitiesController extends Controller
{

    use ResponsesTrait;
    private $companiesDeliverToCitiesService;

    public function __construct()
    {
        $this->companiesDeliverToCitiesService = new CompaniesDeliverToCitiesService();
    }

    public function getCitiesDeliveredByCompany($companyId)
    {

        $cities = $this->companiesDeliverToCitiesService->getCitiesDeliveredByCompany($companyId);
        return $this->apiResponse($cities);
    }

    public function getCompaniesDeliverToCity($cityId)
    {

        $categories = $this->companiesDeliverToCitiesService->getCompaniesDeliverToCity($cityId);
        return $this->apiResponse(CompaniesDeliverToCityResource::collection($categories));
    }

    public function addCompanyDeliverToCityRelation(StoreRequest $request)
    {

        $data = $request->validated();
        $this->companiesDeliverToCitiesService->addCompanyDeliverToCityRelation($data);

        return $this->apiResponse();
    }

    public function deleteCompanyDeliverToCityRelation($id)
    {

        $this->companiesDeliverToCitiesService->deleteCompanyDeliverToCityRelation($id);
        return $this->apiResponse(null, true, __('success.deleted'));
    }
}

