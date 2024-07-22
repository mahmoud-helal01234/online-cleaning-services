<?php

namespace App\Http\Traits;

trait NotificationTrait
{
      function sendNotification($data_send=array(),$users=array()){
        $content =
        [
            "ar" => $data_send["message_ar"],
            "en" => $data_send["message_en"]
        ];
        $headings=
        [
            "ar" => $data_send["title_ar"],
            "en" => $data_send["title_en"]
        ]; //<---- this will add heading
        $fields = array(
            'app_id' => 'ab4cc51f-a93d-46db-99e3-d31408be0f72',
            'data' => $data_send,
            'isAndroid'=>true,
            'isIos'=>true,
            'content_available'=>true,
            'small_icon'    => 'ic_launcher-web',
            //'large_icon' =>"ic_launcher_round.png",
            'contents' => $content,
            'headings'=> $headings //<---- include it to request
        );

        if(empty($users))
        {
            $fields['included_segments']=array('All');
        }else
        {
            $fields['user_ids']=$users;
        }

        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ZjNlOGJhNWQtMTBjOS00OTBhLWI0ZjAtMWZhYTg5NTVhNzU2'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        // var_dump($response);
        curl_close($ch);

        return $response;
    }
}