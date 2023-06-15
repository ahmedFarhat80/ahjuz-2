<?php

namespace App\Services;

use Illuminate\Support\Str;

class FirebaseService
{
    public static function sendNotification($token, $title) 
    {  
        $data = [
        "registration_ids" => [$token],
        "notification" => [
            'title'         => $title,
            "sound"         => "default",
        ],
        ];

        return self::send(json_encode($data));
    }

    public static function sendMessageNotification($token, $title, $property, $customer, $body) 
    {  
        $data = [
        "registration_ids" => [$token],
        "notification" => [
            'title'         => $title,
            "body"          => Str::limit($body, 60),
            'property_name' => $property->name,
            'route'         => "/messages/properties/$property->id/customers/$customer->id",         
            "sound"         => "default",
        ],
        ];

        return self::send(json_encode($data));
    }

    private static function send($data)
    {
        $url = "https://fcm.googleapis.com/fcm/send";            
        $key = "AAAAWuk1qVg:APA91bFnntaBt0VLyiwnisr6-pGx3rKe2FEhzxxbP9EMuqg_NOCf5vXOvX04EEaeIRaSbZGgC8hITJlGe0vjTnrXGnA5b0SXGw0kiEfwR7jryC9hCPYR0dcaQGniH-8EtKTAwPf4qvlM";            
        $header = [
        'authorization: key=' . $key,
            'content-type: application/json'
        ];    

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);    
        curl_close($ch);

        return $result;
    }
}

