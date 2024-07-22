<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Http\Services\Users\ClientsService;
use App\Http\Requests\Client\ClientLoginRequest;
use App\Http\Requests\Client\UpdateProfileRequest;
use App\Http\Requests\Client\ClientRegisterRequest;
use App\Http\Requests\Client\ForgetPasswordRequest;

class ClientsController extends Controller
{

    use ResponsesTrait;
    private $clientsService;
    public function __construct()
    {

        $this->clientsService = new ClientsService();
    }

    public function login(ClientLoginRequest $request)
    {

        $user = $request->validated();
        $LoggedInUser = $this->clientsService->login($user);
        return $this->apiResponse($LoggedInUser, true, __('success.login'));
    }

    public function register(ClientRegisterRequest $request)
    {

        $user = $request->validated();
        $CreatedUser = $this->clientsService->register($user);

        return $this->apiResponse($CreatedUser, true, __('success.login'));
    }
    public function selectClientsByCompany($companyId)
    {

        $clientsForCompany = $this->clientsService->selectClientsByCompany($companyId);
        return $this->apiResponse($clientsForCompany);
    }
    public function viewProfile()
    {
        $client =$this->clientsService->viewProfile();

        return $this->apiResponse($client);
    }
    public function updateProfile(UpdateProfileRequest $request)
    {

        $client = $request->validated();
        $this->clientsService->updateProfile($client);

        return $this->apiResponse();
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {

        $email = $request->validated();
        $this->clientsService->forgetPasswordEmail($email);

        return $this->apiResponse();
    }


    public function logout()
    {

        Auth::guard('authenticate-clients')->logout();
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

    public function socialLogin(Request $request)
    {

          // $request->provider;
        // Getting the user from socialite using token from it's provider (google,facebook,...) $request->token
        $user = Socialite::driver("google")->stateless()->userFromToken("ya29.a0AVvZVsqtST0-X_-uR11awXM7a8jpjzis2konBIGP5U5805Di9Zn4ohmU_F8L-J1WC6XPc04Q7pFd-8zx8uzylAoFDao7V1iT3DJmNKYA2oFlMOg2AyTwGfCYxwJgaVktoL2joqgbcJxrD3AZVW99xTGEAtlEaCgYKASUSARISFQGbdwaI_pPUN62cGReUlxUkrfuu8w0163");
        echo json_encode($user);
        exit();
        // Getting or creating user from db
        $userFromDb = User::firstOrCreate(
            [
                'provider_id' => $user->getId(),
                'provider_name' => $request->provider ?? "google",
            ],
            [
                'email' => $user->getEmail(),
                'email_verified_at' => now(),
                'name' => $user->offsetGet('given_name') . ' ' . $user->offsetGet('family_name'),
                'provider_id' => $user->getId()
            ]
        );

        // Returning response
        try {
            $token = $userFromDb->createToken('Social Token')->plainTextToken;
        } catch (ClientException $exception) {

            exit();
            return response()->json(['message' => 'Invalid credentials provided.'], 422);
        }

        $response = ['token' => $token, 'message' => 'Successful'];
        return response()->json($response, 200);
    }

    public function get()
    {

        $clients = $this->clientsService->get();
        return $this->apiResponse($clients);
    }

    public function create(StoreRequest $request)
    {

        $client = $request->validated();
        $this->clientsService->create($client);
        return $this->apiResponse();
    }
    public function update(UpdateRequest $request)
    {

        $user = $request->validated();
        $this->clientsService->update($user);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->clientsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
