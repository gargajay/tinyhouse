<?php

namespace App\Library;

use App\Models\FcmToken;
use App\Models\Setting;

class PushNotification
{
    protected static $serverKey = NULL;

    public function __construct()
    {
    }

    public static function send($notificationData = [],$sound='yes')
    {
        $serverKey = "";

        $settingObj = Setting::where('name', 'push_notification_server_key')->first();

        if ($settingObj) {
            $value = $settingObj->value;

            if (isset($value['push_notification_server_key'])) {
                $serverKey = $value['push_notification_server_key'];
            }
        }

        $dataArray =  array(
            "title" => $notificationData['title'] ?? "",
            "body" => $notificationData['message'],
            "sendby" => $notificationData['send_by'],
            "type" => $notificationData['type'],
            "content-available" => 1,
            "data1" => $notificationData['data'] ?? "",
            "badge" => $notificationData['badge'] ?? 1,
       );

       if(isset($notificationData['user_id'])){
     $deviceTokens =    FcmToken::where('user_id',$notificationData['user_id'])->pluck('token')->toArray();
       }

       if($sound=='no'){
        $dataArray['sound'] ='default';
       }


        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            "registration_ids" => $deviceTokens,
            "notification" =>$dataArray,
            "data" => $dataArray,
            "priority" => 10
        );

        if (isset($notificationData['metadata']) && !empty($notificationData['metadata'])) {
            $fields['notification']['metadata'] = $notificationData['metadata'];
            $fields['data']['metadata'] = $notificationData['metadata'];
        }

        //print_pre($fields);
        $fields = json_encode($fields);
        $headers = array(
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        curl_close($ch);

        //print_pre($result);

        return $result;
    }

    
}
