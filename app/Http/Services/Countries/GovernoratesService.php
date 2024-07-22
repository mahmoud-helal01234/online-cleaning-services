<?php

namespace App\Http\Services\Countries;

use App\Models\Governorate;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class GovernoratesService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;

    private $citiesService;
    public function get($countryId)
    {

        return Governorate::where('country_id', $countryId)->orderBy('id', 'DESC')->get();
    }

    public function getById($id)
    {

        $governorate = Governorate::find($id);
        if ($governorate == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $governorate;
    }

    public function create($governorate)
    {

        try {

            $createdGovernorate = Governorate::create($governorate);
            return $createdGovernorate;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newGovernorate)
    {

        $governorate = $this->getById($newGovernorate['id']);
        try {
            $governorate->update($newGovernorate);
            return $governorate;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $governorate = $this->getById($id);
        try {

            $governorate->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $governorate = $this->getById($id);
        try {
            if($this->canUserDelete($governorate)){
                    $governorate->cities()->delete();
                    $governorate->delete();
            }
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
    public function canUserCreate($countryId)
    {
        $user = $this->getLoggedInUser();
        switch ($user->role) {
            case "admin":
                return true;
            case "country_manager":
                if($user->countryManager->country_id == $countryId)
                    return true;
        }
    }
    public function canUserUpdate($governorateId)
    {

        // add country_manager case that he can only add or update only governorates the country_id that he manage
        $governorate = $this->getById($governorateId);
        $user = $this->getLoggedInUser();
        switch ($user->role) {
            case "admin":
                return true;
            case "country_manager":
                if($user->countryManager->country_id == $governorate->country_id)
                    return true;
        }
    }
    public function canUserDelete($governorate)
    {
        $user = $this->getLoggedInUser();
        if ($user->role == "admin"|| $user->countryManager->country_id == $governorate->country_id)
            return true;
        else
           return false;
    }
    public function deleteChildren($countreId){
        $governorates = Governorate::where('country_id', $countreId)->get();
        //dd($governorate);
        foreach ($governorates as $governorate) {
            $governorate->cities()->delete();
            $governorate->delete();
        }
    }
}
