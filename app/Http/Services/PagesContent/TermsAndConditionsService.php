<?php

namespace App\Http\Services\PagesContent;

use App\Models\TermsAndConditions;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class TermsAndConditionsService {

    use ResponsesTrait;

    public function get(){

        $termsAndConditions = TermsAndConditions::select('title_ar','title_en','description_ar','description_en')->first();

        return $termsAndConditions;
    }

    public function update($newTermsAndConditions){

        try{

            $termsAndConditions = TermsAndConditions::updateOrCreate(['id' => 1],$newTermsAndConditions);
            return $termsAndConditions;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

}
