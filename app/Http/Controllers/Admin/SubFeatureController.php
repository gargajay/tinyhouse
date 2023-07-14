<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\Featurelist;
use App\Models\Modelyear;
use App\Models\VehicleCompany;
use Illuminate\Http\Request;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SubFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $data = [];
        $data['page_title'] = 'Sub Feature ';
        $result = Featurelist::where('parent_id', $request->get('cid'))->latest();
        $data['vehicle_name'] = Featurelist::where('id', $request->get('cid'))->first()->title ?? "";
        $data['vehicle_companies_id'] = $request->get('cid') ?? "";

        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;

            $result->whereRaw("(title ILIKE '%" . $q . "%')");

            $result = $result->paginate(10)->appends(['q' => $q]);
        } else {
            $result = $result->paginate(10);
        }

        return view('admin.sub-feature.index')->with(compact('data', 'result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Add Sub Feature';
        $data['vehicle_name'] = Featurelist::where('id', $request->get('cid'))->first()->title ?? "";
        $data['vehicle_companies_id'] = $request->get('cid') ?? "";

        return view('admin.sub-feature.create')->with(compact('data'));
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

            $resourceObj = new Featurelist;
            $resourceObj->parent_id = $requestData['vehicle_companies_id'];
            $resourceObj->title = $requestData['title'];
            $resourceObj->es_title = $requestData['spanish_title'];

            $resourceObj->save();

            return redirect()->route('sub-feature.index', ['cid' => $requestData['vehicle_companies_id']])->with('success', 'Sub Feature added successfully');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error($e->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Featurelist  $Featurelist
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelObj = Featurelist::find($id);
        if ($modelObj->delete()) {
            return redirect()->route('sub-feature.index')->with('success', 'Sub Feature deleted successfully');
        }
        return redirect()->route('sub-feature.index')->with('error', DEFAULT_ERROR_MESSAGE);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Featurelist  $Featurelist
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Featurelist::find($id);
        $data['page_title'] = 'Edit Sub Feature';

        return view('admin.sub-feature.edit')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Featurelist  $Featurelist
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
            $makeObj = Featurelist::find($id);
            // $makeObj->parent_id = $requestData['vehicle_companies_id'];
            $makeObj->title = $requestData['title'];
            $makeObj->es_title = $requestData['spanish_title'];

            $makeObj->save();

            return redirect()->route('sub-feature.index', ['cid' => $requestData['vehicle_companies_id']])->with('success', 'Sub Feature Updated successfully');
        } catch (\Exception $e) {

            $message = $e->getMessage();
            Log::error($e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Featurelist  $Featurelist
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function delete(Request $request, $id = NULL)
    {
        // dd($request->cid);
        // die;
        if (!$id) {
            return redirect()->route('sub-feature.index')->with('error', 'Invalid category id');
        }

        $resourceObj = Featurelist::find($id);

        if ($resourceObj->delete()) {
            return redirect()->route('sub-feature.index', ['cid' =>  $resourceObj->parent_id])->with('success', 'Sub Feature deleted successfully');
        }
        return redirect()->route('sub-feature.index', ['cid' => $resourceObj->parent_id])->with('error', DEFAULT_ERROR_MESSAGE);
    }
}
