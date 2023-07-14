<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Category;
use App\Models\VehicleCompany;
use App\Models\VehicleModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Vehicle';
        $categoryObj = VehicleCompany::latest();
        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;

            $categoryObj->whereRaw("(vehicle_name LIKE '%" . $q . "%')");

            $result = $categoryObj->paginate(10)->appends(['q' => $q]);
        } else {
            $result = $categoryObj->paginate(10);
        }

        return view('admin.vehicle.index')->with(compact('data', 'result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data = [];
        $data['page_title'] = 'Add Vehicle';
        return view('admin.vehicle.create')->with(compact('data'));
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
            'vehicle_name' => 'required',

        ];
        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = $validator->errors()->toArray();

                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }
            $requestData = $request->all();

            $resourceObj = new VehicleCompany;
            $resourceObj->vehicle_name = $requestData['vehicle_name'] ?? NULL;
            $resourceObj->save();

            return redirect()->route('vehicle.index')->with('success', 'Vehicle added successfully');
        } catch (Exception $e) {
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
    public function show(Request $request, $id)
    {
        // $data = [];
        $data['page_title'] = 'Vehicle Detail';
        $data = VehicleCompany::where('id', $id)->first();
        return view('admin.vehicle.detail')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = VehicleCompany::find($id);
        $data['page_title'] = 'Edit Vehicle';

        return view('admin.vehicle.edit')->with(compact('data'));
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
        $rules = [
            'vehicle_name' => 'required',
        ];


        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }

            $requestData = $request->all();

            $resourceObj = VehicleCompany::find($id);
            $resourceObj->vehicle_name = $requestData['vehicle_name'] ?? $resourceObj->vehicle_name;
            $resourceObj->save();

            return redirect()->route('vehicle.index')->with('success', 'Vehicle updated successfully');
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
    public function destroy($id)
    {

        // Need to find all addresses with the contact Id and delete them.
        VehicleCompany::find($id)->delete();
        return redirect()->route('vehicle.index')->with('success', 'Vehicle deleted successfully');
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
            return redirect()->route('vehicle.index')->with('error', 'Invalid Vehicle id');
        }

        $resourceObj = VehicleCompany::find($id);

        if ($resourceObj->delete()) {
            return redirect()->route('vehicle.index')->with('success', 'Vehicle deleted successfully');
        }
        return redirect()->route('vehicle.index')->with('error', DEFAULT_ERROR_MESSAGE);
    }
}
