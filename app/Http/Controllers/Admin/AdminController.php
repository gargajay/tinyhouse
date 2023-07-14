<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ModelImport;
use App\Mail\ForgotPassword;
use App\Models\Category;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\ForgotPasswordMail;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ModelExport;
use App\Imports\CarmakeImport;
use App\Imports\CarmodelImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct(Request $request)
    {
        // make email lower case in request
        updateRequestValue('email', strtolower($request->email));
    }

    public function login(Request $request)
    {
        $data = [];

        if ($request->isMethod('post')) {

            $checkUser = User::webLogin($request->all());

            if (!isset($checkUser['user'])) {
                $message = $checkUser['message'];

                return redirect()->route('login')->with('error', $message);
            }

            if ($checkUser['user']['user_type'] != 'admin') {
                return redirect()->route('login')->with('error', "Invalid credentials");
            }

            return redirect()->route('dashboard');
        }

        return view('admin.login')->with(compact('data'));
    }

    public function dashboard(Request $request, $edit_id = NULL)
    {
        $data['action_url'] = '';
        $data['page_title'] = "Dashboard";
        $data['buyer_count'] = User::where('user_type','!=', "admin")->withTrashed()->count();
        // Users monthly data : STARTs
        $monthlyBuyerData = [];
        $monthlyBuyerData = lastOneYearMontlyData(User::where('user_type','!=', "admin"));
      
        $data['seller_count'] = User::whereIn('id', function($query) {
            $query->select('user_id')
                  ->from('cars');
        })->count();
        // Users monthly data : STARTs
        $monthlySellerData = [];
        $monthlySellerData =  lastOneYearMontlyData(User::whereIn('id', function($query) {
            $query->select('user_id')
                  ->from('cars');
        }));

        $data['car_count'] = Car::count();
        // Users monthly data : STARTs
        // $monthlyCarData = [];
        $monthlyCarData =  lastOneYearMontlyData(new Car());
        return view('admin.dashboard', compact('data', 'monthlyBuyerData', 'monthlySellerData', 'monthlyCarData'));
    }

    public function changePasswordAdmin(Request $request)
    {
        $rules = [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return redirect()->back()->with('error', $errorResponse['message']);
            }

            $user = Auth::user();

            if (Hash::check($request->old_password, $user->password)) {
                $user->fill([
                    'password' => Hash::make($request->password)
                ])->save();

                $request->session()->flash('success', 'Password changed successfully');
                return redirect()->back();
            } else {
                $request->session()->flash('error', 'Wrong old password');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function forgotPassword()
    {
        $data = [];
        //
        return view('admin.forgot-password')->with(compact('data'));
    }

    public function sendForgotPasswordMail(Request $request)
    {
        $email = mb_strtolower($request->get('email'), 'UTF-8') ?? "";

        $userObj = User::where(['email' => $email , 'user_type' => 'admin'])->first();
        if (!$userObj) {
            return redirect()->route('forgot.password')->with('error', 'Please enter valid registered email.');
        }
        if($userObj->user_type!='admin'){
            return redirect()->route('forgot.password')->with('error', 'This account is not associated with admin');
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
        if ($userObj) {
            $mailData['name'] = $userObj->name;
        } else {
            $mailData['username'] = $userObj->username;
        }

        $mailData['link'] = route('password.reset', [$token, 'email' => $request->get('email')]);

        Mail::to($request->get('email'))->send(new ForgotPassword($mailData));

        return redirect()->route('/')->with('success', 'Please check your email to reset password');
    }

    public function getUsers(Request $request, $edit_id = NULL)
    {
        $data['action_url'] = '';
        $data['page_title'] = "Users";

        $userObj = User::where('is_admin', '=', '0')->orderBy('created_at', 'DESC');

        $data['data'] = $userObj->paginate(10);

        return view('admin.user.list')->with(compact('data'));
    }

    public function userDetail(Request $request, $id = NULL)
    {
        $data['action_url'] = '';
        $data['page_title'] = "Users";

        $userObj = User::where('id', $id)
            ->with('children')
            ->first()->toArray();

        $data['data'] = $userObj;

        return view('admin.user.detail')->with(compact('data'));
    }

    public function getUserById(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $rules = [
                'resource_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }

            $requestData = $request->all();

            $userObj = User::with('bank_detail')->find($requestData['resource_id']);
            if (!$userObj) {
                $response['message'] = 'Invalid user id';
                return response()->json($response, STATUS_BAD_REQUEST);
            }

            $response['data'] = $userObj;

            $response['message'] = 'User detail fetched successfully';
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        if ($response['success']) {
            return response()->json($response, STATUS_OK);
        }
        return response()->json($response, STATUS_BAD_REQUEST);
    }

    public function updateProfile(Request $request)
    {
        try {
            $requestData = $request->all();
            $userObj = User::find($request->user()->id);
            $userObj->name = $requestData['username'] ?? $userObj->name;
            $userObj->email = $requestData['email'] ?? $userObj->email;

            if ($request->hasFile('image')) {
                $rules['image'] = 'required|mimes:jpeg,jpg,png|max:5000';
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $errorResponse = validation_error_response($validator->errors()->toArray());
                    return redirect()->back()->withInput()->with('error', $errorResponse['message']);
                }

                $file = $request->file('image');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(IMAGE_UPLOAD_PATH, $fileName);
                $userObj->image = $fileName;
            }
            $userObj->save();

            return redirect()->route('settings')->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function updateUserStatus(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $rules = [
                'resource_id' => 'required',
                'status' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }

            $requestData = $request->all();

            $userObj = User::find($requestData['resource_id']);
            if (!$userObj) {
                $response['message'] = 'Invalid user id';
                return response()->json($response, STATUS_BAD_REQUEST);
            }

            $userObj->status = $requestData['status'];
            $userObj->save();

            $response['message'] = 'User status updated successfully';
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        if ($response['success']) {
            return response()->json($response, STATUS_OK);
        }
        return response()->json($response, STATUS_BAD_REQUEST);
    }
    //
    public function checkEmailExist(Request $request)
    {
        $response = [];
        $response['success'] = TRUE;

        $rules = [
            'email' => 'required|email|unique:users',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorResponse = validation_error_response($validator->errors()->toArray());
            $response['message'] = $errorResponse['message'];
            $response['success'] = FALSE;
        }
        return $response;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function settings(Request $request)
    {
        error_log(print_r($request->all(), true));

        if ($request->isMethod('GET')) {
            error_log(print_r($request->all(), true));
            $data = [];
            $data['page_title'] = 'Settings';
            $settingObj = Setting::first();
            $settings = $settingObj['settings'] ?? [];

            $smtpSetting = Setting::where('name', 'smtp')->first();
            $smtp = $smtpSetting->value ?? [];

            $appSetting = Setting::where('name', 'app')->first();
            $app = $appSetting->value ?? [];

            $push_notification_server_key_setting = Setting::where('name', 'push_notification_server_key')->first();
            $push_notification_server_key = $push_notification_server_key_setting->value ?? [];

            $stripeSetting = Setting::where('name', 'stripe')->first();
            $stripe = $stripeSetting->value ?? [];

            $distanceSetting = Setting::where('name', 'search_distance_limit')->first();
            $distance = $distanceSetting->value ?? [];

            $subscriptionSetting = Setting::where('name', 'subscription')->first();
            $subscription = $subscriptionSetting->value ?? [];

            $debug_mode_setting = Setting::where('name', 'debug_mode')->first();
            $debug_mode = $debug_mode_setting->value ?? [];

            return view('admin.setting')->with(compact('data', 'settings', 'smtp', 'push_notification_server_key', 'app', 'stripe', 'distance', 'subscription', 'debug_mode'));
        }

        try {
            $requestData = $request->all();

            $rules = [];
            $settingData = [];

            if ($requestData['request_type'] == 'change_password') {
                $rules['old_password'] = 'required|min:6';
                $rules['password'] = 'required|min:6|confirmed';

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $errorResponse = validation_error_response($validator->errors()->toArray());
                    return redirect()->back()->with('error', $errorResponse['message']);
                }

                $user = Auth::user();

                if (Hash::check($request->old_password, $user->password)) {
                    $user->fill([
                        'password' => Hash::make($request->password)
                    ])->save();

                    $request->session()->flash('success', 'Password changed successfully');
                    return redirect()->back();
                } else {
                    $request->session()->flash('error', 'Wrong old password');
                    return redirect()->back();
                }
            }

            if ($requestData['request_type'] == 'smtp') {
                $smtp = [
                    'email' => $requestData['smtp_email'],
                    'password' => $requestData['smtp_password'],
                    'host' => $requestData['smtp_host'] ?? "",
                    'port' => $requestData['smtp_port'] ?? "",
                    'from_address' => $requestData['smtp_from_address'],
                    'from_name' => $requestData['smtp_from_name'],
                ];

                $jsonData = json_encode($smtp);

                $settingObj = Setting::where('name', 'smtp')->first();

                if (!$settingObj) {
                    $settingObj = new Setting;
                    $settingObj->name = 'smtp';
                    $settingObj->description = 'SMTP setting is using to setup the mail configuration';
                }

                $settingObj->value = $jsonData;
                $settingObj->save();

                $request->session()->flash('success', 'SMTP setting updated successfully');
                return redirect()->back();
            }

            if ($requestData['request_type'] == 'push_notification_server_key') {
                $push_notification_server_key = [
                    'push_notification_server_key' => $requestData['push_notification_server_key'] ?? NULL
                ];

                $jsonData = json_encode($push_notification_server_key);

                $settingObj = Setting::where('name', 'push_notification_server_key')->first();

                if (!$settingObj) {
                    $settingObj = new Setting;
                    $settingObj->name = 'push_notification_server_key';
                    $settingObj->description = 'Push notification server key';
                }

                $settingObj->value = $jsonData;
                $settingObj->save();

                $request->session()->flash('success', 'Push notification server key updated successfully');
                return redirect()->back();
            }

            if ($requestData['request_type'] == 'app') {
                $app = [];

                if (isset($requestData['app_name']) && !empty($requestData['app_name'])) {
                    $app['app_name'] = $requestData['app_name'];
                }
                if (isset($requestData['rate_on_apple_store']) && !empty($requestData['rate_on_apple_store'])) {
                    $app['rate_on_apple_store'] = $requestData['rate_on_apple_store'];
                }
                if (isset($requestData['rate_on_google_store']) && !empty($requestData['rate_on_google_store'])) {
                    $app['rate_on_google_store'] = $requestData['rate_on_google_store'];
                }
                if (isset($requestData['terms_conditions']) && !empty($requestData['terms_conditions'])) {
                    $app['terms_conditions'] = $requestData['terms_conditions'];
                }
                if (isset($requestData['help']) && !empty($requestData['help'])) {
                    $app['help'] = $requestData['help'];
                }
                if (isset($requestData['privacy_policy']) && !empty($requestData['privacy_policy'])) {
                    $app['privacy_policy'] = $requestData['privacy_policy'];
                }

                $jsonData = json_encode($app);

                $settingObj = Setting::where('name', 'app')->first();

                if (!$settingObj) {
                    $settingObj = new Setting;
                    $settingObj->name = 'app';
                    $settingObj->description = 'APP setting is using to setup the Application Details';
                }

                $settingObj->value = $jsonData;
                $settingObj->save();

                $request->session()->flash('success', 'APP setting updated successfully');
                return redirect()->back();
            }

            if ($requestData['request_type'] == 'stripe') {
                $stripe = [
                    'public_key' => $requestData['public_key'],
                    'secret_key' => $requestData['secret_key'],
                ];

                $jsonData = json_encode($stripe);

                $settingObj = Setting::where('name', 'stripe')->first();

                if (!$settingObj) {
                    $settingObj = new Setting;
                    $settingObj->name = 'stripe';
                    $settingObj->description = 'Stripe setting is using to setup the payment gateway configuration';
                }

                $settingObj->value = $jsonData;
                $settingObj->save();

                $request->session()->flash('success', 'Stripe detail updated successfully');
                return redirect()->back();
            }

            if ($requestData['request_type'] == 'subscription') {
                $subscription = [
                    'subscription' => $requestData['subscription'],
                ];

                $jsonData = json_encode($subscription);

                $settingObj = Setting::where('name', 'subscription')->first();

                if (!$settingObj) {
                    $settingObj = new Setting;
                    $settingObj->name = 'subscription';
                    $settingObj->description = 'Subscription setting is using to setup the free trail';
                }

                $settingObj->value = $jsonData;
                $settingObj->save();

                $request->session()->flash('success', 'Subscription detail updated successfully');
                return redirect()->back();
            }

            if ($requestData['request_type'] == 'search_distance') {

                $distance = [
                    'search_distance_limit' => $requestData['search_distance_limit'],
                ];
                $jsonData = json_encode($distance);
                $settingObj = Setting::where('name', 'search_distance_limit')->first();

                if (!$settingObj) {
                    $settingObj = new Setting;
                    $settingObj->name = 'search_distance_limit';
                    $settingObj->description = 'APP setting is using to setup the Application Search distance limit';
                }
                $settingObj->value = $jsonData;
                $settingObj->save();

                $request->session()->flash('success', 'Search distance limit setting updated successfully');
                return redirect()->back();
            }

            if ($requestData['request_type'] == 'debug_mode') {
                $debug_mode = [
                    'debug_mode' => isset($requestData['debug_mode']) ? true : false,
                ];

                $jsonData = json_encode($debug_mode);

                $settingObj = Setting::where('name', 'debug_mode')->first();

                if (!$settingObj) {
                    $settingObj = new Setting;
                    $settingObj->name = 'debug_mode';
                    $settingObj->description = 'App debug mode on/off';
                }

                $settingObj->value = $jsonData;
                $settingObj->save();

                $request->session()->flash('success', 'Debug mode updated successfully');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function termsConditions(Request $request)
    {
        if ($request->isMethod('GET')) {
            $data = [];

            $termsConditions = Setting::where('name', 'terms_conditions')->first();
            $data = $termsConditions->value ?? [];
            $data['page_title'] = 'Terms & Conditions';

            return view('admin.terms_conditions.index')->with(compact('data'));
        }
        try {
            $requestData = $request->all();
            if (isset($requestData['terms_conditions']) && !empty($requestData['terms_conditions'])) {
                $termsConditions['terms_conditions'] = $requestData['terms_conditions'];
            }

            $jsonData = json_encode($termsConditions);

            $settingObj = Setting::where('name', 'terms_conditions')->first();

            if (!$settingObj) {
                $settingObj = new Setting;
                $settingObj->name = 'terms_conditions';
                $settingObj->description = 'Users terms & conditions';
            }

            $settingObj->value = $jsonData;
            $settingObj->save();

            $request->session()->flash('success', 'Terms Conditions updated successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function import()
    {
        Excel::import(new ModelImport, request()->file('file'));

        return back();
    }
    public function importmake()
    {

        Excel::import(new CarmodelImport, request()->file('file'));

        return back();
    }

    public function importmodel()
    {
        Excel::import(new CarmakeImport, request()->file('file'));



        return back();
    }

    public function importExportView()
    {
        return view('admin.Featurelist.importExport');
    }
    public function export()
    {
        return Excel::download(new ModelExport, 'users.xlsx');
    }
}
