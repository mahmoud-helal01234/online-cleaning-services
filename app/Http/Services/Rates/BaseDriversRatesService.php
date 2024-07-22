<?php

namespace App\Http\Services\Rates;

use App\Models\BaseDriversRate;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseDriversRatesService {

    use ResponsesTrait;
    use FileUploadTrait;

    public function get(){

        $baseDriversRates = BaseDriversRate::get();

        return $baseDriversRates;
    }

    public function getById($id){

        $baseDriversRates = BaseDriversRate::find($id);

        if($baseDriversRates == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $baseDriversRates;
    }

    public function create($baseDriversRates){

        try{

            BaseDriversRate::create($baseDriversRates);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newBaseDriversRates){

        $baseDriversRates = $this->getById($newBaseDriversRates['id']);
        try{

            $baseDriversRates->update($newBaseDriversRates);

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $baseDriversRates = $this->getById($id);

        try{

            $baseDriversRates->delete();
        } catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

}
