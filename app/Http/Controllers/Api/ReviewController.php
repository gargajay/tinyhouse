<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Library\PushNotification;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Notification;
use App\Models\ReviewRating;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function review(Request $request)
    {


        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $rules = [
                'car_id' => 'required|Exists:cars,id'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                $response['status'] = UNPROCESSABLE_ENTITY;
                return response()->json($response, $response['status']);
            }

            $requestData = $request->all();

            $userId = $request->user()->id;

            $userObj = User::find($userId);

            $bookingObj = Car::find($requestData['car_id']);

            $resourceObj = ReviewRating::where('car_id', $requestData['car_id'])
                ->where(function ($query) use ($userId) {
                    $query->where('review_by', $userId);
                })
                ->first();

                

            $responseMessage = __("message.REVIEW_UPDATED_SUCCESSFULLY");

            if (!$resourceObj) {
                if ($userObj->user_type == 'buyer') {
                    $user_id = $bookingObj->user_id;
                }

                $resourceObj = new ReviewRating;
                $resourceObj->car_id = $requestData['car_id'];
                $resourceObj->user_id =  $user_id;  //seller Id
                $resourceObj->review_by = $userId; //buyer id token

                $responseMessage = __("message.REVIEW_ADDED_SUCCESSFULLY");
            }

            $resourceObj->rating = $requestData['rating'] ?? $resourceObj->rating;
            $resourceObj->title = $requestData['title'] ?? $resourceObj->title;
            $resourceObj->review = $requestData['review'] ?? $resourceObj->review ?? "";

            if ($resourceObj->save()) {
                DB::commit();
                if ($userObj->user_type == 'buyer') {
                    // $carObj = Car::find($resourceObj->car_id);
                    $sellerUserOj = User::find($resourceObj->user_id);
                }
                if ($userObj->user_type == 'seller') {
                    $sellerUserOj = User::find($resourceObj->review_by);
                }

                $notificationMsg = $userObj->first_name . ' ' . $userObj->last_name . ' ' . "left review on your post. ";
                $notificationType = "Review";
                $notificationData = [];
                $extraData = [];

                $device_token = $sellerUserOj->device_token;

                $extraData['user_detail'] = [
                    'id' => $request->user()->id,
                    'first_name' => $request->user()->first_name,
                    'last_name' => $request->user()->last_name,
                    'email' => $request->user()->email,
                    'image' => $request->user()->image,
                ];

                $notificationObj = new Notification;
                $notificationObj->user_id = $sellerUserOj->id;  //Review given to.... seller
                $notificationObj->message = $notificationMsg;
                $notificationObj->type = $notificationType;
                $notificationObj->car_id = $bookingObj->id;
                $notificationObj->notification_from = $userObj->id;   //Review given from .... buyer
                $notificationObj->data = json_encode($extraData);

                if ($notificationObj->save()) {
                    $notificationData = [
                        'title' => "Dear " . $sellerUserOj->first_name . ' ' . $sellerUserOj->last_name,
                        'message' => $notificationMsg,
                        'user_id' =>  $sellerUserOj->id,
                        'send_by' => APP_NAME,
                        'id' => $resourceObj->id,
                        'type' => $notificationType,
                        'badge' => "1",
                    ];
                    PushNotification::send($notificationData);
                }
            }

            $response['data'] = $resourceObj;
            $response['message'] = $responseMessage;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }

        return response()->json($response, $response['status']);
    }

    public function Index(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $userId = $request->user()->id;
            $requestData = $request->all();

            $resourceObj = ReviewRating::with('reviewer_detail:id,first_name,last_name,email,image,user_type', 'user_detail:id,first_name,last_name,email,image,user_type');
            $sellerObj = $resourceObj->where('review_by', $userId)->get();
            $response['data'] = $sellerObj;
            $response['message'] = __("message.REVIEW_FETCH_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }

        return response()->json($response, $response['status']);
    }

    public function user_review(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $requestData = $request->all();
            $resourceObj = ReviewRating::where('user_id', $request->user()->id)->with('reviewer_detail:id,first_name,last_name', 'user_detail:id,first_name,last_name')->get();
            $response['data'] = $resourceObj;
            $response['message'] = __("message.REVIEW_FETCH_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }

    public function getReviewCar(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $requestData = $request->all();
            $carId = $requestData['car_id'];
            $resourceObj = ReviewRating::where('car_id', $carId)->with('buyerDetail');
            $response['data'] = $resourceObj->get();
            $response['message'] = __("message.REVIEW_FETCH_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }

    public function getReviewList(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $requestData = $request->all();
            $userId = $requestData['user_id'];

            $userObj = User::find($userId);
            if ($userObj->user_type == 'buyer') {
                $resourceObj = ReviewRating::where('user_id', $userId)->with('sellerDetail');
            }
            if ($userObj->user_type == 'seller') {
                $resourceObj = ReviewRating::where('user_id', $userId)->with('buyerDetail');
            }
            $response['data'] = $resourceObj->get();
            $response['message'] = __("message.REVIEW_FETCH_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }
}
