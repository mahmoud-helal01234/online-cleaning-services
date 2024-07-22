<?php

namespace App\Http\Services\Users;

use App\Models\User;
use App\Models\CountryManager;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Users\UsersService;
<<<<<<< HEAD
=======
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

class CountryManagersService extends UsersService {
    use LoggedInUserTrait;
    public function get($active = null,$countryId = null,$role = 'country_manager'){

        $role = 'country_manager';

        $users = User::with('countryManager.country:id,name_ar,name_en')
        ->when($role != null, function($query) use ($role) {
            is_array($role) ? $query->whereIn('role', $role) : $query->where('role', $role);
        })
        ->when($countryId != null, function($query) use ($countryId) {
            $query->whereHas('countryManager.country', function($q) use ($countryId) {
                $q->where('id', $countryId);
            });
        })
        ->get();


        return $users;
    }

    public function getById($id){

        return parent::getById($id);
    }

    public function create($user, $role = 'country_manager'){
        DB::transaction(function () use ($user) {

        $createdUser = parent::create($user,"country_manager");
        CountryManager::create(['user_id' => $createdUser->id,"country_id" =>$user['country_id']]);
        });
    }


    public function update($newUser){

        CountryManager::where('user_id' , $newUser['id'])->update(['country_id' => $newUser['country_id']]);

        return parent::update($newUser);
    }

    public function delete($id,$role = 'country_manager'){

        $user = $this->getloggedInUser();

        if(parent::canUserDeleteUser($user,$id)){
            parent::delete($id,$role);
            CountryManager::where('user_id' , $id)->delete();
        }else{
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_allowed_to_delete')));
        }
    }

    public function toggleActivation($id,$activationStatus){

        parent::toggleActivation($id,$activationStatus);
    }

}
