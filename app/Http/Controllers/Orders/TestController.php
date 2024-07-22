<?php

namespace App\Http\Controllers\Orders;

use App\Events\TestNotifications;
use Illuminate\Support\Facades\Event;
use App\Http\Controllers\Controller;


class TestController extends Controller
{

    public function broadcastEvent()
    {
        $data = [
            'message' => 'Hello from Pusher'
        ];
        event(new TestNotifications($data));
    }

}

