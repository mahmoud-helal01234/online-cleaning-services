<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Http\Services\Users\UsersService;
use App\Http\Requests\User\UserUpdateRequest;


class UsersController extends Controller
{

    use ResponsesTrait;
    private $usersService;
    public function __construct()
    {

        $this->usersService = new UsersService();

    }

    public function getSelect()
    {

        $users = $this->usersService->getSelect(request('active'),request('roles'));
        return $this->apiResponse($users);
    }

    public function get()
    {

        $users = $this->usersService->get();
        return $this->apiResponse(UsersResource::collection($users));
    }
    public function viewProfile()
    {
        $user =$this->usersService->viewProfile();

        return $this->apiResponse($user);
    }
    public function createDeviceToken(Request $request)
        {

            $this->usersService->createDeviceToken($request->device_token);
            return $this->apiResponse(true, true, __('created'));
        }
    public function update(UserUpdateRequest $request)
    {

        $user = $request->validated();
        $this->usersService->update($user);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->usersService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}
