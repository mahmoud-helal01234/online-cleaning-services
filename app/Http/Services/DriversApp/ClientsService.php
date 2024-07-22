<?php

namespace App\Http\Services\DriversApp;

use App\Models\DriversApp\Client;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;


class ClientsService
{

    use ResponsesTrait,LoggedInUserTrait;
    use FileUploadTrait;

    public function get(){

        $loggedInUser = $this->getLoggedInUser();
        $clients = Client::query();
        switch($loggedInUser->role){

            case "admin":
            break;
            default:
            $clients = $clients->where('user_id',$loggedInUser->id);

        }
        return $clients->get();
    }

    public function getById($id){

        $driver_app_clients = Client::find($id);
        if($driver_app_clients == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $driver_app_clients;
    }

    public function create($driversAppClient){

        try{
            $driversAppClient['user_id'] = $this->getLoggedInUser()->id;
            $createdDriversAppClient = Client::create($driversAppClient);
            return $createdDriversAppClient;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }


    public function update($newDriversAppClient){

        $driversAppClient = $this->getById($newDriversAppClient['id']);
        $newDriversAppClient['user_id'] = $this->getLoggedInUser()->id;
        try{
            $driversAppClient->update($newDriversAppClient);
            return $driversAppClient;

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        try {

        $loggedInUser = $this->getLoggedInUser();
        $this->canUserDeleteClient($loggedInUser,$id);

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }

    }

    public function canUserUpdateClient($user, $clientId)
    {

        // even admin don't have access to the others clients
        return  $this->getById($clientId)->user_id == $user->id;
    }
    public function canUserDeleteClient($user, $clientId)
    {
        
        $driver_app_clients = $this->getById($clientId);
        
        // even admin don't have access to the others clients
        if ($driver_app_clients->user_id == $user->id) {
            $driver_app_clients->delete();
        }else {
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

}
