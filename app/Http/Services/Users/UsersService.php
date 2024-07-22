<?php

namespace App\Http\Services\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\ArraySliceTrait;
use App\Http\Traits\FileUploadTrait;
<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;

class UsersService {
=======
use App\Http\Traits\LoggedInUserTrait;
use App\Models\DeviceToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;

class UsersService
{
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

    use ResponsesTrait;
    use FileUploadTrait;
    use ArraySliceTrait;
<<<<<<< HEAD

    public function get($active = 1,$role = null){

        $users = User::when($role != null, function($query) use($role){

            is_array($role) ? $query->whereIn('role', $role) : $query->where('role', $role);

        })->where('active',$active)->get();
=======
    use LoggedInUserTrait;

    public function getSelect($active = null, $roles = null)
    {

        $users = User::when($roles != null, function ($query) use ($roles) {

            is_array($roles) ? $query->whereIn('role', $roles) : $query->where('role', $roles);

        })->when($active != null, function ($query) use ($active) {

            $query->where('active', $active);

        })->select(
            "id",
                "name",
                "email",
                "phone"
            )->get();
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

        return $users;
    }

<<<<<<< HEAD
    public function getById($id){

        $user = User::find($id);
        if($user == null)
=======
    public function get($active = null, $role = null)
    {

        $users = User::when($role != null, function ($query) use ($role) {

            is_array($role) ? $query->whereIn('role', $role) : $query->where('role', $role);

        })->when($active != null, function ($query) use ($active) {

            $query->where('active', $active);

        })->get();

        return $users;
    }

    public function getById($id)
    {

        $user = User::find($id);
        if ($user == null)
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $user;
    }

<<<<<<< HEAD
    public function create($user, $role = 'driver'){

        try{
=======
    public function create($user, $role = 'driver')
    {

        try {
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

            $user['role'] = $role;
            $createdUser = User::create($user);
            return $createdUser;
<<<<<<< HEAD
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }


    public function update($newUser){

        $user = $this->getById($newUser['id']);

        try{

            $user->update($newUser);
            return $user;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id,$softDelete = true){
        try{

        if($softDelete)
        {

            $user = $this->getById($id);

        // if($this->isAdmin($id))
        //     throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));



            $user->delete();


        }else{

            DB::table('users')->where('id',$id)->delete();
        }
    } catch(\Exception $ex){

        throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
    }
    }

    public function toggleActivation($id,$activationStatus){

        $user = $this->getById($id);
        $user->update(['active' => $activationStatus]);

        try{

            $user->update(['active' => $activationStatus]);

        } catch(\Exception $ex){
=======
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
            ;
        }
    }
    public function viewProfile()
    {
        $loggedInUser = $this->getLoggedInUser();

        $user = User::where('id' , $loggedInUser->id)->select('id','name','email','phone')->get();

        return $user;
    }
    public function createDeviceToken($deviceToken)
    {

        $user = $this->getLoggedInUser();
        $data['user_id'] = $user->id;
        $data['device_token'] = $deviceToken;

        try {

              // Update or create the device token based on the user ID
                DeviceToken::updateOrCreate(['user_id' => $user->id], $data);
            return true;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));

        }
    }
    public function update($newUser)
    {

        $user = $this->getById($newUser['id']);

        try {

            $user->update($newUser);
            return $user;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
            ;
        }
    }

    public function delete($id, $softDelete = true)
    {
        try {

            if ($softDelete) {

                $user = $this->getById($id);

                // if($this->isAdmin($id))
                //     throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));



                $user->delete();


            } else {

                DB::table('users')->where('id', $id)->delete();
            }
        } catch (\Exception $ex) {
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

<<<<<<< HEAD
    private function hashPassword($password){
=======
    public function toggleActivation($id, $activationStatus)
    {

        $user = $this->getById($id);
        $user->update(['active' => $activationStatus]);

        try {

            $user->update(['active' => $activationStatus]);

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

    private function hashPassword($password)
    {
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

        return Hash::make($password);
    }

<<<<<<< HEAD
    public function canUserEditUser($user,$userId){


        $userToUpdate = $this->getById($userId);
        if($user->id == $userId)
            return true;
        switch($user->role){
=======
    public function canUserEditUser($user, $userId)
    {


        $affectedUser = $this->getById($userId);
        if ($user->id == $userId)
            return true;
        switch ($user->role) {
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

            case "admin":
                return true;
            case "country_manager":
<<<<<<< HEAD
                if($userToUpdate->role == "company" && $userToUpdate->company->country_id == $user->countryManager->country_id
                || ($userToUpdate->role == "drivers_manager" && $userToUpdate->driversManager->country_id == $user->countryManager->country_id)
                || ($userToUpdate->role == "driver" && $userToUpdate->driver->manager_id->country_id == $user->countryManager->country_id))
                    return true;
                    break;
            case "company":
            case "drivers_manager":

                if(
                    $userToUpdate->role == "driver" &&
                    $userToUpdate->driver->manager_id == $user->id)
                    return true;
                    break;
=======
                if (
                    $affectedUser->role == "company" && $affectedUser->company->country_id == $user->countryManager->country_id
                    || ($affectedUser->role == "drivers_manager" && $affectedUser->driversManager->country_id == $user->countryManager->country_id)
                    || ($affectedUser->role == "driver" && $affectedUser->driver->manager_id->country_id == $user->countryManager->country_id)
                )
                    return true;
                break;
            case "company":
            case "drivers_manager":

                if (
                    $affectedUser->role == "driver" &&
                    $affectedUser->driver->manager_id == $user->id
                )
                    return true;
                break;
        }
        return false;

    }
    public function canUserDeleteUser($user, $userId)
    {


        $userToUpdate = $this->getById($userId);
        switch ($user->role) {

            case "admin":
                return true;
            case "company":
            case "drivers_manager":


                if (
                    $userToUpdate->role == "driver" &&
                    $userToUpdate->driver->manager_id == $user->id
                )
                    return true;
                break;
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6
        }
        return false;

    }
}
