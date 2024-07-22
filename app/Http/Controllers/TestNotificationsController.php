<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use App\Events\TestNotifications;
use App\Http\Traits\ResponsesTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Orders\NotificationsService;


class TestNotificationsController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $notificationsService;

    public function __construct()
    {

        $this->notificationsService = new NotificationsService();
    }

    public function createChannel()
    {
        return response()->json([
            'message' => 'Pusher channel will be created when the event is broadcasted'
        ]);
    }


    public function broadcastEvent()
    {
        $data = [
            'message' => 'Hello from Pusher'
        ];
        event(new TestNotifications($data));

        return response()->json([
            'message' => 'Pusher event broadcasted successfully'
        ]);
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

