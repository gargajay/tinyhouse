<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
use Exception;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Sub-category ';
        $result = SubCategory::where('category_id', $request->get('cid'))->latest();

        $data['category_title'] = Category::where('id', $request->get('cid'))->first()->title ?? "";
        $data['category_id'] = $request->get('cid') ?? "";

        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;

            $result->whereRaw("(title ILIKE '%" . $q . "%')");

            $result = $result->paginate(10)->appends(['q' => $q]);
        } else {
            $result = $result->paginate(10);
        }

        return view('admin.sub-category.index')->with(compact('data', 'result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Add Sub-category ';

        $data['category_title'] = Category::where('id', $request->get('cid'))->first()->title ?? "";
        $data['category_id'] = $request->get('cid') ?? "";

        return view('admin.sub-category.create')->with(compact('data'));
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
            'image' => 'required|mimes:jpg,png,jpeg,gif|dimensions:min_width=200,min_height=200,max_width=200,max_height=200',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }

            $requestData = $request->all();

            $resourceObj = new SubCategory;
            $resourceObj->category_id = $requestData['category_id'];
            $resourceObj->title = $requestData['title'];
            $resourceObj->description = $requestData['description'] ?? NULL;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(SUB_CATEGORY_IMAGE_PATH, $fileName);
                $resourceObj->image = $fileName;
            }

            $resourceObj->save();

            return redirect()->route('sub-category.index', ['cid' => $requestData['category_id']])->with('success', 'Sub-category added successfully');
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
        $data = SubCategory::find($id);
        $data['page_title'] = 'Sub-category Detail';

        return view('admin.sub-category.detail')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = SubCategory::find($id);
        $data['page_title'] = 'Edit Sub-category ';

        $data['category_title'] = Category::where('id', $request->get('cid'))->first()->title ?? "";
        $data['category_id'] = $request->get('cid') ?? "";

        return view('admin.sub-category.edit')->with(compact('data'));
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

        if ($request->hasFile('image')) {
            $rules['image'] = 'required|mimes:jpg,png,jpeg,gif|dimensions:min_width=200,min_height=200,max_width=200,max_height=200';
        }

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }

            $requestData = $request->all();

            $resourceObj = SubCategory::find($id);
            $resourceObj->title = $requestData['title'] ?? $resourceObj->title;
            $resourceObj->description = $requestData['description'] ?? $resourceObj->description;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(SUB_CATEGORY_IMAGE_PATH, $fileName);
                $resourceObj->image = $fileName;
            }

            $resourceObj->save();

            return redirect()->route('sub-category.index', ['cid' => $requestData['category_id']])->with('success', 'Sub-category updated successfully');
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
    public function delete(Request $request, $id = NULL)
    {
        if (!$id) {
            return redirect()->route('sub-category.index')->with('error', 'Invalid category id');
        }

        $resourceObj = SubCategory::find($id);

        if ($resourceObj->delete()) {
            return redirect()->route('sub-category.index', ['cid' => $request->get('cid')])->with('success', 'Sub-category deleted successfully');
        }
        return redirect()->route('sub-category.index', ['cid' => $request->get('cid')])->with('error', DEFAULT_ERROR_MESSAGE);
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

            $userObj = SubCategory::find($requestData['resource_id']);
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
