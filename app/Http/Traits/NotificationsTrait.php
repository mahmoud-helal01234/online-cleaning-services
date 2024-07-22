<?php

namespace App\Http\Traits;

use Exception;
use App\Models\UserDeviceToken;
use Illuminate\Support\Facades\App;


trait NotificationsTrait
{
    public function getDeviceTokensForOrderStatusChangedNotification($userIds)
    {

        return UserDeviceToken::whereIn('user_id', $userIds)->pluck('device_token')->get();
    }

    public function sendNotification($title, $body, $data = [], $toAllUsers = false, $firebaseDeviceTokens = [])
    {
        // $firebaseDeviceTokens = User::whereNotNull('device_token')->pluck('device_token')->all();

        try{
        if ($toAllUsers) {
            // there's another logic to add
        }

        $SERVER_API_KEY =
            'AAAAFLq06pQ:APA91bGbmcKhIfG4C-INa7Y8800lSYrZJvMDd1Jxt08beGtblhRMGfAELjDPHvBA_IKTy7WL2YSI3JBcymB3UKc5s2jUUVM9s7CAnFTTSz0VyAe8wr_iUdN1Puj_Vdb8fhHwMqcxaYeJ';

        $data = [

            "registration_ids" => $firebaseDeviceTokens,
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            "data" => $data
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
    }catch(Exception $ex){

    }

    }

    public function getCurrentLanguage()
    {

        return App::getLocale();
    }
}
