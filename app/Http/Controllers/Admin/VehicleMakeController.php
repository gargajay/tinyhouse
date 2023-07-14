<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\Modelyear;
use Illuminate\Http\Request;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VehicleMakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Vehicle Make';

        $makeObj = Carmake::with('years')->latest();

        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;

            $makeObj->whereRaw("(name ILIKE '%" . $q . "%')");

            $result = $makeObj->paginate(10)->appends(['q' => $q]);
        } else {
            $result = $makeObj->paginate(10);
        }

        return view('admin.make.index')->with(compact('data', 'result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['page_title'] = 'Add Vehicle Make';
        $data['YearMakes'] = Modelyear::orderBy('year', 'asc')->get();
        return view('admin.make.create')->with(compact('data'));
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
            'title' => 'required'
        ];

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }

            $requestData = $request->all();

            $vehicleObj = new Carmake;
            $vehicleObj->year_id = $requestData['year_id'];
            $vehicleObj->name = $requestData['title'];
            $vehicleObj->save();

            return redirect()->route('make.index')->with('success', 'Vehicle Make added successfully');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error($e->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleMake  $vehicleMake
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $makeObj = Carmake::find($id);

        if ($makeObj->delete()) {
            return redirect()->route('make.index')->with('success', 'Vehicle Make deleted successfully');
        }
        return redirect()->route('make.index')->with('error', DEFAULT_ERROR_MESSAGE);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleMake  $vehicleMake
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Carmake::find($id);
        $data['page_title'] = 'Edit Vehicle Make';
        $data['YearMakes'] = Modelyear::orderBy('year', 'asc')->get();
        return view('admin.make.edit')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleMake  $vehicleMake
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required'
        ];

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }

            $requestData = $request->all();

            $makeObj = Carmake::find($id);
            $makeObj->year_id = $requestData['year_id'];
            $makeObj->name = $requestData['title'];
            $makeObj->save();

            return redirect()->route('make.index')->with('success', 'Vehicle Make Updated successfully');
        } catch (\Exception $e) {

            $message = $e->getMessage();
            Log::error($e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleMake  $vehicleMake
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleMake $vehicleMake)
    {
        //
    }
}
