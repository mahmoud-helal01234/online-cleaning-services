<?php

namespace App\Http\Services\Users;

use App\Http\Traits\LoggedInUserTrait;
use App\Http\Traits\ResponsesTrait;
use App\Models\ClientLocation;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientLocationsService
{

    use ResponsesTrait;


    use LoggedInUserTrait;

    public function get($clientId = null)
    {

        $user = $this->getLoggedInUser();
        switch ($user->role) {

            case "admin":

                $clientLocations = ClientLocation::when($clientId != null, function ($query) use ($clientId) {
                    $query->where('client_id', $clientId);
                })->orderBy('created_at', 'DESC')->get();
                break;

            case "client":  // tested and done

                $clientLocations = ClientLocation::where('client_id', $user->id)->orderBy('created_at', 'DESC')->get();
                break;
        }

        return $clientLocations;
    }

    public function selectClientLocation($clientId){

        $clientLocation = ClientLocation::where('client_id',$clientId)->get();
        return $clientLocation;

    }
    public function getById($id)
    {

        $clientLocation = ClientLocation::find($id);

        if ($clientLocation == null)

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $clientLocation;
    }

    public function create($clientLocation)
    {

        $user = $this->getLoggedInUser();
        if ($user->role == "client")
            $clientLocation['client_id'] = $user->id;

        try {

            $createdClientLocation = ClientLocation::create($clientLocation);
            return $createdClientLocation;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));
        }
    }

    public function update($newClientLocation){

        $clientLocation = $this->getById($newClientLocation['id']);
        try{

            $clientLocation->update($newClientLocation);
            return $clientLocation;
        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $clientLocation = $this->getById($id);

        try {

            $clientLocation->delete();
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
