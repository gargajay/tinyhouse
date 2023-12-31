<?php

//use Thumbnail;

use App\Models\FcmToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


function unique_multidimensional_array($array, $key)
{
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach ($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

if (!function_exists('saveGeolocation')) {
    function saveGeolocation($db, $table, $resourceId, $lat = NULL, $lng = NULL)
    {
        Log::info("enter 1");
        if ($lat && $lng) {
        //    $db::insert("UPDATE $table SET geolocation = ST_MakePoint($lng, $lat) WHERE id = '$resourceId'");
            


            DB::table($table)
            ->where('id', $resourceId)
            ->update(['geolocation' => DB::raw("ST_GeomFromText('POINT($lng $lat)')")]);

                }
            }
}

if (!function_exists('saveDeviceToken')) {
    function saveDeviceToken($userObj,$deviceType,$token)
    {
       $fcmToken =  FcmToken::where(['user_id'=>$userObj->id,'token'=>$token])->first();

       if(empty($fcmToken))
       {
        $fcmToken = new FcmToken();
       }

       $fcmToken->user_id = $userObj->id;
       $fcmToken->device_type  = $deviceType;
       $fcmToken->token  = $token;
       $fcmToken->save();

    }
}



if (!function_exists('validation_error_response')) {
    function validation_error_response($errors)
    {
        $response = [];
        $counter = 0;
        foreach ($errors as $key => $value) {
            if ($counter > 0) {
                break;
            }

            $errorMessage = $value[0];
        }

        $response['message'] = $errorMessage;
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        return $response;
    }
}

if (!function_exists('base64_to_image')) {
    function base64_to_image($base64_string)
    {
        // Define the Base64 value you need to save as an image
        $b64 = $base64_string;

        // Obtain the original content (usually binary data)
        $bin = base64_decode($b64);

        // Gather information about the image using the GD library
        $size = getImageSizeFromString($bin);

        // Check the MIME type to be sure that the binary data is an image
        if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
            die('Base64 value is not a valid image');
        }

        // Mime types are represented as image/gif, image/png, image/jpeg, and so on
        // Therefore, to extract the image extension, we subtract everything after the “image/” prefix
        $ext = substr($size['mime'], 6);

        // Make sure that you save only the desired file extensions
        if (!in_array($ext, ['png', 'gif', 'jpeg'])) {
            die('Unsupported image type');
        }

        $file_name = "chat_image_" . time() . "." . $ext;

        // Specify the location where you want to save the image
        $img_file = IMAGE_UPLOAD_PATH . $file_name;

        // Save binary data as raw data (that is, it will not remove metadata or invalid contents)
        // In this case, the PHP backdoor will be stored on the server
        file_put_contents($img_file, $bin);

        return [
            'file_name' => $file_name,
            'file_type' => $ext,
        ];
    }
}

if (!function_exists('uploadImages')) {
    function uploadImages($images = [], $destinationPath = '')
    {
       
        $image_path_data = [];

     //   $s3url = 'https://gocarhub.s3.us-east-2.amazonaws.com/';


        foreach ($images as $key => $file) {
         
           // dd()
            $fileName = time() . '-' . $file->getClientOriginalName();
            $fileName = str_replace(" ", "_", $fileName);
            $extension = $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);

             $mime = $file->getClientMimeType();

         
            $fileType = "";
            if (strstr($mime, "video/")) {
                $fileType = "video";
            } else if (strstr($mime, "image/")) {
                $fileType = "image";
            } else if (strstr($mime, "audio/")) {
                $fileType = "audio";
            }

            $image_path_data[$key] = [
                'file_name' => $fileName,
                'file_type' => $fileType,
                'file_extension' => $extension ?? '',
            ];
        }

        return $image_path_data;
    }
}

if (!function_exists('uploadSingleImage')) {
    function uploadSingleImage($file, $destinationPath = '')
    {
        $fileName = time() . '-' . $file->getClientOriginalName();
        $fileName = str_replace(" ", "_", $fileName);
        $file->move($destinationPath, $fileName);
        return $fileName;
    }
}

