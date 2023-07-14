<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\Modelyear;
use App\Models\VehicleCompany;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VehicleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $data = [];
        $data['page_title'] = 'Vehicle Model ';
        $result = VehicleModel::where('vehicle_companies_id', $request->get('cid'))->latest();
        $data['vehicle_name'] = VehicleCompany::where('id', $request->get('cid'))->first()->vehicle_name ?? "";
        $data['vehicle_companies_id'] = $request->get('cid') ?? "";

        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;

            $result->whereRaw("(model_name ILIKE '%" . $q . "%')");

            $result = $result->paginate(10)->appends(['q' => $q]);
        } else {
            $result = $result->paginate(10);
        }

        return view('admin.vehicle-model.index')->with(compact('data', 'result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Add vehicle model ';
        $data['vehicle_name'] = VehicleCompany::where('id', $request->get('cid'))->first()->vehicle_name ?? "";
        $data['vehicle_companies_id'] = $request->get('cid') ?? "";

        return view('admin.vehicle-model.create')->with(compact('data'));
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
        ];

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }

            $requestData = $request->all();

            $resourceObj = new VehicleModel;
            $resourceObj->vehicle_companies_id = $requestData['vehicle_companies_id'];
            $resourceObj->model_name = $requestData['title'];
            $resourceObj->save();

            return redirect()->route('vehicle-model.index', ['cid' => $requestData['vehicle_companies_id']])->with('success', 'vehicle model added successfully');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error($e->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleModel  $vehicleModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelObj = VehicleModel::find($id);
        if ($modelObj->delete()) {
            return redirect()->route('vehicle-model.index')->with('success', 'Vehicle model deleted successfully');
        }
        return redirect()->route('vehicle-model.index')->with('error', DEFAULT_ERROR_MESSAGE);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleModel  $vehicleModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = VehicleModel::find($id);
        $data['page_title'] = 'Edit Vehicle Model';

        return view('admin.vehicle-model.edit')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleModel  $vehicleModel
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
            $makeObj = VehicleModel::find($id);
            $makeObj->vehicle_companies_id = $requestData['vehicle_companies_id'];
            $makeObj->model_name = $requestData['title'];
            $makeObj->save();

            return redirect()->route('vehicle-model.index', ['cid' => $requestData['vehicle_companies_id']])->with('success', 'Vehicle model Updated successfully');
        } catch (\Exception $e) {

            $message = $e->getMessage();
            Log::error($e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleModel  $vehicleModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function delete(Request $request, $id = NULL)
    {
        if (!$id) {
            return redirect()->route('vehicle-model.index')->with('error', 'Invalid category id');
        }

        $resourceObj = VehicleModel::find($id);

        if ($resourceObj->delete()) {
            return redirect()->route('vehicle-model.index', ['cid' => $request->get('cid')])->with('success', 'Vehicle Model deleted successfully');
        }
        return redirect()->route('vehicle-model.index', ['cid' => $request->get('cid')])->with('error', DEFAULT_ERROR_MESSAGE);
    }
}
