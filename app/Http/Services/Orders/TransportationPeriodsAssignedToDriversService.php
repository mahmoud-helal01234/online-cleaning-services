<?php

namespace App\Http\Services\Orders;

use Exception;
use App\Models\Order;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Services\Users\DriversService;
use App\Http\Services\Users\DriversManagersService;
use App\Models\TransportationPeriodAssignedToDriver;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Services\Orders\CompaniesWorkingWithDriverManagersService;
use App\Models\TransportationPeriod;

class TransportationPeriodsAssignedToDriversService
{

    use ResponsesTrait;
    use FileUploadTrait, LoggedInUserTrait;
    private $driversService;

    public function __construct(){
        $this->driversService = new DriversService();
    }


    public function getByTransportationPeriodId($transportationPeriodId)
    {
        $loggedInUser = $this->getLoggedInUser();
        $transportationPeriodsAssignedToDrivers = TransportationPeriodAssignedToDriver::query();
        switch ($loggedInUser->role) {
            case "admin":
                $transportationPeriodsAssignedToDrivers = $transportationPeriodsAssignedToDrivers->where('transportation_period_id',$transportationPeriodId);
                break;
            case "company":
                case "drivers_manager":
                $transportationPeriodsAssignedToDrivers = $transportationPeriodsAssignedToDrivers->where('transportation_period_id',$transportationPeriodId)->whereHas('transportationPeriod' , function ($query) use ($loggedInUser){
                    $query->where('user_id',$loggedInUser->id);
                });
                break;
            default:
                $transportationPeriodsAssignedToDrivers = $transportationPeriodsAssignedToDrivers->where('transportation_period_id',$transportationPeriodId)->whereHas('transportationPeriod' , function ($query) use ($loggedInUser){
                    $query->where('user_id',$loggedInUser->id);
                });

        }

        $transportationPeriodsAssignedToDrivers = $transportationPeriodsAssignedToDrivers->with(['transportationPeriod.drivers' => function ($query){

            $query->with(['driver' => function ($query){

                $query->with(['user' => function ($query){

                    $query->select('name','id','phone');
                }])->select('user_id');

            }])->select('driver_id','id','transportation_period_id','capacity')->where('active',1);
        }]);
        return $transportationPeriodsAssignedToDrivers->get();
    }

