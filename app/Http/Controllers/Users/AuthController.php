<?php

namespace App\Http\Controllers\Users;

use App\Http\Traits\LoggedInUserTrait;
use App\Models\User;
use App\Models\Client;
use App\Models\DeviceToken;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\ResponsesTrait;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Services\Users\AuthService;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Client\ClientLoginRequest;
use App\Http\Requests\Client\ClientRegisterRequest;

class AuthController extends Controller
{
    use LoggedInUserTrait;
    use ResponsesTrait;
    private $authService;
    public function __construct()
    {

        $this->authService = new AuthService();
    }

    public function socialLogin(Request $request)
    {

        $provider = $request->input('provider');
        $token = $request->input('token');

        // $request->provider;
        // Getting the user from socialite using token from it's provider (google,facebook,...) $request->token

        $user = Socialite::driver($provider)->stateless()->userFromToken($token);
        // dd($user);
        // echo json_encode($user);
        //exit();
        // Getting or creating user from db
        $userFromDb = Client::firstOrCreate(
            [
                'provider_id' => $user->getId(),
                'provider_name' =>  $provider,
            ],
            [
                'email' => $user->getEmail(),
                'email_verified_at' => now(),
                'name' => $user->offsetGet('given_name') . ' ' . $user->offsetGet('family_name'),
                //'avatar' => $user->getAvatar,
                'provider_id' => $user->getId(),
                'access_token' => $user->token,
            ]
        );

        // Returning response
        try {
            $token = $userFromDb->createToken('Social Token')->plainTextToken;
        } catch (ClientException $exception) {

            return response()->json(['message' => 'Invalid credentials provided.'], 422);
            //exit();
        }

        $response = ['token' => $token, 'message' => 'Successful'];
        return response()->json($response, 200);
    }

    public function sendPasswordResetTokenUsers($email)
    {

        $this->authService->sendPasswordResetTokenUsers($email);
        return $this->apiResponse(null,true,__('success.password_reset_sent'));
    }

    public function resetPasswordUsers(ResetPasswordRequest $request)
    {

        $data = $request->validated();
        $this->authService->resetPasswordUsers($data);
        return $this->apiResponse(null,true,__('success.password_reset'));
    }

    public function sendPasswordResetTokenClients($email)
    {

        $this->authService->sendPasswordResetTokenClients($email);
        return $this->apiResponse(null,true,__('success.password_reset_sent'));
    }

    public function resetPasswordClients(ResetPasswordRequest $request)
    {

        $data = $request->validated();
        $this->authService->resetPasswordClients($data);
        return $this->apiResponse(null,true,__('success.password_reset'));
    }



    public function login(LoginRequest $request)
    {

        $user = $request->validated();
        $LoggedInUser = $this->authService->login($user);
        return $this->apiResponse($LoggedInUser,true,__('success.login'));
    }

    public function me()
    {


        $user = $this->authService->me();
        return $this->apiResponse($user);
    }

    public function clientLogin(ClientLoginRequest $request)
    {

        $user = $request->validated();
        $LoggedInUser = $this->authService->clientLogin($user);
        return $this->apiResponse($LoggedInUser, true, __('success.login'));
    }

    public function clientRegister(ClientRegisterRequest $request)
    {

        $user = $request->validated();
        $CreatedUser = $this->authService->clientRegister($user);

        return $this->apiResponse($CreatedUser, true, __('success.login'));


    }

    public function logout()
    {
        $user = $this->getLoggedInUser();
        $deviceToken = DeviceToken::where('user_id', $user->id)->first();

        if ($deviceToken) {
            // Delete the device token
            $deviceToken->delete();
        }

        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
    // public function redirectToProvider($provider)
    // {
    //     return Socialite::driver($provider)->stateless()->redirect();
    // }

    // public function handleProviderCallback($provider)
    // {
    //     $socialUser = Socialite::driver($provider)->user();
    //     $user = User::where('provider', $provider)
    //     ->where('provider_id', $socialUser->getId())
    //     ->first();

    // if (!$user) {
    //     // User does not exist, create a new user
    //     $user = User::create([
    //         'name' => $socialUser->getName(),
    //         'email' => $socialUser->getEmail(),
    //         'provider' => $provider,
    //         'provider_id' => $socialUser->getId(),
    //         'avatar' => $socialUser->getAvatar(),
    //         'password' => Hash::make(Str::random(16)), // Set a random password
    //     ]);
    // }

    // // Authenticate the user
    // Auth::guard('api')->setUser($user);

    // // Generate a token for the user
    // $token = auth('api')->login($user);

    // return response()->json(['token' => $token], 200);
    // }


}
