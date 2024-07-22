<?php

namespace App\Http\Services\Users;

<<<<<<< HEAD
=======
use Carbon\Carbon;
use App\Models\Order;
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6
use App\Models\Driver;
use App\Models\ClientDriverRate;
use App\Http\Traits\ResponsesTrait;
use App\Http\Services\OrdersService;
use App\Http\Traits\ArraySliceTrait;
use App\Http\Traits\FileUploadTrait;


use App\Http\Traits\LoggedInUserTrait;
<<<<<<< HEAD
use App\Http\Services\Users\UsersService;
=======


use App\Http\Services\Users\UsersService;
use App\Http\Services\Orders\OrdersService;
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6
use Illuminate\Http\Exceptions\HttpResponseException;

class DriversService
{

    use ResponsesTrait;
    use ArraySliceTrait,LoggedInUserTrait;
    use FileUploadTrait;
    private $usersService;
    private $ordersService;
    public function __construct()
    {
        $this->usersService = new UsersService();
        $this->ordersService = new OrdersService();
    }
    //get drivers where orders_per_hour is less than or equal to the number of orders
    public function getAviableDrivers(){
        // $drivers = Driver::where('capacity_per_hour', '<=', Order::count())->get();
        // return $drivers;
    }
    public function driverStatus($driverId){
        // //select from orders table where driver_id = $driverId and pickup_start_date_time is from 1 hour or more than 1 hour
        // $order = Order::where('driver_id', $driverId)
        //         ->where('pickup_start_date_time', '>', Carbon::now()->subHours(1))
        //         ->orWhere('delivery_start_date_time', '>', Carbon::now()->subHours(1))
        //         ->first();

    }
    public function get($managerId = null)
    {

        $user = $this->getLoggedInUser();

        $drivers = Driver::with('user:id,name,email,phone,created_at,updated_at');
        if($managerId != null){
            $drivers = $drivers->where('manager_id', $managerId);
        }
        $drivers= $drivers->select('user_id','manager_id')
        ->orderBy('created_at', 'DESC')
        ->get();

        // switch ($user->role) {

        //     case "company":

        //         $drivers = $drivers->where('company_id', $user->id);
        //         break;
        //     case "drivers_manager":  // tested and done

        //         $drivers = $drivers->where('drivers_manager_id', $user->id);
        //         break;
        // }
        //$drivers = $drivers->select('user_id')->orderBy('created_at', 'DESC')->get();

        return $drivers;
    }
    public function myDrivers($managerId = null)
    {

        $user = $this->getLoggedInUser();
        if($user->role == 'company' || $user->role == 'drivers_manager'){
            $managerId = $user->id;
        }
        $drivers = Driver::with('user:id,name,email,phone,created_at,updated_at')->where('manager_id', $managerId);
        $drivers= $drivers->select('user_id','manager_id')
        ->orderBy('created_at', 'DESC')
        ->get();

        // switch ($user->role) {

        //     case "company":

        //         $drivers = $drivers->where('company_id', $user->id);
        //         break;
        //     case "drivers_manager":  // tested and done

        //         $drivers = $drivers->where('drivers_manager_id', $user->id);
        //         break;
        // }
        //$drivers = $drivers->select('user_id')->orderBy('created_at', 'DESC')->get();

        return $drivers;
    }

    public function getById($id)
    {

        $driver = Driver::find($id);
        if ($driver == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $driver;
    }

    public function create($data)
    {

            $user = $this->getLoggedInUser();
            //dd($user);
            switch ($user->role) {
                case "company":
                    $driver['manager_id'] = $user->id;
                    break;

                case "drivers_manager":
                    $driver['manager_id'] = $user->id;
                    break;
                default :
                    $driver = $this->array_slice_assoc($data, ['manager_id']);
            }
            //dd( $driver);
            try {
            $user = $this->array_slice_assoc($data, ['name','email','phone','password']);
            $createdUser = $this->usersService->create($data, 'driver');

            $driver['user_id'] = $createdUser->id;

            $createdDriver = Driver::create($driver);
                return $this->apiResponse(status:true, message: "driver is created");

        } catch (\Exception $ex) {
            $createdUser->delete();
            return $this->apiResponse(status:false, message: "Driver Serviece driver manager not exist");
        }
    }
//     public function getDrivers(){

//         $drivers = Driver::pluck('user_id');
//         foreach ($drivers as $driverId) {

//             $this->driverStatus($driverId);
//         }
//         return $drivers;
//        // dd($drivers);
//     }
//     public function driverStatus($driverId){

//         $lastOrder = Order::where('pickup_driver_id', $driverId)
//         ->orderBy('created_at', 'desc')
//         ->limit(3);

//         if ($lastOrder) {
//             $createdAt = Carbon::parse($lastOrder->created_at);
//             $last60Minutes = Carbon::now()->subMinutes(60);

//         dd($createdAt);


//         // Check if the last order exists and its capacity_per_hour is less than or equal to the number of orders
//         if ($lastOrder && $lastOrder->capacity_per_hour <= Order::where('driver_id', $driverId)->whereDate('created_at', $lastOrder->created_at)->count()) {
//             // The last order's capacity_per_hour is less than or equal to the number of orders
//             return true;
//         } else {
//             // The last order's capacity_per_hour is greater than the number of orders
//             return false;
//         }
//     }
// }
    public function createClientRate($data)
    {

        $data['client_id'] = $this->getLoggedInUser()->id; // should be client
        $createdRate = ClientDriverRate::updateOrCreate(
            ['base_drivers_rates_id' => $data['base_drivers_rates_id'], 'driver_id' => $data['driver_id'], 'client_id' => $data['client_id']],
            ['value' => $data['value']]
        );
    }

    public function update($newDriver)
    {

        $driver = $this->getById($newDriver['id']);
        try {

            $user = $this->array_slice_assoc($newDriver, ['phone','name','email','password','active']);
            $user['id'] = $driver->user_id;
            $this->usersService->update($user);

            $driver->update($newDriver);
            return $driver;

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $driver = $this->getById($id);
        $user = $this->getLoggedInUser();

            if($this->usersService->canUserDeleteUser($user,$id)){
                $driver->user->delete();
                $driver->delete();
            }else{
                throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_allowed_to_delete')));
            }
            try {
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

    public function getDriverManagerByDriverId($driverId){


        return $this->getById($driverId)->manager;
    }
}
