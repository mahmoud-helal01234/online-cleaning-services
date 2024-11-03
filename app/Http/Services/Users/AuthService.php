<?php

namespace App\Http\Services\Users;

use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Str;
use App\Models\UserPasswordReset;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Traits\ResponsesTrait;
use App\Models\ClientPasswordReset;
use App\Http\Traits\ArraySliceTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordTokenEmail;
use Illuminate\Support\Facades\Config;
use App\Http\Resources\Auth\ClientLoginResource;
use App\Http\Traits\LoggedInUserTrait;
use App\Models\DriversApp\UserDeviceToken;
use Illuminate\Http\Exceptions\HttpResponseException;


class AuthService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use ArraySliceTrait;
    use LoggedInUserTrait;
    public function me()
    {

        return $this->getLoggedInUser();
    }
    public function socialLogin() {}

    public function clientLogin($user)
    {

        // Config::set('jwt.user', 'App\Models\Client');
        // Config::set('auth.providers.users.model', \App\Models\Client::class);

        $credentials = $this->array_slice_assoc($user, ['email', 'password']);

        $token = Auth::guard('authenticate-clients')->attempt($credentials);

        if (!$token) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.failed.failed')));
        }
        $user = Auth::guard('authenticate-clients')->user();
        $user['token'] = $token;
        return $user;
        //return ClientLoginResource::make($user);
    }

    public function clientRegister($client)
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

    public function sendPasswordResetTokenUsers($email)
    {

        $user = User::where('email', $email)->first();
        if ($user != null) {
            UserPasswordReset::where(["user_id" => $user->id])->delete();
            $token = Str::random(5);
            UserPasswordReset::create(["user_id" => $user->id, "token" => $token]);
            Mail::to($email)->send(new ResetPasswordTokenEmail($token));
        }
    }

    public function resetPasswordUsers($data)
    {

        $email = $data['email'];
        $userPasswordReset = UserPasswordReset::where(["token" => $data['token']])->whereHas('user', function ($q) use ($email) {
            $q->where('email', $email);
        })->first();

        if ($userPasswordReset == null)
            throw new HttpResponseException($this->apiResponse(null, false, __("auth.failed")));
        User::where('id', $userPasswordReset->user_id)->update(['password' => Hash::make($data['password'])]);
        $userPasswordReset->delete();
    }


    public function sendPasswordResetTokenClients($email)
    {

        $client = Client::where('email', $email)->first();
        if ($client != null) {
            ClientPasswordReset::where(["client_id" => $client->id])->delete();
            $token = Str::random(5);
            ClientPasswordReset::create(["client_id" => $client->id, "token" => $token]);
            Mail::to($email)->send(new ResetPasswordTokenEmail($token));
        }
    }

    public function resetPasswordClients($data)
    {

        $email = $data['email'];
        $clientPasswordReset = ClientPasswordReset::where(["token" => $data['token']])->whereHas('client', function ($q) use ($email) {
            $q->where('email', $email);
        })->first();

        if ($clientPasswordReset == null)
            throw new HttpResponseException($this->apiResponse(null, false, __("auth.failed")));
        Client::where('id', $clientPasswordReset->client_id)->update(['password' => Hash::make($data['password'])]);
        $clientPasswordReset->delete();
    }

    public function login($user)
    {

        // Config::set('jwt.user', 'App\Models\User');
        // Config::set('auth.providers.users.model', \App\Models\User::class);
        $credentials = $this->array_slice_assoc($user, ['email', 'password']);

        $token = Auth::guard('authenticate')->attempt($credentials);

        if (!$token) {

            throw new HttpResponseException($this->apiResponse(null, false, __('wrong email or password')));
        }

        $authUser = Auth::guard('authenticate')->user();
        if (isset($user['device_token']) &&  $user['device_token'] != null) {
            UserDeviceToken::create([

                'user_id' => $authUser->id,
                'device_token' => $user['device_token'],
            ]);
        }
        $authUser['token'] = $token;
        return $authUser;
    }
}