if (!function_exists('uploadImagesKey')) {
    function uploadImagesKey($keys, $images = [], $destinationPath = '')
    {
        $image_path_data = [];
        foreach ($images as $key => $file) {
            $fileName = time() . '-' . $file->getClientOriginalName();
            $fileName = str_replace(" ", "_", $fileName);
            $extension = $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $mime = $file->getClientMimeType();

            $fileType = "";
            if (strstr($mime, "video/")) {
                $fileType = "video";
            } else if (strstr($mime, "image/")) {
                $fileType = "image";
            } else if (strstr($mime, "audio/")) {
                $fileType = "audio";
            }

            $image_path_data[$key] = [
                $keys[$key] => $fileName
            ];
        }
        return $image_path_data;
    }
}

if (!function_exists('create_thumbnail')) {
    function create_thumbnail($filePath = '', $fileName = '', $userId = '')
    {
        $thumbnailName = $userId . time() . '_thumbnail.jpg';

        $thumbnailStatus = \Thumbnail::getThumbnail($filePath . $fileName, $filePath, $thumbnailName, 2);

        if ($thumbnailStatus) {
            return $thumbnailName;
        }
        return '';
    }
}

if (!function_exists('generateNumericOTP')) {
    function generateNumericOTP($n)
    {

        // Take a generator string which consist of
        // all numeric digits
        $generator = "1357902468";

        // Iterate for n-times and pick a single character
        // from generator and append it to $result

        // Login for generating a random character from generator
        //     ---generate a random number
        //     ---take modulus of same with length of generator (say i)
        //     ---append the character at place (i) from generator to result

        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        // Return result
        return $result;
    }
}

if (!function_exists('addMinutesToTime')) {
    function addMinutesToTime($timeData = [])
    {
        if (!isset($timeData['time'])) {
            $time = new DateTime();
        } else {
            $time = new DateTime($timeData['time']);
        }

        if (!isset($timeData['minute'])) {
            $minutes_to_add = 2;
        } else {
            $minutes_to_add = (int)$timeData['minute'];
        }

        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

        $stamp = $time->format('Y-m-d H:i:s');

        return $stamp;
    }
}

if (!function_exists('object_to_array')) {
    function object_to_array($obj, &$arr)
    {
        if (!is_object($obj) && !is_array($obj)) {
            $arr = $obj;
            return $arr;
        }

        foreach ($obj as $key => $value) {
            if (!empty($value)) {
                $arr[$key] = array();
                object_to_array($value, $arr[$key]);
            } else {
                $arr[$key] = $value;
            }
        }

        return $arr;
    }
}

if (!function_exists('sort_restaurant_days')) {
    function sort_restaurant_days($days = [])
    {
        $daysArr = [];

        if (!isset($days['monday']['is_opened'])) {
            $daysArr['monday']['is_opened'] = FALSE;
        } else {
            $daysArr['monday']['is_opened'] = TRUE;
            $daysArr['monday']['open'] = $days['monday']['open'];
            $daysArr['monday']['close'] = $days['monday']['close'];
        }

        if (!isset($days['tuesday']['is_opened'])) {
            $daysArr['tuesday']['is_opened'] = FALSE;
        } else {
            $daysArr['tuesday']['is_opened'] = TRUE;
            $daysArr['tuesday']['open'] = $days['tuesday']['open'];
            $daysArr['tuesday']['close'] = $days['tuesday']['close'];
        }

        if (!isset($days['wednesday']['is_opened'])) {
            $daysArr['wednesday']['is_opened'] = FALSE;
        } else {
            $daysArr['wednesday']['is_opened'] = TRUE;
            $daysArr['wednesday']['open'] = $days['wednesday']['open'];
            $daysArr['wednesday']['close'] = $days['wednesday']['close'];
        }

        if (!isset($days['thursday']['is_opened'])) {
            $daysArr['thursday']['is_opened'] = FALSE;
        } else {
            $daysArr['thursday']['is_opened'] = TRUE;
            $daysArr['thursday']['open'] = $days['thursday']['open'];
            $daysArr['thursday']['close'] = $days['thursday']['close'];
        }

        if (!isset($days['friday']['is_opened'])) {
            $daysArr['friday']['is_opened'] = FALSE;
        } else {
            $daysArr['friday']['is_opened'] = TRUE;
            $daysArr['friday']['open'] = $days['friday']['open'];
            $daysArr['friday']['close'] = $days['friday']['close'];
        }

        if (!isset($days['saturday']['is_opened'])) {
            $daysArr['saturday']['is_opened'] = FALSE;
        } else {
            $daysArr['saturday']['is_opened'] = TRUE;
            $daysArr['saturday']['open'] = $days['saturday']['open'];
            $daysArr['saturday']['close'] = $days['saturday']['close'];
        }

        if (!isset($days['sunday']['is_opened'])) {
            $daysArr['sunday']['is_opened'] = FALSE;
        } else {
            $daysArr['sunday']['is_opened'] = TRUE;
            $daysArr['sunday']['open'] = $days['sunday']['open'];
            $daysArr['sunday']['close'] = $days['sunday']['close'];
        }

        return $daysArr;
    }
}

