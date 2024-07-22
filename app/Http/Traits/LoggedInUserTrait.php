<?php

namespace App\Http\Traits;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Support\Facades\Auth;


trait LoggedInUserTrait {

use ResponsesTrait;

    public function getLoggedInUserRole(){

        $loggedInUser = $this->getLoggedInUser();
        return $loggedInUser->role;
    }

    public function getLoggedInUser(){

        $loggedInUser = Auth::guard('authenticate')->user();
        if(!$loggedInUser){
            $loggedInUser = Auth::guard('authenticate-clients')->user();
            if($loggedInUser)
                $loggedInUser->role = "client";
        }
        return $loggedInUser;
    }

}