    public function get()
    {
        $loggedInUser = $this->getLoggedInUser();
        $transportationPeriodsAssignedToDrivers = TransportationPeriodAssignedToDriver::query();
        switch ($loggedInUser->role) {
            case "company":
                case "drivers_manager":
                $transportationPeriodsAssignedToDrivers = $transportationPeriodsAssignedToDrivers->whereHas('transportationPeriod' , function ($query) use ($loggedInUser){
                    $query->where('user_id',$loggedInUser->id);
                });
                break;
            default:
                $transportationPeriodsAssignedToDrivers = $transportationPeriodsAssignedToDrivers->whereHas('transportationPeriod' , function ($query) use ($loggedInUser){
                    $query->where('user_id',$loggedInUser->id);
                });
        }
        $transportationPeriodsAssignedToDrivers = $transportationPeriodsAssignedToDrivers->with(['transportationPeriod.drivers' => function ($query){

            $query->with(['driver' => function ($query){

                $query->with(['user' => function ($query){

                    $query->select('name','id','phone');
                }])->select('user_id');

            }])->select('driver_id','id','transportation_period_id','capacity')->where('active',1);
        }]);
        return $transportationPeriodsAssignedToDrivers->get();

    }
    public function selectPeriodsWithCapacity($userId, $date){

        // transportation periods with drivers for companyId
        // and for each driver we need capacity that

        // remaining_capacity = transportation_periods_assigned_to_drivers.capacity in date - orders for this driver in date and transportation_period

         $transportationPeriodsWithDrivers = TransportationPeriod::where('user_id',$userId)->with('drivers.driver.user')->get();
        $pickupTransportationPeriodAssignedToDriversWithCapacities =
        Order::where(function ($query) use ($userId){
            $query->where("role",'drivers_app')->whereHas('driversAppOrder',function ($query) use($userId){
                $query->where('user_id',$userId);
            });
        })->orWhere(function ($query) use($userId){
            $query->where("role",'client')->whereHas('clientOrder',function ($query) use($userId){
                $query->where('company_id',$userId);
            });
        })
        ->where('pickup_date',$date)
        ->groupBy('pickup_driver_assigned_to_transportation_period_id')
        ->whereNotNull("pickup_driver_assigned_to_transportation_period_id")
        ->selectRaw('count(*) as capacity, pickup_driver_assigned_to_transportation_period_id')
        ->get();

        $deliveryTransportationPeriodAssignedToDriversWithCapacities =
        Order::where(function ($query) use($userId){
            $query->where("role",'drivers_app')->whereHas('driversAppOrder',function ($query) use($userId){
                $query->where('user_id',$userId);
            });
        })->orWhere(function ($query) use($userId){
            $query->where("role",'client')->whereHas('clientOrder',function ($query) use($userId){
                $query->where('company_id',$userId);
            });
        })->where('delivery_date',$date)->whereNotNull("delivery_driver_assigned_to_transportation_period_id")
        ->groupBy('delivery_driver_assigned_to_transportation_period_id')
        ->selectRaw('count(*) as capacity, delivery_driver_assigned_to_transportation_period_id')->get();

        $transportationPeriodAssignedToDriversWithCapacities = [];
        foreach($pickupTransportationPeriodAssignedToDriversWithCapacities as $pickupTransportationPeriodAssignedToDriversWithCapacity){
            $transportationPeriodAssignedToDriversWithCapacities[$pickupTransportationPeriodAssignedToDriversWithCapacity->pickup_driver_assigned_to_transportation_period_id] = $pickupTransportationPeriodAssignedToDriversWithCapacity->capacity;

        }

        foreach($deliveryTransportationPeriodAssignedToDriversWithCapacities as $deliveryTransportationPeriodAssignedToDriversWithCapacity){

            if(isset($transportationPeriodAssignedToDriversWithCapacities[$deliveryTransportationPeriodAssignedToDriversWithCapacity->delivery_driver_assigned_to_transportation_period_id]))
                $transportationPeriodAssignedToDriversWithCapacities[$deliveryTransportationPeriodAssignedToDriversWithCapacity->delivery_driver_assigned_to_transportation_period_id] += $deliveryTransportationPeriodAssignedToDriversWithCapacity->capacity;
            else
                $transportationPeriodAssignedToDriversWithCapacities[$deliveryTransportationPeriodAssignedToDriversWithCapacity->delivery_driver_assigned_to_transportation_period_id] = $deliveryTransportationPeriodAssignedToDriversWithCapacity->capacity;

        }


        //  $transportationPeriodAssignedToDriversWithCapacities = Order::where('pickup_date',$date);
        foreach($transportationPeriodsWithDrivers as &$transportationPeriodsWithDriver){
            foreach($transportationPeriodsWithDriver->drivers as &$driver){
                if(isset($transportationPeriodAssignedToDriversWithCapacities[$driver->id]))
                    $driver->capacity -= $transportationPeriodAssignedToDriversWithCapacities[$driver->id];

            }
        }

        // foreach ($transportationPeriodAssignedToDrivers as $tpad) {
        //     $capacityInfo = $tpad->getCapacityInfo();
        //     $tpad['used_capacity'] = $capacityInfo['used_capacity'];
        //     $tpad['available_capacity'] = $capacityInfo['available_capacity'];
        // }
     return $transportationPeriodsWithDrivers;
    }

