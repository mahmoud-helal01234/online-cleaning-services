<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Services\Orders\NotificationsService;
use App\Http\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $notificationsService;

    public function __construct()
    {

        $this->notificationsService = new NotificationsService();
    }

    public function get()
    {


        $notifications = $this->notificationsService->get();
        return $this->apiResponse($notifications);
    }

    // public function create(StoreRequest $request)
    // {

    //     $notification = $request->validated();

    //     $this->notificationsService->create($notification);

    //     return $this->apiResponse();
    // }
    public function delete($id)
    {

        $this->notificationsService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}

