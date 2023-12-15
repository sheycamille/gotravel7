<?php

function sendNotification($user, $details)
{
    $server_key = config('app.fcm_key');

    if ($user) {

        $fields = array(
            'notification' => [
                'body' => $details['body'],
                'title' => $details['title'],
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                'sound' => 'default',
            ],

            'data' => [
                'status' => 'done',
                'id' => $user->fcm_token,
                'image'=> $details['image'],
                'category'=> 'login',
                'type' => 'message',
            ],
            "to" => $user->fcm_token,
            "apns" => [
                "payload" => [
                    "aps" => [
                        "sound" => "default"
                    ]
                ]
            ]
        );

        $headers = array(
            'Authorization: key=' . $server_key,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
        if ($result === FALSE)
        {
            info('FCM Send Error: ' . curl_error($ch));
        }
        $result = json_decode($result,true);
        $responseData['android'] =["result" =>$result ];
        curl_close( $ch );
    }
}