if (!function_exists('send_push_notification_OLD')) {
    function send_push_notification_OLD($notificationData = [])
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            "registration_ids" => array(
                $notificationData['device_token']
            ),

            "priority" => 10
        );

        if (isset($notificationData['device_type']) && !empty($notificationData['device_type'])) {
            if ($notificationData['device_type'] == 'ios') {
                $fields["notification"] = array(
                    "body" => $notificationData['message'],
                    "sendby" => $notificationData['send_by'],
                    "type" => $notificationData['type'],
                    "content-available" => 1,
                    "badge" => $notificationData['badge'] ?? 1,
                    "sound" => "default",
                );

                $fields["data"] = array(
                    "body" => $notificationData['message'],
                    "sendby" => $notificationData['send_by'],
                    "type" => $notificationData['type'],
                    "content-available" => 1,
                    "badge" => $notificationData['badge'] ?? 1,
                    "sound" => "default",
                );
            } elseif ($notificationData['device_type'] == 'android') {
                $fields["data"] = array(
                    "body" => $notificationData['message'],
                    "sendby" => $notificationData['send_by'],
                    "type" => $notificationData['type'],
                    "content-available" => 1,
                    "badge" => $notificationData['badge'] ?? 1,
                    "sound" => "default",
                );
            }
        } else { // IF EMPTY ADD BOTH notification AND data
            $fields["notification"] = array(
                "body" => $notificationData['message'],
                "sendby" => $notificationData['send_by'],
                "type" => $notificationData['type'],
                "content-available" => 1,
                "badge" => $notificationData['badge'] ?? 1,
                "sound" => "default",
            );

            $fields["data"] = array(
                "body" => $notificationData['message'],
                "sendby" => $notificationData['send_by'],
                "type" => $notificationData['type'],
                "content-available" => 1,
                "badge" => $notificationData['badge'] ?? 1,
                "sound" => "default",
            );
        }

        if (isset($notificationData['metadata']) && !empty($notificationData['metadata'])) {
            $fields['notification']['metadata'] = $notificationData['metadata'];
            $fields['data']['metadata'] = $notificationData['metadata'];
        }

        //print_pre($fields);
        $fields = json_encode($fields);
        $headers = array(
            'Authorization: key=' . PUSH_NOTIFICATION_SERVER_KEY,
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
        return $result;
    }
}

if (!function_exists('send_push_notification')) {
    function send_push_notification($notificationData = [])
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            "registration_ids" => $notificationData['device_token'],
            "notification" => array(
                "body" => $notificationData['message'],
                "sendby" => $notificationData['send_by'],
                "type" => $notificationData['type'],
                "content-available" => 1,
                "badge" => $notificationData['badge'] ?? 1,
                "sound" => "default",
            ),
            "data" => array(
                "body" => $notificationData['message'],
                "sendby" => $notificationData['send_by'],
                "type" => $notificationData['type'],
                "content-available" => 1,
                "badge" => $notificationData['badge'] ?? 1,
                "sound" => "default",
            ),
            "priority" => 10
        );

        if (isset($notificationData['metadata']) && !empty($notificationData['metadata'])) {
            $fields['notification']['metadata'] = $notificationData['metadata'];
            $fields['data']['metadata'] = $notificationData['metadata'];
        }

        //print_pre($fields);
        $fields = json_encode($fields);
        $headers = array(
            //'Authorization: key=' . PUSH_NOTIFICATION_SERVER_KEY,
            'Authorization: key=' . config('mail.push_notification.key'),
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
        return $result;
    }
}

