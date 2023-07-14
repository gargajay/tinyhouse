<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Library\PushNotification;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class BookingController extends Controller
{

    public function add(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {

            $rules = [
                'giver_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                $response['status'] = UNPROCESSABLE_ENTITY;
                return response()->json($response, $response['status']);
            }

            $userId = $request->user()->id;

            $requestData = $request->all();
            if ($request->user()->user_type == 'giver') {
                $response['message'] = LOGIN_AS_USER;
                $response['status'] = UNPROCESSABLE_ENTITY;
                return response()->json($response, $response['status']);
            }

            $bookingObj = new Booking;
            $bookingObj->user_id = $userId;
            $bookingObj->giver_id = $requestData['giver_id'];
            $bookingObj->gift_id = $requestData['gift_id'];
            $bookingObj->booking_date = Carbon::now();

            if ($bookingObj->save()) {

                if ($request->user()->user_type == 'giver') {
                    $userObj = User::find($bookingObj->user_id);
                }
                if ($request->user()->user_type == 'receiver') {
                    $userObj = User::find($bookingObj->giver_id);
                    $reciverObj = User::find($userId);
                }

                $extraData['user_detail'] = [
                    'image' => $userObj->image,
                ];
                $notificationType = BOOKING_REQUEST;
                $notificationMsg = 'You have received a booking request from ' . $reciverObj->name . ' on date ' . $bookingObj->booking_date->format('m-d-Y');
                $receiverMsg = 'You have sent booking request to ' . $userObj->name . ' on date ' . $bookingObj->booking_date->format('m-d-Y');
                $notificationObj = new Notification;
                $notificationObj->user_id = $requestData['giver_id'];
                $notificationObj->notification_from = $userId;
                $notificationObj->booking_id = $bookingObj->id;
                $notificationObj->gift_id = $requestData['gift_id'];
                $notificationObj->giver_id = $userId;
                $notificationObj->message = $notificationMsg;
                $notificationObj->receiver_msg =  $receiverMsg;
                $notificationObj->type = $notificationType;
                $notificationObj->data = $userObj->image;

                if ($notificationObj->save()) {
                    $dataObj = [];
                    $dataObj['image'] = $userObj;
                    $giverObj = User::find($requestData['giver_id']);

                    $notificationData = [
                        'title' => "Dear " . $giverObj->first_name,
                        'message' => $notificationMsg,
                        'user_id' => $giverObj->id,
                        'send_by' => APP_NAME,
                        'badge' => "1",
                        'id' => $bookingObj->id,
                        'type' => $notificationType,
                    ];

                    PushNotification::send($notificationData);
                }
            }
            DB::commit();

            $response['data'] = Booking::where('id', $bookingObj->id)->first();
            $response['message'] = BOOKING_CREATE_SUCCESSFULLY;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }

    public function BookingStatusUpdate(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            $rules = [
                'booking_id' => 'Required|Exists:bookings,id',
                'status' => 'Required|In:2,3,4,5,6,7',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                $response['status'] = UNPROCESSABLE_ENTITY;
                return response()->json($response, $response['status']);
            }
            $userId = $request->user()->id;
            $requestData = $request->all();
            $bookingObj = Booking::find($requestData['booking_id']);
            if ($bookingObj->status >= $requestData['status']) {
                $response['message'] = 'Booking already ' . SERVICE_STATUS[$bookingObj->status];
                $response['status'] = UNPROCESSABLE_ENTITY;
                return response()->json($response, $response['status']);
            }
            $bookingDate = Carbon::now();

            if ($requestData['status'] == 2) { // accepted booking
                $notificationMsg = 'Your booking has been accepted on date ' . $bookingDate->format('m-d-Y');
                // $notificationMsg =  $notificationObj->message ;
                $notifyTo = $bookingObj->user_id;
                $notificationFrom = $bookingObj->giver_id;
                $userObj = User::find($bookingObj->user_id);
                $userToken = $userObj->device_token;
                $notificationType = SERVICE_ACCEPTED;
            }
            if ($requestData['status'] == 3) { // reject booking
                $notificationMsg = 'Your booking has been rejected on date ' . $bookingDate->format('m-d-Y');
                $notifyTo = $bookingObj->user_id;
                $notificationFrom = $bookingObj->giver_id;
                $userObj = User::find($bookingObj->user_id);
                $userToken = $userObj->device_token;
                $notificationType = SERVICE_REJECTED;
            }
            $bookingObj->status = $requestData['status'];
            $bookingObj->save();

            $notificationObj =  Notification::where('id', $requestData['notification_id'])->first();
            if ($notificationObj) {
                //  $notificationObj = new Notification;
                $notificationObj->user_id  = $notificationFrom;
                $notificationObj->notification_from = $notifyTo;
                $notificationObj->booking_id = $bookingObj->id;
                $notificationObj->status =  $requestData['status'];
                $notificationObj->gift_id = $bookingObj->gift_id;
                $notificationObj->type =  $notificationType;
                $notificationObj->receiver_msg =  $notificationMsg;
                $notificationObj->save();
            }



            if ($notificationObj->save()) {
                $notificationData = [

                    'title' => "Dear " . $userObj->name,
                    'message' => $notificationMsg,
                    'user_id' => $userObj->id,
                    'send_by' => config('custom.app_name'),
                    'badge' => "1",
                    'id' => $bookingObj->id,
                    'type' => $notificationType,
                ];

                PushNotification::send($notificationData);
            }
            DB::commit();
            $response['data'] = $bookingObj;
            $response['message'] = 'Booking ' . SERVICE_STATUS[$requestData['status']];
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }
}
