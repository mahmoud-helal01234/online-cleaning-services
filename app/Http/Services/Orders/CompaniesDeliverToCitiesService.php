<?php

namespace App\Http\Services\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Models\CompaniesDeliverToCities;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompaniesDeliverToCitiesService
{

    use ResponsesTrait;

    public function getById($id)
    {

        $companyDeliverToCityRelation = CompaniesDeliverToCities::find($id);

        if ($companyDeliverToCityRelation == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $companyDeliverToCityRelation;
    }

    public function getCompaniesDeliverToCity($cityId)
    {

        $cityCompanies = CompaniesDeliverToCities::with(['company', 'company.user'])->where('city_id', $cityId)->get();
        return $cityCompanies;
    }

    public function getCitiesDeliveredByCompany($companyId)
    {

        $companyCities = CompaniesDeliverToCities::with('city:id,name_ar,name_en')->where('company_id', $companyId)->select('id','city_id','created_at')->get();
        return $companyCities;
    }

    public function addCompanyDeliverToCityRelation($data)
    {

        $createdCityToCompanyDeliverToRelation = CompaniesDeliverToCities::firstOrCreate($data, $data);
        return $createdCityToCompanyDeliverToRelation;
    }

    public function deleteCompanyDeliverToCityRelation($id)
    {

        $cityToCompanyDeliverToRelation = $this->getById($id);
        $cityToCompanyDeliverToRelation->delete();
    }
}
