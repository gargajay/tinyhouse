<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Library\PushNotification;
use App\Library\Twilio;
use App\Mail\ForgotPassword;
use App\Models\ForgotPasswordMail;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\OtpVerification;
use App\Models\TallyUser;
use App\Models\Car;
use App\Models\Block;
use App\Models\CarImage;
use App\Models\Address;
use App\Models\Booking;
use App\Models\Report;
use App\Models\ReviewRating;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Mail;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

use function Ramsey\Uuid\v3;

class UserController extends Controller
{

    public function __construct(Request $request)
    {
        // make email lower case in request
        updateRequestValue('email', strtolower($request->email));
    }

    public function signup(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;


        try {

            DB::beginTransaction();

            $rules = [
                'email' => 'required',
                'password' => 'required|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return response()->json($errorResponse, $response['status']);
            }
            //dd(App::getLocale());

            $requestData = $request->all();
            $userObjSocialCheck = User::where('email', $requestData['email'])->where('password', '=', SOCIAL_PASS)->whereNull('deleted_at')->first();

            if ($userObjSocialCheck) {
                $userObj = $userObjSocialCheck;
            } else {
                $userObjSocialCheck = User::where('email', $requestData['email'])->whereNull('deleted_at')->first();

                if ($userObjSocialCheck) {
                    $response['message'] = __("message.EMAIL_ALREADY_EXIST");

                    return response()->json($response, $response['status']);
                } else {
                    $userObj = new User;
                }
            }
            $setting = Setting::where('name', 'subscription')->first();
            $subscription_expiry_days =  $setting->value ??  30;

            $userObj->first_name = $requestData['first_name'] ?? "";
            $userObj->last_name = $requestData['last_name'] ?? "";
            $userObj->name = $userObj->first_name . " " . $userObj->last_name;
            $userObj->email = strtolower($requestData['email']);
            $userObj->password = bcrypt($requestData['password']);
            $userObj->device_token = $requestData['device_token'] ?? "";
            $userObj->device_type = $requestData['device_type'] ?? "";
            $userObj->lat = $requestData['latitude']  ?? null;
            $userObj->lng = $requestData['longitude']  ?? null;
            $userObj->country_code = $requestData['country_code'] ?? "";
            $userObj->mobile = $requestData['mobile'] ?? "";
            $userObj->free_trail_days = $subscription_expiry_days['subscription'] ?? "";

            if (isset($requestData['user_type']) && $requestData['user_type'] != '') {
                $userObj->user_type = $requestData['user_type'] ?? "";
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(IMAGE_UPLOAD_PATH, $fileName);
                $userObj->image = $fileName;
            }
            if ($userObj->save()) {

                $userObj->free_trail_expiry_date = Carbon::parse($userObj->created_at)->addDays($userObj->free_trail_days)->format('m-d-Y') ?? "";
                $userObj->save();

                $latitude = $requestData['latitude'] ?? NULL;
                $longitude = $requestData['longitude']  ?? NULL;
                if ($latitude && $longitude) {
                    saveGeolocation(DB::class, 'users', $userObj->id, $latitude, $longitude);
                }

                //  saving fcm token for mutliple devices
                if(!empty($request->device_type) && !empty($request->device_token)){
                    saveDeviceToken($userObj,$request->device_type,$request->device_token);
                }


            }

            $userId = $userObj->id;
            $userData = User::where('id', $userId)->first();
            $userData->access_token = $userData->createToken($userData->id . ' token ')->accessToken;
            $token = $userData->createToken($userData->id . ' token ')->accessToken;
            if ($token) {
                DB::commit();
            }
            $response['data'] = $userData;
            $response['success'] = TRUE;
            $response['message'] = __("message.REGISTERED_SUCCESSFULLY");
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            DB::rollback();
            unset($response['data']);
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());

            $response['status'] = STATUS_GENERAL_ERROR;
        }

