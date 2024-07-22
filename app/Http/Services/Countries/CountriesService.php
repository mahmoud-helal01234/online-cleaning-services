<?php

namespace App\Http\Services\Countries;

use App\Models\Country;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class CountriesService{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;
    private $governorateService;
    public function get(){

        return Country::orderBy('id', 'DESC')->get();
    }

    public function getById($id){

        $country = Country::find($id);
        if($country == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $country;
    }

    public function create($country){

        try{

            $createdCountry = Country::create($country);
            return $createdCountry;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function toggleActivation($id, $activationStatus){

        $country = $this->getById($id);
        try{

            $country->update(['active' => $activationStatus]);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newCountry){
        $country = $this->getById($newCountry['id']);

        try{

            $country->update($newCountry);
            return $country;

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $country = $this->getById($id);

        try{

            $this->deleteChildren($country);
            $country->delete();
            /// WE USE SOFT DELETES AND MAY RESTORED
            //$imgPath = $country->img_path;
            //$this->deleteFile($imgPath);

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
    public function deleteChildren($country){
        //$country->governorates()->delete();
        $this->governorateService = new GovernoratesService;
        $this->governorateService->deleteChildren($country->id);
    }

}
