<?php

namespace App\Http\Services\Rates;

use App\Models\BaseCompaniesRate;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseCompaniesRatesService {

    use ResponsesTrait;
    use FileUploadTrait;

    public function get(){

        $baseCompaniesRates = BaseCompaniesRate::get();

        return $baseCompaniesRates;
    }

    public function getById($id){

        $baseCompaniesRate = BaseCompaniesRate::find($id);

        if($baseCompaniesRate == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $baseCompaniesRate;
    }

    public function create($baseCompaniesRate){

        try{

            BaseCompaniesRate::create($baseCompaniesRate);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newBaseCompaniesRate){

        $baseCompaniesRate = $this->getById($newBaseCompaniesRate['id']);
        try{

            $baseCompaniesRate->update($newBaseCompaniesRate);

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $baseCompaniesRate = $this->getById($id);

        try{

            $baseCompaniesRate->delete();
        } catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

}
