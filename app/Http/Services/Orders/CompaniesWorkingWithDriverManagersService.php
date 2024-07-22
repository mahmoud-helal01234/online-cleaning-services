<?php

namespace App\Http\Services\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Models\CompaniesWorkingWithDriverManager;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompaniesWorkingWithDriverManagersService
{

    use ResponsesTrait;

    public function getById($id)
    {

        $companyWorkingWithDriverManagerRelation = CompaniesWorkingWithDriverManager::find($id);
        if ($companyWorkingWithDriverManagerRelation == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $companyWorkingWithDriverManagerRelation;
    }

    public function get($driversManagerId = null,$companyId = null)
    {

        $driversManagersWorkingWithCompanies = CompaniesWorkingWithDriverManager::with(['company.user:id,name','driversManager.user:id,name'])->when($driversManagerId != null,function ($query) use ($driversManagerId){
            $query->where('drivers_manager_id', $driversManagerId);
        })->when($companyId != null,function ($query) use ($companyId){
            $query->where('company_id', $companyId);
        })->select('id','company_id','drivers_manager_id','created_at')->get();
        return $driversManagersWorkingWithCompanies;
    }

    public function getCompaniesWorkingWithDriverManager($driverManagerId)
    {

        $driverManagerCompanies = CompaniesWorkingWithDriverManager::with(['company:user_id,name_ar,name_en,logo_path'])->where('drivers_manager_id', $driverManagerId)->select('id','company_id','created_at')->get();
        return $driverManagerCompanies;
    }

    public function getDriverManagersWorkingWithCompany($companyId)
    {


        $companyDriverManagers = CompaniesWorkingWithDriverManager::with(['driversManager:user_id','driversManager.user:id,name'])->where('company_id', $companyId)->select('created_at','drivers_manager_id')->get();
        return $companyDriverManagers;
    }

    public function addDriversManagerWorkingWithCompanyRelation($data)
    {

        CompaniesWorkingWithDriverManager::firstOrCreate($data, $data);

    }

    public function deleteDriversManagerWorkingWithCompanyRelation($id)
    {

        $driverManagerWorkingWithCompanyRelation = $this->getById($id);
        $driverManagerWorkingWithCompanyRelation->delete();
    }

    public function isDriversManagerWorkingWithCompany($driversManagerId,$companyId){

        return CompaniesWorkingWithDriverManager::where('drivers_manager_id',$driversManagerId)->where('company_id',$companyId)->count() > 0;
    }
    public function deleteChildren($driversManagerId = null , $companyId = null)
    {

        $compainesWorkingWithDriversManager = CompaniesWorkingWithDriverManager::where('drivers_manager_id', $driversManagerId)->orWhere('company_id', $companyId)->get();
        foreach ($compainesWorkingWithDriversManager as $compnayWorkingWithDriversManager) {

            $compnayWorkingWithDriversManager->delete();
        }
    }
}
