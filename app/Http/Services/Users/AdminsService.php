<?php

namespace App\Http\Services\Users;

use App\Models\User;
use App\Http\Services\Users\UsersService;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminsService extends UsersService {


    public function get($active = null,$role = 'admin'){

        return parent::get($active,'admin');
    }

    public function getById($id){

        return parent::getById($id);
    }

    public function create($user, $role = 'admin'){

        return parent::create($user,"admin");
    }


    public function update($newUser){

        return parent::update($newUser);
    }

    public function delete($id,$forExtenstionReasons = null){

        if(User::where('role','admin')->count() == 1){
            throw new HttpResponseException($this->apiResponse(status:false,message:__('validations.delete_admin')));;
        }
        parent::delete($id,false);
    }

    public function toggleActivation($id,$activationStatus){

        parent::toggleActivation($id,$activationStatus);

    }

}