    public function transportationPeriodAssignedToDriverCapacityInDate($transportationPeriodAssignedToDriverId, $date){


        $pickupOrders =
        Order::where("pickup_driver_assigned_to_transportation_period_id",$transportationPeriodAssignedToDriverId)
        ->where('pickup_date',$date)
        ->count();

        $deliveryOrders = Order::where("delivery_driver_assigned_to_transportation_period_id",$transportationPeriodAssignedToDriverId)
        ->where('delivery_date',$date)
        ->count();

        $usedCapacity= $pickupOrders + $deliveryOrders;

     return $usedCapacity;
    }

    public function getById($id)
    {

        $transportationPeriod = TransportationPeriodAssignedToDriver::find($id);
        if ($transportationPeriod == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $transportationPeriod;
    }

    public function create($transportationPeriod)
    {

        try {

            $createdTransportationPeriodAssignedToDriver = TransportationPeriodAssignedToDriver::create($transportationPeriod);
            return $createdTransportationPeriodAssignedToDriver;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
        }
    }

    public function update($newTransportationPeriodAssignedToDriverAssignedToDriver)
    {

        $transportationPeriod = $this->getById($newTransportationPeriodAssignedToDriverAssignedToDriver['id']);
        try {

            $transportationPeriod->update($newTransportationPeriodAssignedToDriverAssignedToDriver);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
        }
    }

    public function delete($id)
    {

        try {

            $driverAssignedTotransportationPeriod = $this->getById($id);
            if (!$this->canLoggedInUserUpdateDriverAssignedToTransportationPeriod($driverAssignedTotransportationPeriod))
                throw new Exception();

            $driverAssignedTotransportationPeriod->delete();
        } catch (Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
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

    public function canLoggedInUserUpdateDriverAssignedToTransportationPeriod($driverAssignedTotransportationPeriod)
    {

        $loggedInUser = $this->getLoggedInUser();
        // check for user access to driver and transportation period
        switch ($loggedInUser->role) {
            case "admin":

                return true;
            case "company":
            case "drivers_manager":
                return ($driverAssignedTotransportationPeriod->transportationPeriod->user_id == $loggedInUser->id);
            // case "country_manager":
            //     $driversService = new DriversService();
            //     $driversManager = $driversService->getDriverManagerByDriverId($driverAssignedTotransportationPeriod->driver_id);
            //     // check if driver is working for manager that his country is the same as the country manager's country
            //     return $this->isDriverManagerWorkingInCountrySameAsLoggedInCountryManager($driversManager, $loggedInUser);
            // case "company":

            //     // check if is company's driver or working for drivers manager that's working with the company
            //     $driversService = new DriversService();
            //     $driverManager = $driversService->getDriverManagerByDriverId($driverAssignedTotransportationPeriod->driver_id);

            //     if ($driverManager->id != $loggedInUser->id || $driverAssignedTotransportationPeriod->transportationPeriod->user_id != $driverManager->id) {

            //         $companiesWorkingWithDriverManagersService = new CompaniesWorkingWithDriverManagersService();
            //         return $companiesWorkingWithDriverManagersService->isDriversManagerWorkingWithCompany(driversManagerId:$driverManager->id,companyId: $loggedInUser->id);
            //     }
            //     return true;


            // case "drivers_manager":

            //     $driversService = new DriversService();
            //     $driversManager = $driversService->getDriverManagerByDriverId($driverAssignedTotransportationPeriod->driver_id);
            //     return $driverAssignedTotransportationPeriod->transportationPeriod->user_id == $loggedInUser->id && $driversManager->id == $loggedInUser->id;

        }

        return false;
    }

    public function canLoggedInUserAssignDriverToTransportationPeriod($driverId, $transportationPeriodId)
    {

        $loggedInUser = $this->getLoggedInUser();

        if (TransportationPeriodAssignedToDriver::where('driver_id', $driverId)->where('transportation_period_id', $transportationPeriodId)->count() > 0)
            throw new HttpResponseException($this->apiResponse(message: __('already_exists')));
        // check if transportation period belongs to the manager of the selected driver
        $driversService = new DriversService();
        // the $driverManager variable is the manager of the driver  MAY BE COMPANY OR DRIVERS MANAGER
        $driverManager = $driversService->getDriverManagerByDriverId($driverId);
        // check for user access to driver and transportation period
        switch ($loggedInUser->role) {
            case "admin":

                return true;
            case "country_manager":

                // check if driver is working for manager that his country is the same as the country manager's country
                return $this->isDriverManagerWorkingInCountrySameAsLoggedInCountryManager($driverManager, $loggedInUser);
            case "company":
            case "drivers_manager":
                return $this->isUserOwnTransportationPeriod($driverManager->id, $transportationPeriodId) && $driverManager->id == $loggedInUser->id;

        }

        return false;
    }



    private function isUserOwnTransportationPeriod($userId, $transportationPeriodId)
    {
        $transportationPeriodsService = new TransportationPeriodsService();
        $transportationPeriod = $transportationPeriodsService->getById($transportationPeriodId);

        return $transportationPeriod->user_id == $userId;

    }

    private function isDriverManagerWorkingInCountrySameAsLoggedInCountryManager($driverManager, $loggedInUser)
    {


        return ($driverManager->role == "company" &&
            $driverManager->company->country_id == $loggedInUser->countryManager->country_id) ||
            ($driverManager->role == "drivers_manager" &&
                $driverManager->driversManager->country_id == $loggedInUser->countryManager->country_id);
    }

    public function canLoggedInUserAddOrderToDriverAssignedToTransportationPeriod($driverAssignedTotransportationPeriodId)
    {
        $driverAssignedTotransportationPeriod = $this->getById($driverAssignedTotransportationPeriodId);
        return $this->canLoggedInUserUpdateDriverAssignedToTransportationPeriod($driverAssignedTotransportationPeriod);
    }

    public function deleteForTransportationPeriodId($transportationPeriodId)
    {

        TransportationPeriodAssignedToDriver::where('transportation_period_id', $transportationPeriodId)->delete();
    }

    public function deleteForDriverId($driverId)
    {

        TransportationPeriodAssignedToDriver::where('driver_id', $driverId)->delete();
    }

    public function canLoggedInUserAddOrderToDriversManagerId($driversManagerId)
    {

        $loggedInUser = $this->getLoggedInUser();

        $driversManagerService = new DriversManagersService();
        $driversManager = $driversManagerService->getById($driversManagerId);
        // check for user access to driver and transportation period
        switch ($loggedInUser->role) {
            case "admin":

                return true;
            case "country_manager":

                // check if driver is working for manager that his country is the same as the country manager's country

                return $this->isDriverManagerWorkingInCountrySameAsLoggedInCountryManager($driversManager, $loggedInUser);
            case "company":

                $companiesWorkingWithDriverManagersService = new CompaniesWorkingWithDriverManagersService();
                return $companiesWorkingWithDriverManagersService->isDriversManagerWorkingWithCompany(driversManagerId:$driversManagerId,companyId:$loggedInUser->id);


        }
        return false;
    }
    public function isDriverBelongToChoosenCompanyOrDriversManagerWorkingWith($transportationPeriodId,$companyId)
    {
        //check if driver belong to company
        //if not check if driver is working for drivers manager that's working with the company
        $transportationPeriod = $this->getById($transportationPeriodId);

        $driverId = $transportationPeriod->driver_id;

        $driver = $this->driversService->getById($driverId);
        //dd($driver, $companyId);
        if ($driver->manager_id == $companyId)
            return true;
        else{
            $companiesWorkingWithDriverManagersService = new CompaniesWorkingWithDriverManagersService();
            if($companiesWorkingWithDriverManagersService->isDriversManagerWorkingWithCompany(driversManagerId:$driver->manager_id,companyId:$companyId))
            return true;
        }
        throw new HttpResponseException($this->apiResponse(status: false, message: "This driver doesn't belong to this company Or drivers manager working with this company"));
        //return false;
    }


}
