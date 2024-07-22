<?php

namespace App\Http\Services\Countries;

use App\Models\City;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Services\Countries\GovernoratesService;
use Illuminate\Http\Exceptions\HttpResponseException;

class CitiesService
{

    use ResponsesTrait;
    use LoggedInUserTrait;

    private $governatesService;
public function __construct() {
    $this->governatesService = new GovernoratesService();
}

    public function get($governorateId)
    {

        $cities = City::where('governorate_id', $governorateId)->orderBy('id', 'DESC')->get();

        return $cities;
    }

    public function getById($id)
    {

        $city = City::find($id);
        if ($city == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $city;
    }

    public function create($city)
    {

        try {

            City::create($city);

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newCity)
    {

        $city = $this->getById($newCity['id']);
        try {

            $city->update($newCity);
            return $city;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $city = $this->getById($id);
        try {

            $city->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $city = $this->getById($id);
        try {
            if($this->canUserDelete($city))
                $city->delete();
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
    public function canUserUpdate($cityId)
    {
        $user = $this->getLoggedInUser();
        $city = $this->getById($cityId);
        switch ($user->role) {
            case "admin":
                return true;
            case "country_manager":
                if($user->countryManager->country_id == $city->governorate->country_id)
                    return true;
                else
                    return false;
        }
    }
    public function canUserDelete($city)
    {
        $user = $this->getLoggedInUser();
        switch ($user->role) {
            case "admin":
                return true;
            case "country_manager":
                if($user->countryManager->country_id == $city->governorate->country_id)
                    return true;
                else
                throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
    }
}
    public function canUserCreate($governorateId)
    {
        $user = $this->getLoggedInUser();
        $governorate = $this->governatesService->getById($governorateId);

        switch ($user->role) {
            case "admin":
                return true;
            case "country_manager":
                if ($user->countryManager->country_id == $governorate->country_id)
                    return true;
        }
    }
}
