<?php

namespace App\Listeners;

use App\Models\DeviceToken;
use App\Events\TokenExpired;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteDeviceToken implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TokenExpired  $event
     * @return void
     */
    public function handle(TokenExpired $event)
    {
        // Retrieve the device token for the user
        $deviceToken = DeviceToken::where('user_id', $event->userId)->first();

        if ($deviceToken) {
            // Delete the device token
            $deviceToken->delete();
        }
    }
}
