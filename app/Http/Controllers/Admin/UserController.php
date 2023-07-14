<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobCategory;
use App\Models\JobSubCategory;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Addgift;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Users';

        $userObj = User::where('user_type','!=', "admin")->latest()->withTrashed();
        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;

            $userObj->whereRaw("(name ILIKE '%" . $q . "%' OR first_name ILIKE '%" . $q . "%' OR last_name ILIKE '%" . $q . "%' OR email ILIKE '%" . $q . "%' OR mobile ILIKE '%" . $q . "%')");

            $result = $userObj->paginate(10)->appends(['q' => $q]);
        } else {
            $result = $userObj->paginate(10);
        }

        return view('admin.user.index')->with(compact('data', 'result'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['page_title'] = 'Add User';

        return view('admin.user.create')->with(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }

            $requestData = $request->all();

            //$resourceObj = new User;

            return redirect()->route('user.index')->with('success', 'User added successfully');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error($e->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::where('id', $id)->first();
        $data['page_title'] = 'User Detail';

        return view('admin.user.detail')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::find($id);
        $data['page_title'] = 'Edit User';

        return view('admin.user.edit')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }

            $requestData = $request->all();

            $resourceObj = User::find($requestData['update_id']);
            $resourceObj->name = $requestData['name'];

            $resourceObj->save();

            return redirect()->route('user.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error($e->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    // public function delete(Request $request, $id = NULL)
    // {
    //     if (!$id) {
    //         return redirect()->route('user.index')->with('error', 'Invalid category id');
    //     }

    //     // $resourceObj = User::find($id)->withTrashed(); 
    //     $resourceObj = User::where('id', $id)->withTrashed()->first();
    //     if ($resourceObj->deleted_at == null) {
    //         $giftObjs = Addgift::where('user_id', $id)->withTrashed()->get();
    //         foreach ($giftObjs as  $giftObj) {
    //             $giftObj->delete();
    //         }
    //         $resourceObj->delete();
    //         $message = 'User disabled successfully';
    //     } else {
    //         $giftObjs = Addgift::where('user_id', $id)->withTrashed()->get();
    //         foreach ($giftObjs as  $giftObj) {
    //             $giftObj->restore();
    //         }
    //         $resourceObj->restore();
    //         $message = 'User enabled successfully';
    //     }
    //     $resourceObj->is_status = $request->is_status;
    //     if ($resourceObj->save()) {
    //         return redirect()->route('user.index')->with('success', $message);
    //     }
    //     return redirect()->route('user.index')->with('error', DEFAULT_ERROR_MESSAGE);
    // }

    public function delete(Request $request, $id = NULL)
    {
        try {
            $userObj = User::withTrashed()->find($id);
            if ($userObj->deleted_at) {
                $userObj->restore();
                $message = 'User restored successfully';
            } else {
                $userObj->delete();
                $message = 'User blocked successfully';
            }
            return redirect()->route('user.index')->with('success', $message);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error($e->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    public function updateStatus(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $requestData = $request->all();

            $rules = [
                'resource_id' => 'required',
                'status' => 'required',
            ];
            $rules = [];
            $userId = $request->user()->id;
            if (isset($requestData['email']) && !empty($requestData['email'])) {

                $rules['email'] = [
                    'email' => Rule::unique('users', 'email')->ignore($userId)->whereNull('deleted_at')
                ];
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }

            $userObj = User::find($requestData['resource_id']);
            $userObj->status = $requestData['status'];

            $userObj->save();

            $response['data'] = $userObj;
            $response['message'] = 'Status updated successfully';
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }

        return response()->json($response, $response['status']);
    }
    //

    // ========================================================================== Seller User =========================================================================
    public function getSellerUser(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Seller Users';
        $userObj = User::whereIn('id', function($query) {
            $query->select('user_id')
                  ->from('cars');
        })->latest();


        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;
            $userObj->whereRaw("(name ILIKE '%" . $q . "%' OR first_name ILIKE '%" . $q . "%' OR last_name ILIKE '%" . $q . "%' OR email ILIKE '%" . $q . "%' OR mobile ILIKE '%" . $q . "%')");
            $result = $userObj->paginate(10)->appends(['q' => $q]);
        } else {
            $result = $userObj->paginate(10);
        }

        return view('admin.sellerUser.index')->with(compact('data', 'result'));
    }

    public function sellerUserShow($id)
    {
        $data['page_title'] = 'Seller User Detail';
        $data = User::where('id', $id)->first();
        $car = Car::where('user_id',$id)->latest();
        $result = $car->paginate(10);
        return view('admin.sellerUser.detail')->with(compact('data', 'result'));
    }



    public function sellerCarDetails($id)
    {
        $data['page_title'] = 'Seller Car Detail';
        $data = Car::where('id', $id)->with('cars_images')->first();
        return view('admin.sellerUser.sellercardetail')->with(compact('data'));
    }
    // ========================================================================== Seller User =========================================================================
}
