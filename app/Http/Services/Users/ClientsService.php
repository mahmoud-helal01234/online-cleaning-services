<?php

namespace App\Http\Services\Users;

use App\Models\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\ArraySliceTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Support\Facades\Config;
use App\Http\Resources\Auth\ClientLoginResource;
use Illuminate\Http\Exceptions\HttpResponseException;


class ClientsService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use ArraySliceTrait;
    use LoggedInUserTrait;

    public function socialLogin()
    {

    }

    public function login($user)
    {

        // Config::set('jwt.user', 'App\Models\Client');
        // Config::set('auth.providers.clients.model', \App\Models\Client::class);

        $credentials = $this->array_slice_assoc($user, ['email', 'password']);

        $token = Auth::guard('authenticate-clients')->attempt($credentials);

        if (!$token) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.failed.failed')));
        }
        $user = Auth::guard('authenticate-clients')->user();
        $user['token'] = $token;
        return $user;
        // return ClientLoginResource::make($user);
    }

    public function register($client)
    {

        // Config::set('jwt.user', 'App\Models\User');
        // Config::set('auth.providers.users.model', \App\Models\User::class);

        $password = $client['password'];
        $createdClient = Client::create($client);

        $credentials =  ['email' => $client['email'], 'password' => $password];
        // $token = Auth::guard('authenticate-clients')->attempt($credentials);
        $token = JWTAuth::fromUser($createdClient);
        // $token = Auth::guard('authenticate-clients')->attempt($credentials);
        $createdClient['token'] = $token;

        return ClientLoginResource::make($createdClient);
    }
    public function selectClientsByCompany($companyId){

        $companiesService = new CompaniesService();
        $company = $companiesService->getById($companyId);

        $clientsForCompany = Client::where('country_id',$company->country_id)->get();
        return $clientsForCompany;

    }
    public function updateProfile($newClient)
    {

        // Config::set('jwt.user', 'App\Models\User');
        // Config::set('auth.providers.users.model', \App\Models\User::class);
        
        $clientId = $this->getLoggedInUser()->id;
        $client = $this->getById($clientId);
        $client->update($newClient);

        return $client;
    }

    public function forgetPasswordEmail($email)
    {

        Mail::send('emails.forget_password', [], function ($message) use ($email) {

            $message->to($email)->subject('Subject of the message!');
        });
        // $client = Client::where('email',$email);

        // if($client == null)
        //     throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

    }

    public function getById($id)
    {

        $client = Client::find($id);
        if ($client == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $client;
    }

    public function get($countryId = null)
    {

        $clients = Client::with('country')->when($countryId != null, function ($query) use ($countryId){

            $query->where("country_id",$countryId);
        })->get();

        return $clients;
    }
    public function viewProfile()
    {
        $loggedInUser = $this->getLoggedInUser();
        if($loggedInUser->role == 'client')
            $clientId = $loggedInUser->id;
        else
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_authorized')));
        $client = Client::where('id' , $clientId)->with('clientLocation')->get();

        return $client;
    }

    public function create($client)
    {


        $createdUser = Client::create($client);
        return $createdUser;

    }


    public function update($newClient)
    {

        $client = $this->getById($newClient['id']);
        $client->update($newClient);
        return $client;

    }

    public function delete($id)
    {

        $client = $this->getById($id);
        try {

            $avatarPath = $client->avatar;
            $client->delete();
            $this->deleteFile($avatarPath);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $client = $this->getById($id);
        try {

            $client->update(['active' => $activationStatus]);

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

}