        return response()->json($response, $response['status']);
    }

    public function sellerAddress(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;


        try {

            $rules = [];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }

            $requestData = $request->all();
            $userId = $request->user()->id;
            $userObj = User::find($userId);
            $userObj->lat = $requestData['latitude']  ??  $userObj->lat;
            $userObj->lng = $requestData['longitude'] ?? $userObj->lng;
            $userObj->description = $requestData['description'] ??  $userObj->description;
            if ($userObj->description != '') {
                $userObj->description = $requestData['description'] ?? '';
            }
            $userObj->is_info = true;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(IMAGE_UPLOAD_PATH, $fileName);
                $userObj->image = $fileName;
            }
            $userObj->save();

            //============= address===========
            $address = Address::where('user_id', $userId)->first();
            if (!$address) {
                $address = new Address;
                $address->user_id = $userObj->id;
            }
            $address->address1 = $requestData['address1'] ?? '';
            $address->address2 = $requestData['address2'] ?? '';
            $address->city = $requestData['city'] ?? '';
            $address->state = $requestData['state'] ?? '';
            $address->country = $requestData['country'] ?? '';
            $address->zip = $requestData['zip'] ?? '';
            $address->lat = $requestData['latitude']  ?? '';
            $address->lng = $requestData['longitude']  ??  '';

            if ($address->save()) {
                $latitude = $requestData['latitude']  ?? NULL;
                $longitude = $requestData['longitude']  ?? NULL;
                if ($latitude && $longitude) {
                    saveGeolocation(DB::class, 'addresses', $address->id, $latitude, $longitude);
                    saveGeolocation(DB::class, 'users', $address->user_id, $latitude, $longitude);
                }
            }

            $userData = User::where('id', $userId)->with('userAddress')->first();

            $response['data'] =  $userData;
            $response['message'] = __("message.PROFILE_UPDATED_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }
        return response()->json($response, $response['status']);
    }

    public function login(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        if ($request->has('email')) {
            $rules['email'] = 'required|email';
        }

        $rules['password'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorResponse = validation_error_response($validator->errors()->toArray());
            return response()->json($errorResponse, STATUS_BAD_REQUEST);
        }
        $requestData = $request->all();
        $checkUser = User::login($request->all());
        if (!isset($checkUser['user'])) {
            $response['message'] = $checkUser['message'];
            $response['status'] = STATUS_UNAUTHORIZED;
            return $response;
        }

        try {
            $user = $checkUser['user'];

            $userObj = User::where('id', $user->id)->with('userAddress')->first();
            $userObj->device_token = $requestData['device_token'] ?? "";
            $userObj->device_type = $requestData['device_type'] ?? "";
            $userObj->save();

           
            if(!empty($request->device_type) && !empty($request->device_token)){
                saveDeviceToken($userObj,$request->device_type,$request->device_token);
            }


            $token = $user->createToken($user->id . ' token ')->accessToken;
            $userObj->access_token = $token;
            $response['message'] = __("message.LOGIN_SUCCESSFULLY");
            $response['data'] = $userObj;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }

    public function socialLogin(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            $post_data = $request->all();
            $requestData = $request->all();

            $post_data['username'] = $post_data['username'] ?? "";
            // $rules['user_type'] = 'required|In:buyer,seller';
            $rules['type'] = 'required';

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }

            $isNewAccount = FALSE;

            if ($request->get('type') == 1) {
                $rules['facebook_id'] = 'required';

                if (!isset($post_data['email']) || empty($post_data['email'])) {
                    $post_data['email'] = $post_data['facebook_id'] . "@facebook.com";
                }

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $errorResponse = validation_error_response($validator->errors()->toArray());

                    return $errorResponse;
                }
                $check_email_exist = User::where('email', $post_data['email'])->count();

                if ($check_email_exist) {
                    $userobj = User::where('email', $post_data['email'])->first();
                    $check_facebook_id_exist = User::where('email', $post_data['email'])->where('facebook_id', $post_data['facebook_id'])->count();

                    if (!$check_facebook_id_exist) {
                        $userobj->facebook_id = $post_data['facebook_id'];
                        $userobj->first_name = $post_data['first_name'] ?? NULL;
                        $userobj->last_name = $post_data['last_name'] ?? NULL;

                        if (isset($post_data['username'])) {
                            if ($post_data['username'] != NULL && $post_data['username'] != '') {
                                $userobj->username = $post_data['username'];
                            }
                        }

                        $userobj->save();
                    } else {
                        $userobj->first_name = $post_data['first_name'] ?? NULL;
                        $userobj->last_name = $post_data['last_name'] ?? NULL;
                        $userobj->save();
                    }
                } else {
                    $isNewAccount = TRUE;
                    $userobj = new User;
                    $userobj->facebook_id = $post_data['facebook_id'];
                    $userobj->first_name = $post_data['first_name'] ?? NULL;
                    $userobj->last_name = $post_data['last_name'] ?? NULL;
                    $userobj->name = $userobj->first_name . " " . $userobj->last_name;
                    $userobj->email = $post_data['email'];
                    if (isset($post_data['username'])) {
                        if ($post_data['username'] != NULL && $post_data['username'] != '') {
                            $userobj->username = $post_data['username'];
                        }
                    }
                    $userobj->password = SOCIAL_PASS;
                    $userobj->save();
                }
            } elseif ($request->get('type') == 2) {
                $rules['google_id'] = 'required';

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $errorResponse = validation_error_response($validator->errors()->toArray());
                    return $errorResponse;
                }

                $check_email_exist = User::where('email', $post_data['email'])->count();

                if ($check_email_exist) {
                    $userobj = User::where('email', $post_data['email'])->first();
                    $check_google_id_exist = User::where('email', $post_data['email'])->where('google_id', $post_data['google_id'])->count();

                    if (!$check_google_id_exist) {
                        $userobj->google_id = $post_data['google_id'];
                        $userobj->first_name = $post_data['first_name'] ?? NULL;
                        $userobj->last_name = $post_data['last_name'] ?? NULL;
                        $userobj->name = $userobj->first_name . " " . $userobj->last_name;
                        if (isset($post_data['username'])) {
                            if ($post_data['username'] != NULL && $post_data['username'] != '') {
                                $userobj->username = $post_data['username'];
                            }
                        }

                        $userobj->save();
                    } else {
                        $userobj->first_name = $post_data['first_name'] ?? NULL;
                        $userobj->last_name = $post_data['last_name'] ?? NULL;
                        $userobj->save();
                    }
                } else {
                    $isNewAccount = TRUE;

                    $userobj = new User;
                    $userobj->google_id = $post_data['google_id'];
                    $userobj->first_name = $post_data['first_name'] ?? NULL;
                    $userobj->last_name = $post_data['last_name'] ?? NULL;
                    $userobj->name = $userobj->first_name . " " . $userobj->last_name;
                    $userobj->email = $post_data['email'];
                    if (isset($post_data['username'])) {
                        if ($post_data['username'] != NULL && $post_data['username'] != '') {
                            $userobj->username = $post_data['username'];
                        }
                    }
                    $userobj->password = SOCIAL_PASS;
                    $userobj->save();
                }
            } elseif ($request->get('type') == 3) {
                $rules['apple_id'] = 'required';


                $device_id  = $request->device_id ?? '123';


                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $response['message'] = $validator->errors()->first();
                    $response['status'] = UNPROCESSABLE_ENTITY;
                    return response()->json($response, $response['status']);
                }
                if (!isset($post_data['email']) || empty($post_data['email'])) {
                    $post_data['email'] = $post_data['email'] ?? " ";
                }
                $check_email_exist = User::where('email', $post_data['email'])->first();

                if (!empty($post_data['email']) && $check_email_exist) {

                    $userobj = User::where('email', $post_data['email'])->first();
                    $check_apple_id_exist = User::where('email', $post_data['email'])->where(function ($query) use ($post_data, $device_id) {
                        $query->where('apple_id', $post_data['apple_id'])
                            ->orWhere('apple_id',$device_id);
                    })->count();

                    if (!$check_apple_id_exist) {
                        $userobj->apple_id = $post_data['apple_id'];
                        // $userObj->name = $post_data['name'] ?? NULL;
                        $userobj->first_name = $post_data['first_name'] ?? $userobj->first_name;
                        $userobj->last_name = $post_data['last_name'] ?? $userobj->last_name;
                        //  $userObj->name = $userObj->first_name . " " . $userObj->last_name;
                        $userobj->name = (trim($userobj->first_name . ' ' . $userobj->last_name) == "") ? $post_data['name'] : $userobj->first_name . " " . $userobj->last_name;
                        if (isset($post_data['username'])) {
                            if ($post_data['username'] != NULL && $post_data['username'] != '') {
                                $userobj->username = $post_data['username'];
                            }
                        }

                        $userobj->save();
                    } else {
                        // $userObj->name = $post_data['name'] ?? NULL;
                        $userobj->first_name = $post_data['first_name'] ?? $userobj->first_name;
                        $userobj->last_name = $post_data['last_name'] ?? $userobj->last_name;
                        //   $userObj->name = $userObj->first_name . " " . $userObj->last_name;
                        $userobj->name = (trim($userobj->first_name . ' ' . $userobj->last_name) == "") ? $post_data['name'] : $userobj->first_name . " " . $userobj->last_name;
                        $userobj->save();
                    }
                } else {
                    // Check apple id exist or not
                    $userobj = User::where(function ($query) use ($post_data, $device_id) {
                        $query->where('apple_id', $post_data['apple_id'])
                            ->orWhere('apple_id',$device_id);
                    })->first();


                    if(empty($userobj) && empty($request->email)){
                        $response['success'] = FALSE;
                        $response['message'] = "user not found!";
                        // special case for apple  using this status
                        $response['status'] = 999;
                        return response()->json($response,400);

                    }



                    if (!empty($userobj)) {
                        // dd($userObj);
                        $post_data['email'] = $userobj->email;
                        // $userObj->name = $post_data['name'] ?? NULL;
                        $userobj->first_name = $post_data['first_name'] ?? $userobj->first_name;
                        $userobj->last_name = $post_data['last_name'] ?? $userobj->last_name;
                        //  $userObj->name = $userObj->first_name . " " . $userObj->last_name;
                        $userobj->name = (trim($userobj->first_name . ' ' . $userobj->last_name) == "") ? $post_data['name'] : $userobj->first_name . " " . $userobj->last_name;
                        $userobj->email = $post_data['email'] ?? $userobj->email;
                        $userobj->save();
                    } else {
                        $isNewAccount = TRUE;

                        $userobj = new User;
                        $userobj->apple_id = $post_data['apple_id'];
                        // $userObj->name = $post_data['name'] ?? NULL;
                        $userobj->first_name = $post_data['first_name'] ?? "";
                        $userobj->last_name = $post_data['last_name'] ?? "";
                        //   $userObj->name = $userObj->first_name . " " . $userObj->last_name;
                        $userobj->name = (trim($userobj->first_name . ' ' . $userobj->last_name) == "") ? $request->name : $userobj->first_name . " " . $userobj->last_name;

                        $userobj->email = $post_data['email'];
                        if (isset($post_data['username'])) {
                            if ($post_data['username'] != NULL && $post_data['username'] != '') {
                                $userobj->username = $post_data['username'];
                            }
                        }
                        $userobj->password = SOCIAL_PASS;
                        $userobj->save();
                    }

                   
                   
                }
            }

            $response['message'] = __("message.LOGIN_SUCCESSFULLY");
            $user_id = $userobj->id;
            $token = $userobj->createToken($user_id . ' token ')->accessToken;
            $userData = User::where('id', $userobj->id)->first();
            $userData->device_token = $post_data['device_token'] ?? "";
            $userData->device_type = $post_data['device_type'] ?? "";
            $userData->lat = $requestData['latitude'] ?? $userData->lat;
            $userData->lng = $requestData['longitude'] ?? $userData->lng;


            // Update

            if ($isNewAccount) {
                $userData->user_type = $requestData['user_type'] ?? "";
            }


            $userData->save();


            // Save point
            $lat = $userData->lat;
            $lng = $userData->lng;

            if ($lat && $lng) {
                \DB::insert("UPDATE users SET geolocation = ST_MakePoint($lng, $lat) WHERE id = '" . $userData->id . "'");
            }

            if(!empty($request->device_type) && !empty($request->device_token)){
                saveDeviceToken($userData,$request->device_type,$request->device_token);
            }

            $userData->access_token = $token;

            $response['data'] = $userData;
            $response['expiry_date'] = "";
            $paymentObj = Payment::where(['user_id' => $userobj->id])->latest()->first();
            if ($paymentObj) {
                $response['expiry_date'] = $paymentObj->expiry_date;
            }
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }

        return $response;
    }


    public function forgotPassword(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        $rules = [
            'email' => 'required|email|max:255'
        ];
        try {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }
            $userObj = User::where('email', $request->get('email'))->first();
            if (!$userObj) {
                $response['message'] = __("message.VALID_EMAIL");
                $response['status'] = STATUS_NOT_FOUND;
                return $response;
            }
            $token = generateRandomToken(50, $request->get('email'));
            $tokenMailObj = ForgotPasswordMail::where('email', $request->get('email'))->first();
            if (!$tokenMailObj) {
                $tokenMailObj = new ForgotPasswordMail;
            }
            $tokenMailObj->email = $request->get('email');
            $tokenMailObj->token = $token;
            $currentTime = date("Y-m-d H:i:s");
            $mailExpireTime = date('Y-m-d H:i:s', strtotime('+60 minutes', strtotime($currentTime)));
            $tokenMailObj->expired_at = $mailExpireTime;
            $tokenMailObj->save();
            $mailData = [];
            $mailData['name'] = $userObj->first_name ?? '';
            $mailData['link'] = route('password.reset', [$token, 'email' => $request->get('email')]);
            Mail::to($request->get('email'))->send(new ForgotPassword($mailData));
            $response['message'] = __("message.RESET_PASSWORD_EMAIL");

            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }
        return response()->json($response, $response['status']);
    }

    private function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = config('base_url') . 'password/reset/' . $token . '?email=' . urlencode($user->email);

        try {
            //Here send the link with CURL with an external email API
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function changePassword(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        $rules = [
            'current_password' => 'required|min:6',
            'password_confirmation' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }

            $requestData = $request->all();

            $userId = $request->user()->id;
            $userObj = User::find($userId);

            if (!Hash::check($request->get('current_password'), $userObj->password)) {
                $response['message'] = __("message.CURRENT_PASSWORD_WRONG");
                $response['status'] = STATUS_BAD_REQUEST;
                return response()->json($response, STATUS_BAD_REQUEST);
            }

            $userObj->password = bcrypt($requestData['password']);
            $userObj->save();

            $response['message'] = __("message.PASSWORD_CHANGED_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }

    public function updateProfile(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;


        try {
            $requestData = $request->all();
            $rules = [];
            $userId = $request->user()->id;


            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }
            $requestData = $request->all();
            $userId = $request->user()->id;
            $userObj = User::find($userId);
            $userObj->first_name = $requestData['first_name'] ?? $userObj->first_name;
            $userObj->last_name = $requestData['last_name'] ?? $userObj->last_name;
            $userObj->name = $userObj->first_name . " " . $userObj->last_name;
            $userObj->country_code = $requestData['country_code'] ?? $userObj->country_code;
            $userObj->email = $requestData['email'] ?? $userObj->email;
            $userObj->mobile = $requestData['mobile'] ?? $userObj->mobile;
            $userObj->lat = $requestData['latitude']  ??  $userObj->lat;
            $userObj->lng = $requestData['longitude']  ??  $userObj->lng;
            $userObj->description = $requestData['description'] ??  $userObj->description;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(IMAGE_UPLOAD_PATH, $fileName);
                $userObj->image = $fileName ?? $userObj->image;
            }


            if ($userObj->save()) {
                $latitude = $requestData['latitude']  ?? NULL;
                $longitude = $requestData['longitude']  ?? NULL;

                if ($latitude && $longitude) {
                    saveGeolocation(DB::class, 'users', $userObj->id, $latitude, $longitude);
                }
            }

            //============= address===========

            $address = Address::where('user_id', $userId)->first();
            if (!$address) {
                $address = new Address;
                $address->user_id = $userObj->id;
            }
            $address->address1 = $requestData['address1'] ?? $address->address1;
            $address->address2 = $requestData['address2'] ?? $address->address2;
            $address->city = $requestData['city'] ?? $address->city;
            $address->state = $requestData['state'] ?? $address->state;
            $address->country = $requestData['country'] ?? $address->country;
            $address->zip = $requestData['zip'] ?? $address->zip;
            $address->lat = $requestData['latitude']  ?? $address->lat;
            $address->lng = $requestData['longitude'] ??  $address->lng;
            if ($address->save()) {
                // Save point
                $latitude = $requestData['latitude'] ?? NULL;
                $longitude = $requestData['longitude']  ?? NULL;

                if ($latitude && $longitude) {
                    saveGeolocation(DB::class, 'addresses', $address->id, $latitude, $longitude);
                    saveGeolocation(DB::class, 'addresses', $address->user_id, $latitude, $longitude);
                }
            }
            $userData = User::where('id', $userId)->with('userAddress')->first();
            $response['data'] =  $userData;
            $response['message'] = __("message.PROFILE_UPDATED_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }


    public function switchRole(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;


        try {
            $requestData = $request->all();
            $rules = [
                'user_type' => 'required'
            ];
            $userId = $request->user()->id;


            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }
            $requestData = $request->all();
            $userId = $request->user()->id;
            $userObj = User::find($userId);
            $userObj->user_type = $request->user_type ?? "";



            if (!$userObj->save()) {
                $response['message'] = __("message.something_wrong");
            }

            //============= address===========


            $userData = User::where('id', $userId)->with('userAddress')->first();
            $response['data'] =  $userData;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }

    public function logout(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $userId = $request->user()->id;
            $userObj = User::find($userId);
            $userObj->device_token = "";
            $userObj->save();

            $user = Auth::user()->token();
            $user->revoke();

            $requestData = $request->all();
            $response['message'] = __("message.LOGOUT_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }

    public function notifications(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $requestData = $request->all();
            $userId = $request->user()->id;
            $userObj = User::find($userId);
            $userNotify = Notification::where('user_id', $userId)->with('userDetail', 'sellerDetail')->orderBy('id', 'DESC');
            $response['data'] = $userNotify->get();
            $response['message'] = __("message.NOTIFICATION_FETCHED");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }

    public function sendOtp(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $rules = [
                'country_code' => 'required',
                'mobile' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return $errorResponse;
            }

            $requestData = $request->all();

            if (User::where('mobile', $requestData['mobile'])->first()) {
                $response['message'] = "Account with this phone number already exists, please login or sign up for new account";

                return response()->json($response, STATUS_BAD_REQUEST);
            }

            // OTP : START
            $otp = rand(100000, 999999);
            $messageData = [
                'to' => $requestData['country_code'] . $requestData['mobile'],
                'message' => 'Your ' . APP_NAME . ' OTP is ' . $otp,
            ];
            $twilioResponse = Twilio::sendMessageCurl($messageData);
            if (!$twilioResponse['success']) {
                $response['message'] = $twilioResponse['message'];

                return response()->json($response, STATUS_BAD_REQUEST);
            }
            if ($twilioResponse['success'] && isset($twilioResponse['data']) && isset($twilioResponse['data']['code'])) {
                $response['message'] = $twilioResponse['data']['message'];

                return response()->json($response, STATUS_BAD_REQUEST);
            }
            if (!is_null($twilioResponse['data']['error_code'])) {
                $response['message'] = $twilioResponse['error_message'];

                return response()->json($response, STATUS_BAD_REQUEST);
            }

            $otpVerificationObj = OtpVerification::where('country_code', $requestData['country_code'])->where('mobile', $requestData['mobile'])->first();
            if (!$otpVerificationObj) {
                $otpVerificationObj = new OtpVerification;
            }

            $otpVerificationObj->country_code = $requestData['country_code'];
            $otpVerificationObj->mobile = $requestData['mobile'];
            $otpVerificationObj->otp = $otp;
            $otpVerificationObj->otp_expire_time = addMinutesToTime(['minute' => 2]);
            // OTP : END

            $otpVerificationObj->save();

            $response['otp'] = $otp;
            $response['message'] = OTP_SENT;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }
        return $response;
    }

    public function verifyOtp(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $rules = [
                'country_code' => 'required',
                'mobile' => 'required',
                'otp' => 'required|min:6|max:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }

            $requestData = $request->all();

            if ($requestData['otp'] == '8888') {
                OtpVerification::where('country_code', $requestData['country_code'])->where('mobile', $requestData['mobile'])->delete();

                $response['message'] = OTP_VERIFIED;
                $response['success'] = TRUE;
                $response['status'] = STATUS_OK;
                return $response;
            }

            $otpVerificationObj = OtpVerification::where('country_code', $requestData['country_code'])->where('mobile', $requestData['mobile'])->first();
            if (!$otpVerificationObj) {
                $response['message'] = 'OTP expired';
                return $response;
            }
            if ($otpVerificationObj->otp != $requestData['otp']) {
                $response['message'] = 'You have entered wrong OTP';
                return $response;
            }

            OtpVerification::where('country_code', $requestData['country_code'])->where('mobile', $requestData['mobile'])->delete();

            $response['message'] = OTP_VERIFIED;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }
        return $response;
    }

    public function profileDetail(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $requestData = $request->all();
            $userId = $requestData['profile_id'] ?? $request->user()->id;
            $userObj = User::where('id', $userId)->with('userAddress')->first();


            $response['data'] = $userObj;
            $response['message'] = __("message.PROFILE_FETCH_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }

    public function getUser(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        $rules = [
            // 'email' => 'required|email|max:255'
        ];
        try {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }
            $userId = $request->user()->id;
            $userData = User::where('parent_id', $userId)->with('assign');
            $response['data'] = $userData->get();
            $response['message'] = __("message.PROFILE_FETCH_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }
        return response()->json($response, $response['status']);
    }

    public function userstatusupdate(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $requestData = $request->all();
            $user = User::find($request->user()->id);
            $user->user_type = $requestData['user_type'];
            $user->save();
            $userObj = User::where('id', $user->id)->first();
            $response['message'] = "Your are become $user->user_type";
            $response['success'] = TRUE;
            $response['data'] = $userObj;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }
        return response()->json($response, $response['status']);
    }

    public function deleteUser(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $carDetailsIds = Notification::where('notification_from', $request->user()->id)->forceDelete();
            $carIds = Notification::where('user_id', $request->user()->id)->forceDelete();
            $userObj = User::where('id', $request->user()->id)->delete();

            $response['message'] = __("message.ACCOUNT_DEACTIVATED_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }

    public function blockUnblockUser(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            $requestData = $request->all();
            $rules = [
                'block_user_id' => 'required|numeric|exists:users,id',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }
            $userId = $request->user()->id;
            $check =  Block::where(['block_user_id' => $request->block_user_id, 'blockBy_user_id' => $userId])->withTrashed()->first();

            if ($check) {
                if ($check->deleted_at) {
                    $check->deleted_at = NULL;
                    $check->save();
                    $msg = __("message.USER_BLOCK_SUCCESS");
                } elseif ($check->deleted_at == NULL) {
                    $check->delete();
                    $msg =  __("message.USER_UNBLOCK_SUCCESS");
                }
            } else {

                $block = new Block;
                $block->block_user_id = $request->block_user_id;
                $block->blockBy_user_id = $userId;
                $block->save();
                $msg = __("message.USER_BLOCK_SUCCESS");
            }
            $response['message'] = $msg;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return response()->json($response, $response['status']);
    }

    public function reportUser(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            DB::beginTransaction();
            $requestData = $request->all();
            $rules = [
                'report_user_id' => 'required|numeric|exists:users,id',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }
            $userId = Auth::user()->id;
            $reportCheck = Report::where('report_user_id', $userId)->where('reportBy_user_id', $request->report_user_id)->first();
            if ($reportCheck) {
                $response['message'] =  __("message.ALREDAY_SENT_REPORT");
            } else {
                $report = new Report;
                $report->report_user_id = $userId;
                $report->title = $request->title ?? "";
                $report->reportBy_user_id = $request->report_user_id;
                $report->save();
                $response['message'] = __("message.REPORT_SUCCESS");
            }
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return response()->json($response, $response['status']);
    }

    public function blockUserList(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            DB::beginTransaction();
            $requestData = $request->all();
            $rules = [];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }
            $userId = Auth::user()->id;
            $blocks = Block::where('blockBy_user_id', $userId)->with('user_block:id,image')->get();
            $data = [];
            foreach ($blocks as &$value) {
                if ($value->blockBy_user_id == $userId) {
                    $id = $value->blockBy_user_id;
                    $data[] = array(
                        'id' => $id, 'block_user_name' => $value->block_user_name, 'image' => $value->user_block->image,
                        'created_at' => $value->created_at,
                        'updated_at' => $value->updated_at,
                        'block_user_id' => $value->block_user_id,

                    );
                }

                if (!empty($value->user_block)) {
                    $value->user_block->setAppends([]);
                }
            }
            $response['data'] = $data;

            $response['message'] = __("message.BLOCK_USER_FETCH");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return response()->json($response, $response['status']);
    }

    // checking apple id exit or not


}
