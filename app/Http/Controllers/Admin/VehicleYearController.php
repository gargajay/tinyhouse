<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\Modelyear;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VehicleYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Vehicle Year';

        $makeObj = Modelyear::latest();

        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;

            $makeObj->whereRaw("(year ILIKE '%" . $q . "%')");

            $result = $makeObj->paginate(10)->appends(['q' => $q]);
        } else {
            $result = $makeObj->paginate(10);
        }

        return view('admin.year.index')->with(compact('data', 'result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['page_title'] = 'Add Vehicle Year';

        return view('admin.year.create')->with(compact('data'));
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
            $resourceObj = new Modelyear;
            $resourceObj->year = $requestData['title'];
            $resourceObj->save();

            return redirect()->route('year.index')->with('success', 'Year added successfully');
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
        $data = Modelyear::find($id);
        $data['page_title'] = 'Vehicle Year Detail';

        return view('admin.year.detail')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Modelyear::find($id);
        $data['page_title'] = 'Edit Vehicle Year';

        return view('admin.year.edit')->with(compact('data'));
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
        // error_log(print_r($request->all(), true));
        // error_log(print_r($id, true));

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

            $resourceObj = Modelyear::find($id);
            $resourceObj->year = $requestData['title'] ?? $resourceObj->year;
            $resourceObj->save();

            return redirect()->route('year.index')->with('success', 'Year updated successfully');
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
        // error_log(print_r($id, true));
        // Need to find all addresses with the contacdt Id and delete them.
        Modelyear::find($id)->delete();
        return redirect()->route('year.index')->with('success', 'Year deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id = NULL)
    {


        if (!$id) {
            return redirect()->route('year.index')->with('error', 'Invalid Year id');
        }

        $resourceObj = Modelyear::find($id);

        if ($resourceObj->delete()) {
            return redirect()->route('year.index')->with('success', 'Year deleted successfully');
        }
        return redirect()->route('year.index')->with('error', DEFAULT_ERROR_MESSAGE);
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

            $userObj = Modelyear::find($requestData['resource_id']);
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
