<?php

namespace App\Http\Controllers\Users;

use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\Users\AdminsService;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;

class AdminsController extends Controller
{

    use ResponsesTrait;
    private $adminsService;

    public function __construct()
    {

        $this->adminsService = new AdminsService();
    }

    public function toggleActivation($id, $activationStatus)
    {

        $this->adminsService->toggleActivation($id, $activationStatus);
        return $this->apiResponse(message: "Activation toggled");
    }

    public function get()
    {
        //dd(Hash::make("al1234"));
        $admins = $this->adminsService->get(request('active'));
        return $this->apiResponse($admins);
    }

    public function create(UserStoreRequest $request)
    {

        $data = $request->validated();
        $this->adminsService->create($data);
        return $this->apiResponse();
    }

    public function update(UserUpdateRequest $request)
    {

        $admin = $request->validated();
        $this->adminsService->update($admin);
        return $this->apiResponse();
    }

    public function delete($id){

        $this->adminsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }
}