if (!function_exists('create_and_save_stripe_customer_id')) {
    function create_and_save_stripe_customer_id($array = [])
    {
        echo "<pre>";
        print_r($array);
        die;
    }
}

if (!function_exists('print_pre')) {
    function print_pre($array = [])
    {
        echo "<pre>";
        print_r($array);
        die;
    }
}

function getWeeks($today = null, $scheduleMonths = 6)
{

    $today = !is_null($today) ? \Carbon\Carbon::createFromFormat('Y-m-d', $today) : \Carbon\Carbon::now();

    $startDate = \Carbon\Carbon::instance($today)->startOfMonth()->startOfWeek()->subDay(); // start on Sunday
    $endDate = \Carbon\Carbon::instance($startDate)->addMonths($scheduleMonths)->endOfMonth();
    $endDate->addDays(6 - $endDate->dayOfWeek);

    $epoch = \Carbon\Carbon::createFromTimestamp(0);
    $firstDay = $epoch->diffInDays($startDate);
    $lastDay = $epoch->diffInDays($endDate);

    $week = 0;
    $monthNum = $today->month;
    $yearNum = $today->year;
    $prevDay = null;
    $theDay = $startDate;
    $prevMonth = $monthNum;

    $data = array();

    while ($firstDay < $lastDay) {

        if (($theDay->dayOfWeek == \Carbon\Carbon::SUNDAY) && (($theDay->month > $monthNum) || ($theDay->month == 1))) $monthNum = $theDay->month;
        if ($prevMonth > $monthNum) $yearNum++;

        $theMonth = \Carbon\Carbon::createFromFormat("Y-m-d", $yearNum . "-" . $monthNum . "-01")->format('F Y');

        if (!array_key_exists($theMonth, $data)) $data[$theMonth] = array();
        if (!array_key_exists($week, $data[$theMonth])) $data[$theMonth][$week] = array(
            'day_range' => '',
        );

        if ($theDay->dayOfWeek == \Carbon\Carbon::SUNDAY) $data[$theMonth][$week]['day_range'] = sprintf("%d-", $theDay->day);
        if ($theDay->dayOfWeek == \Carbon\Carbon::SATURDAY) $data[$theMonth][$week]['day_range'] .= sprintf("%d", $theDay->day);

        $firstDay++;
        if ($theDay->dayOfWeek == \Carbon\Carbon::SATURDAY) $week++;
        $theDay = $theDay->copy()->addDay();
        $prevMonth = $monthNum;
    }

    $totalWeeks = $week;

    return array(
        'startDate' => $startDate,
        'endDate' => $endDate,
        'totalWeeks' => $totalWeeks,
        'schedule' => $data,
    );
}

function weekOfMonth($date)
{

    $firstOfMonth = strtotime(date("Y-m-01", $date));
    $lastWeekNumber = (int)date("W", $date);
    $firstWeekNumber = (int)date("W", $firstOfMonth);
    if (12 === (int)date("m", $date)) {
        if (1 == $lastWeekNumber) {
            $lastWeekNumber = (int)date("W", ($date - (7 * 24 * 60 * 60))) + 1;
        }
    } elseif (1 === (int)date("m", $date) and 1 < $firstWeekNumber) {
        $firstWeekNumber = 0;
    }
    return $lastWeekNumber - $firstWeekNumber + 1;
}

function weeks($month, $year)
{
    $lastday = date("t", mktime(0, 0, 0, $month, 1, $year));
    return weekOfMonth(strtotime($year . '-' . $month . '-' . $lastday));
}

function generateRandomToken($length = 10, $string = 'xyz')
{
    $characters = $string . '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' . time();
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function random_color_part()
{
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

function random_color()
{
    return random_color_part() . random_color_part() . random_color_part();
}

function array_values_recursive($arr)
{
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            $arr[$key] = array_values($value);
        }
    }

    return $arr;
}

