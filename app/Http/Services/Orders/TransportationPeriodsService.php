<?php

namespace App\Http\Services\Orders;

use App\Http\Services\Users\UsersService;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Models\TransportationPeriod;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Services\Orders\TransportationPeriodsAssignedToDriversService;

class TransportationPeriodsService
{

    use ResponsesTrait;
    use FileUploadTrait, LoggedInUserTrait;

    public function get($userId = null)
    {

        $loggedInUser = $this->getLoggedInUser();
        $transportationPeriods = TransportationPeriod::query();
        switch ($loggedInUser->role) {
            case "admin":
                $transportationPeriods = $transportationPeriods->where('user_id',$userId);
                break;
            case "country_manager":
                $transportationPeriods = $transportationPeriods->where('user_id',$userId)->where(function ($query) use ($loggedInUser){
                    $query->whereHas('user.driversManager' ,function ($query) use ($loggedInUser){
                        $query->where('country_id',$loggedInUser->countryManager->country_id);
                    })->orWhereHas('user.company' ,function ($query) use ($loggedInUser){
                        $query->where('country_id',$loggedInUser->company->country_id);
                    });
                });
                break;
            case "company":
                case "drivers_manager":
                $transportationPeriods = $transportationPeriods->where('user_id',$loggedInUser->id);
                break;
            case "client":
                $transportationPeriods = $transportationPeriods->where('active',1);
                break;
            default:
            $transportationPeriods = $transportationPeriods->where('user_id',$loggedInUser->id);

        }

        $transportationPeriods = $transportationPeriods->with(['drivers' => function ($query){

            $query->with(['driver' => function ($query){

                $query->with(['user' => function ($query){

                    $query->select('name','id','phone');
                }])->select('user_id');

            }])->select('driver_id','id','transportation_period_id','capacity')->where('active',1);
        }]);
        return $transportationPeriods->orderBy('from')->get();
    }

    public function getById($id)
    {

        $transportationPeriod = TransportationPeriod::find($id);
        if ($transportationPeriod == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $transportationPeriod;
    }

    public function create($transportationPeriod)
    {

        try {

            $loggedInUser = $this->getLoggedInUser();
            if ($loggedInUser->role != "admin" && $loggedInUser->role != "country_manager")
                $transportationPeriod['user_id'] = $loggedInUser->id;

            $createdTransportationPeriod = TransportationPeriod::create($transportationPeriod);

            return $createdTransportationPeriod;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
        }
    }

    public function update($newTransportationPeriod)
    {

        $transportationPeriod = $this->getById($newTransportationPeriod['id']);
        try {

            $transportationPeriod->update($newTransportationPeriod);
            return $transportationPeriod;

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
        }
    }

    public function delete($id)
    {

        $transportationPeriod = $this->getById($id);


        if(!$this->canLoggedInUserDeleteTransortationPeriod($id))
            throw new HttpResponseException($this->apiResponse(null, false, __('This transportation period does not belong to you')));
        try {
            $transportationPeriod->delete();
            $transportationPeriodsAssignedToDriversService = new TransportationPeriodsAssignedToDriversService();
            $transportationPeriodsAssignedToDriversService->deleteForTransportationPeriodId($transportationPeriod->id);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $transportationPeriod = $this->getById($id);
        try {

            $transportationPeriod->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function canLoggedInUserUpdateTransortationPeriod($transportationPeriodId)
    {

        $loggedInUser = $this->getLoggedInUser();
        $transportationPeriod = $this->getById($transportationPeriodId);
        switch ($loggedInUser->role) {
            case "admin":
                return true;
            case "country_manager":

                if ($transportationPeriod->user->role == "company")
                    return $transportationPeriod->user->company->country_id == $loggedInUser->countryManager->country_id;
                else if ($transportationPeriod->user->role == "drivers_manager")
                    return $transportationPeriod->user->driversManager->country_id == $loggedInUser->countryManager->country_id;

                break;
            default:
                return $transportationPeriod->user_id == $loggedInUser->id;

        }
        return false;
    }

    public function canUserIdHaveTransportationPeriod($userId = null)
    {

        if ($userId == null)
            return true;
        $usersService = new UsersService();
        $user = $usersService->getById($userId);

        switch ($user->role) {
            case "client":
            case "driver":

                return false;
            default:
                return true;

        }

    }

    public function canLoggedInUserAddTransortationPeriodToUserId($userId = null)
    {

        // if null then no userId specified and the transportationPeriod 'll be assigned to the loggedInUserId
        if ($userId == null)
            return true;

        $loggedInUser = $this->getLoggedInUser();
        $usersService = new UsersService();
        $user = $usersService->getById($userId);
        switch ($loggedInUser->role) {
            case "admin":

                return true;

            case "country_manager":

                if ($user->role == "company")
                    return $user->company->country_id == $loggedInUser->countryManager->country_id;
                else if ($user->role == "drivers_manager")
                    return $user->driversManager->country_id == $loggedInUser->countryManager->country_id;

                break;
            default:
                return  $loggedInUser->id == $userId;

        }
        return false;
    }
    public function canLoggedInUserDeleteTransortationPeriod($transportationPeriodId)
    {
        $tansportationPeriod = $this->getById($transportationPeriodId);
        $loggedInUser = $this->getLoggedInUser();
        switch ($loggedInUser->role) {
            case "admin":
                return true;
            default:
                return $tansportationPeriod->user_id == $loggedInUser->id;
        }
    }



}
