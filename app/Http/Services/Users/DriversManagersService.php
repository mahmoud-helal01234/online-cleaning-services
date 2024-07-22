<?php

namespace App\Http\Services\Users;

use App\Models\User;
use App\Models\DriversManager;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\ArraySliceTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Services\Users\UsersService;
use App\Http\Services\Users\DriversService;
use Illuminate\Http\Exceptions\HttpResponseException;
<<<<<<< HEAD
use App\Http\Services\CompaniesWorkingWithDriverManagersService;
=======
use App\Http\Services\Orders\CompaniesWorkingWithDriverManagersService;
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

class DriversManagersService
{

    use ResponsesTrait;
    use ArraySliceTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;
    private $usersService;
    private $driversService;
    public function __construct()
    {

        $this->usersService = new UsersService();
        $this->driversService = new DriversService();
    }
    public function get($countryId = null)
    {
        // $user = $this->getLoggedInUser();
        // switch ($user->role) {
        //     case "country_manager":

        //         $driversManagers = DriversManager::where('country_id',$user->countryManager->country_id)
        //         ->with('user')
        //         ->get();
        //         //
        //         //->where('country_id',$user->countryManager->country_id)
        //         //->select('user_id','country_id')
        //        // ->get();
        //         break;
        //     default :
        //         $driversManagers = DriversManager::where($countryId != null , function ($query) use ($countryId) {
        //             $query->where('country_id', $countryId);
        //         })->with('user:id,name,email,phone,created_at,updated_at')
        //         ->select('user_id','country_id')
        //         ->get();

        // }
        $driversManagers = DriversManager::with('user:id,name,email,phone,created_at,updated_at');
        if ($countryId != null)
            $driversManagers = $driversManagers->where('country_id', $countryId);

        $driversManagers = $driversManagers->select('user_id','country_id')->get();

        return $driversManagers;
    }

    public function getById($id)
    {

        $driversManager = DriversManager::find($id);

        if ($driversManager == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $driversManager;
    }

    public function toggleActivation($id, $activationStatus){

        $driversManager = $this->getById($id);


            $driversManager = User::find($driversManager);
            $this->usersService->update(['active' => $activationStatus]);
            try{
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function create($data)
    {

        // $user = $this->array_slice_assoc($data, ['name','email','phone','password']);
        $createdUser = $this->usersService->create($data, 'drivers_manager');

        try {

            // $driversManager = $this->array_slice_assoc($data, ['orders_per_hour','logo_path']);

            $driversManager['country_id'] = $data['country_id'];
            $driversManager['user_id'] = $createdUser->id;
            DriversManager::create($driversManager);

        } catch (\Exception $ex) {

            $createdUser->delete();
            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newDriversManager)
    {

        $driversManager = $this->getById($newDriversManager['id']);

        try {


            $user = $this->array_slice_assoc($newDriversManager, ['phone','name','email','password','active']);
            $user['id'] = $driversManager->user_id;
            $this->usersService->update($user);
            $driversManager->update($this->array_slice_assoc($newDriversManager, ['country_id']));


        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $driversManager = $this->getById($id);
        $user = $this->getLoggedInUser();

            if($this->usersService->canUserDeleteUser($user,$id)){
                $this->deleteChild($driversManager);
                $driversManager->user->delete();
                $driversManager->delete();
            }else{
                throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_allowed_to_delete')));
            }
            try {
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
    private $companiesWorkingWithDriversManager;
    public function deleteChild($driversManager){

        $this->companiesWorkingWithDriversManager = new CompaniesWorkingWithDriverManagersService();
        $this->companiesWorkingWithDriversManager->deleteChildren(driversManagerId: $driversManager->user_id);

    }
}