function generate_random_color($i = 0)
{

    $colors = [
        "rgb(47, 76, 221)",
        "rgb(43, 193, 85)",
        "rgb(255, 109, 77)",
        "rgb(255, 152, 0)",
        "rgb(62, 73, 84)",
        "rgb(247, 43, 80)",
    ];
    return $colors[$i];
}

if (!function_exists('x_week_range')) {
    function x_week_range($date = NULL)
    {
        $date = $date ?? date('Y-m-d');
        $day = date('N', strtotime($date));
        $week_start = date('Y-m-d', strtotime('-' . ($day - 1) . ' days', strtotime($date)));
        $week_end = date('Y-m-d', strtotime('+' . (7 - $day) . ' days', strtotime($date)));

        return [$week_start, $week_end];
    }
}

if (!function_exists('get_setting')) {
    function get_setting()
    {
        $settingsObj = \App\Models\Setting::first();

        if ($settingsObj) {
            return $settingsObj->settings;
        }

        return [];
    }
}

if (!function_exists('get_setting_by_key')) {
    function get_setting_by_key($settingName = '', $settingsKey = '')
    {
        $settingsObj = \App\Models\Setting::first();

        if ($settingsObj) {
            $settings = (array) $settingsObj->settings;

            if (!empty($settingName)) {
                if (isset($settings[$settingName])) {
                    if (isset($settings[$settingName]->$settingsKey)) {
                        return $settings[$settingName]->$settingsKey;
                    }
                }
            }
        }

        return '';
    }
}

if (!function_exists('lastOneYearMontlyData')) {
    /**
     * Get monthly data for the last 12 months.
     */
    function lastOneYearMontlyData(object $mobel)
    {
        $monthName = Carbon\Carbon::now()->subMonths(1)->format('M-y');

        $data = $mobel->selectRaw('COUNT(*)
 as count, DATE_FORMAT(created_at, \'MM\') as month , MAX(id)
 as id')
            ->whereRaw("DATE(created_at) BETWEEN ? AND ?", [
                Carbon\Carbon::now()->subMonths(12)->startOfMonth()->format('Y-m-d'),
                Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')
 ])->groupByRaw('DATE_FORMAT(created_at, \'MM\')')->orderBy('id', 'asc')->get()->toArray();

        // Create an associative array with month as key and data count as value
        $data = array_combine(array_column($data, 'month'), array_column($data, 'count'));
        // Generate monthly data for the last 12 months
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            // Get the month number and name
            $monthNum = Carbon\Carbon::now()->startOfMonth()->subMonths($i)->format('m');
            $monthName = Carbon\Carbon::now()->startOfMonth()->subMonths($i)->format('M-y');

            // Add monthly data to the array
            $monthlyData[] = ['month' => $monthName, 'total' => isset($data[$monthNum]) ? $data[$monthNum] : 0];
        }
        return $monthlyData;
    }
}

if (!function_exists('getDatesFromRange')) {
    function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        $array = array();
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        return $array;
    }
}

if (!function_exists('getClosest')) {
    function getClosest($search, $arr)
    {
        $closest = null;
        foreach ($arr as $item) {
            if ($closest === null || abs($search - $closest) > abs($item - $search)) {
                $closest = $item;
            }
        }
        return $closest;
    }
}

if (!function_exists('generate_string')) {
    function generate_string($input, $strength = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $strength; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}


if (!function_exists('successReturn')) {
    function successReturn($data = [], $message = '' , $dbCommit = true)
    {
        if($dbCommit)
        {
            \Illuminate\Support\Facades\DB::commit();
        }
        return response()->json(['success'=>true,'status'=> STATUS_OK,'message'=> $message,'data'=>$data], STATUS_OK);
    }
}


if (!function_exists('updateRequestValue')) {
    function updateRequestValue($key = null, $value = null)
    {
        // Check if the key and value parameters are not null
        if (!is_null($key) && !is_null($value) && $value != '') {
            // Get all the data from the current request
            $data = request()->all();

            // Check if the key exists in the data
            if (array_key_exists($key, $data)) {
                // Set the new value for the key in the request object and the data array
                request()->$key = $data[$key] = $value;

                // Merge the updated data array back into the request object
                request()->merge($data);

                // Return true to indicate success
                return true;
            }
        }

        // Return false to indicate failure
        return false;
    }
}