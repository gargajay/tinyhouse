<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Subscription';

        $subscriptionObj = Subscription::latest();

        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;

            $subscriptionObj->whereRaw("(name ILIKE '%" . $q . "%')");

            $result = $subscriptionObj->paginate(10)->appends(['q' => $q]);
        } else {
            $result = $subscriptionObj->paginate(10);
        }

        return view('admin.subscription.index')->with(compact('data', 'result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['page_title'] = 'Add subscription';

        return view('admin.subscription.create')->with(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'title' => 'required',
            // 'image' => 'required|mimes:jpg,png,jpeg,gif|dimensions:min_width=200,min_height=200,max_width=200,max_height=200',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }

            $requestData = $request->all();

            $resourceObj = new Subscription;
            $resourceObj->name = $requestData['title'] ?? NULL;
            $resourceObj->es_name = $requestData['spanish_title'] ?? NULL;

            $resourceObj->price = $requestData['price'] ?? NULL;
            $resourceObj->duration = $requestData['duration'] ?? NULL;
            $resourceObj->description = $requestData['description'] ?? NULL;
            $resourceObj->es_description = $requestData['spanish_description'] ?? NULL;

            $resourceObj->save();

            return redirect()->route('subscription.index')->with('success', 'Subscription added successfully');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error($e->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $message);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Subscription::find($id);
        $data['page_title'] = 'Subscription Detail';

        return view('admin.subscription.detail')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Subscription::find($id);
        $data['page_title'] = 'Edit subscription';

        return view('admin.subscription.edit')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // error_log(print_r($request->all(), true));
        // error_log(print_r($id, true));

        $rules = [
            'title' => 'required',
        ];

        if ($request->hasFile('image')) {
            // $rules['image'] = 'required|mimes:jpg,png,jpeg,gif|dimensions:min_width=200,min_height=200,max_width=200,max_height=200';
        }

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }

            $requestData = $request->all();

            $resourceObj = Subscription::find($id);
            $resourceObj->name = $requestData['title'] ??   $resourceObj->name;
            $resourceObj->es_name = $requestData['spanish_title'] ??   $resourceObj->es_name;

            $resourceObj->price = $requestData['price'] ?? $resourceObj->price;
            $resourceObj->duration = $requestData['duration'] ?? $resourceObj->duration;
            $resourceObj->description = $requestData['description'] ??  $resourceObj->description;
            $resourceObj->es_description = $requestData['spanish_description'] ??  $resourceObj->es_description;
            // dd($resourceObj);
            $resourceObj->save();
            // $resourceObj->description = $requestData['description'] ?? $resourceObj->description;

            // if ($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $fileName = time() . '-' . $file->getClientOriginalName();
            //     $file->move(CATEGORY_IMAGE_PATH, $fileName);
            //     $resourceObj->image = $fileName;
            // }

        

            return redirect()->route('subscription.index')->with('success', 'subscription updated successfully');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error($e->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id = NULL)
    {


        if (!$id) {
            return redirect()->route('subscription.index')->with('error', 'Invalid category id');
        }

        $resourceObj = Subscription::find($id);

        if ($resourceObj->delete()) {
            return redirect()->route('subscription.index')->with('success', 'subscription deleted successfully');
        }
        return redirect()->route('category.index')->with('error', DEFAULT_ERROR_MESSAGE);
    }

    public function updateStatus(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $requestData = $request->all();
            $userId = $request->user()->id;
            $rules = [
                'resource_id' => 'required',
                'status' => 'required',
            ];
            $rules = [];

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

            $userObj = Subscription::find($requestData['resource_id']);
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
}
