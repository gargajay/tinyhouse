<?php

namespace App\Http\Controllers\ThirdParty;

use App\Exceptions\GoCarHubException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Respons;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//models

class UserController extends Controller
{

    /**
     * create new dealer
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function createDealer(Request $request): JsonResponse
    {
        try {
            // validate rules
            $rules = [
                'name' => ['required', 'string', 'max:191'],
                'email' => ['required', 'email:strict', 'iunique:users,email', 'max:199'],
                //'mobile	' => ['nullable', 'iunique:users,mobile	', 'max:20'],
                //'country_code' => [Rule::requiredIf(!empty($request->mobile)), 'nullable', 'max:10'],
                'password' => ['nullable', 'min:6', 'max:30'],
                // 'device_token' => ['nullable', 'max:255'],
                // 'device_type' => [Rule::requiredIf(!empty($request->device_token)), 'nullable', 'in:IOS,android'],
                'image' => ['nullable', 'mimes:jpg,png,jpeg,gif', 'dimensions:min_width=50,min_height=50,max_width=500,max_height=500', 'max:1024'],
                // 'insert' => ['nullable', 'in:0,1'],
                // 'update' => ['nullable', 'in:0,1'],
                // 'delete' => ['nullable', 'in:0,1'],
            ];

            // validate input data
            GoCarHubException::assertValidation($request->all(), $rules);

            DB::beginTransaction();

            //save user data
            $userData = new User;
            $userData->agent_id = $request->user()->id;
            $userData->name = $request->name;
            $userData->email = $request->email;
            // $userData->mobile = $request->mobile;
            // $userData->country_code = $request->country_code ;
            $userData->password = $request->password ? bcrypt($request->password) : bcrypt('aokser56s6df5');
            // $userData->device_token = $request->device_token;
            // $userData->device_type = $request->device_type;
            if ($request->hasFile('image')) {
                $userData->image = uploadSingleImage($request->file('image'), IMAGE_UPLOAD_PATH);
            }
            // $userData->permission = implode('', array_filter([($request->insert ? 1 : ''), ($request->update ? 2 : ''), ($request->delete ? 3 : '')]));
            $userData->user_type = 'dealer';

            //save user data
            if ($userData->save()) {
                $userData->setAppends([]);
                // $userData->access_token = $userData->createToken($userData->id . ' token')->accessToken;
                return successReturn($userData, __("message.DEALER_REGISTERED_SUCCESSFULLY"));
            }
        } catch (Exception $e) {
            DB::rollback();
            throw ($e);
        }
    }


    /**
     * login user
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(Request $request): JsonResponse
    {
        try {
            // validate rules
            $rules = [
                'email' => ['required', 'email:strict', 'iexists:users,email,user_type,agent', 'max:199'],
                'password' => ['required', 'min:6', 'max:30'],
            ];

            // validate input data
            GoCarHubException::assertValidation($request->all(), $rules);

            //check auth
            if (Auth::attempt(array('email' => $request->email, 'password' => $request->password))) {
                $userData = User::select('id', 'name', 'email', 'country_code', 'mobile', 'image')->where('email', $request->email)->first();
                $userData->setAppends([]);
                $userData->access_token = $userData->createToken($userData->id . ' token')->accessToken;
                return successReturn($userData, __("message.LOGIN_SUCCESSFULLY"), false);
            }
            throw new GoCarHubException(__("message.INCORRECT_PASSWORD"));
        } catch (Exception $e) {
            throw ($e);
        }
    }
}
