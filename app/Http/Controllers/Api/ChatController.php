<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use App\Library\PushNotification;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $redis = Redis::connection();
        $data = ['message' => $request->get('message'), 'user' => $request->get('user')];
        $redis->publish('message', json_encode($data));
        return response()->json([]);
    }

    public function chatList(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $userId = $request->user()->id;
            $chatObj = Chat::where('sender_id', $userId)
                ->orWhere('receiver_id', $userId)
                ->with('sender_detail', 'receiver_detail','cars_images')
                ->with(['last_message' => function ($query) {
                    $query->latest();
                }])
                ->with('last_message.sent_by_detail')
                ->orderBy('updated_at', 'DESC')
                ->get();

            if (count($chatObj) > 0) {
                $response['data'] = $chatObj->append('unseen_message_count');
            } else {
                $response['data'] = $chatObj;
            }

            $response['message'] = __("message.CHAT_FETCH_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response = [
                'message' => $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile()
            ];
            Log::error($e->getTraceAsString());
            $response['status'] = "STATUS_GENERAL_ERROR";
        }
        return $response;
    }

    public function chatDetail(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $requestData = $request->all();

            $rules = [
                'user_id' => 'required',
                'car_id' => 'required',
            ];

            if (isset($requestData['type']) && $requestData['type'] == "text") {
                $rules['message'] = "";
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }

            $loggedInUserId = $request->user()->id;
            $userId = $requestData['user_id'];

            if (isset($requestData['chat_id']) && !empty($requestData['chat_id'])) {
                $response['data'] = Message::latest()->where('chat_id', $requestData['chat_id'])->with('sent_by_detail')->get();
            } else {
                $chatObj = Chat::where(['sender_id' => $loggedInUserId, 'receiver_id' => $userId, 'car_id' => $requestData['car_id']])->first();

                if (!$chatObj) {
                    $chatObj = Chat::where(['sender_id' => $userId, 'receiver_id' => $loggedInUserId, 'car_id' => $requestData['car_id']])->first();
                }

                if (!$chatObj) {
                    $response['logged_in_user_id'] = $request->user()->id;
                    $response['request_data'] = $request->all();
                    $response['message'] = __("message.INVAILED_REQUEST");
                    return $response;
                }

                // Update message status to seen while opening the chat
                Message::where('chat_id', $chatObj->id)->where('sent_by', '!=', $loggedInUserId)->update(['is_seen' => '1']);

                $response['data'] = Message::latest()->where('chat_id', $chatObj->id)->with('sent_by_detail')->get();
            }

            $response['message'] = __("message.CHAT_FETCH_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response = [
                'message' => $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile()
            ];
            Log::error($e->getTraceAsString());
            $response['status'] = "STATUS_GENERAL_ERROR";
        }
        return $response;
    }

    public function saveMessage(Request $request)
    {

        $response = [];
        $response['success'] = FALSE;

        DB::beginTransaction();
        try {
            $requestData = $request->all();

            $rules = [
                'sender_id' => 'required',
                'receiver_id' => 'required',
                'car_id' => 'required',
                'type' => 'required',
            ];

            if (isset($requestData['type']) && $requestData['type'] == "text") {
                $rules['message'] = "";
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }
            //Check chat exist or not
            $chatObj = Chat::where([
                'sender_id' => $requestData['sender_id'],
                'receiver_id' => $requestData['receiver_id']
            ])
                ->orWhere([
                    'sender_id' => $requestData['receiver_id'],
                    'receiver_id' => $requestData['sender_id']
                ])->first();

            if ($chatObj = Chat::where(['sender_id' => $requestData['sender_id'], 'receiver_id' => $requestData['receiver_id'], 'car_id' => $requestData['car_id']])->first()) {
            } elseif ($chatObj = Chat::where(['sender_id' => $requestData['receiver_id'], 'receiver_id' => $requestData['sender_id'], 'car_id' => $requestData['car_id']])->first()) {
            } else {


                $chatObj = new Chat;
                $chatObj->sender_id = $requestData['sender_id'];
                $chatObj->receiver_id = $requestData['receiver_id'];
                $chatObj->car_id = $requestData['car_id'];
            }
            $chatObj->car_id = $requestData['car_id'] ?? NULL;
            $chatObj->updated_at = Carbon::now();
            $chatObj->save();

            $messageObj = new Message;
            $messageObj->chat_id = $chatObj->id;
            $messageObj->sent_by = $requestData['sender_id'];
            $messageObj->message = $requestData['message'] ?? "";
            $messageObj->type = $requestData['type'] ?? 'text';



            if (isset($requestData['type']) && $requestData['type'] == "file") {
                $fileInfo = base64_to_image($requestData['file']);

                $messageObj->file_type = 'image';
                $messageObj->file_extension = $fileInfo['file_type'] ?? "";
                $messageObj->file = $fileInfo['file_name'] ?? "";
            }

            if ($messageObj->save()) {

              
            }
                            // 'badge' => Notification::where(['user_id' => $requestData['receiver_id'], 'is_seen' => 0])->count(),




            DB::commit();
            $likedata = User::Find($requestData['sender_id']);
            $data = User::Find($requestData['receiver_id']);

            $notificationType = 'TYPE_MESSAGE';
            $notificationMsg = $likedata->name . '  ' . __("message.SEND_MESSAGE");
            $notificationObj = new Notification;
            $notificationObj->user_id = $requestData['receiver_id'];
            $notificationObj->notification_from = $requestData['sender_id'];
            $notificationObj->car_id =   $chatObj->car_id;
            $notificationObj->message = $notificationMsg;
            $notificationObj->type = $notificationType;

            if ($notificationObj->save()) {

            $notificationData = [
                'title' => $likedata->name . '  ' . __("message.SEND_MESSAGE"),
                'message' => $requestData['message'],
                'user_id' => $data->id,
                'chatInfo' => $chatObj,
                'badge' => Notification::where(['user_id' => $requestData['receiver_id'], 'is_seen' => 0])->count(),
                'send_by' => $requestData['sender_id'],
                'type' => 10,
            ];
            PushNotification::send($notificationData);

        }

            $response['message'] = __("message.MESSAGE_SENT_SUCCESSFULLY");

            $chatId = $chatObj->id;

            $chatData = Chat::where('id', $chatId)->with('sender_detail')->with(['last_message' => function ($query) {
                $query->latest()->first();
            }])->with('last_message.sent_by_detail')->first();

            if ($chatData) {
                $chatData->append('unseen_message_count');
            }

            //$chatData = $messageObj;

            $response['data'] = $chatData;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            DB::rollBack();
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = FALSE;
        }
        return $response;
    }

    public function seenAllMessage(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $requestData = $request->all();

            $userId = $request->user_id;


            $messages =    Notification::where(['user_id' => $request->user_id])->get();
           


            if(!$messages->isEmpty()){
                foreach ($messages as $message){

                    Notification::where('id', $message->id)->update([
                        'is_seen' => '1'
                    ]);
                    
                }
            }

            

            $response['message'] = __("message.MESSAGE_SEEN_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = FALSE;
        }
        return $response;
    }


    public function seenMessage(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $requestData = $request->all();

            $messageId = $requestData['message_id'] ?? 0;

            Message::where('id', $messageId)->update([
                'is_seen' => '1'
            ]);

            $response['message'] = __("message.MESSAGE_SEEN_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = FALSE;
        }
        return $response;
    }

    
}
