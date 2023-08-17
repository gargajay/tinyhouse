<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $data = [];
    //     $data['page_title'] = 'Category';
    //     $result = Category::latest()->paginate(10);

    //     return view('admin.category.index')->with(compact('data', 'result'));
    // }

    public function index(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Category';

        $categoryObj = Category::latest();

        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;

            $categoryObj->whereRaw("(title ILIKE '%" . $q . "%')");

            $result = $categoryObj->paginate(10)->appends(['q' => $q]);
        } else {
            $result = $categoryObj->paginate(10);
        }

        return view('admin.category.index')->with(compact('data', 'result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['page_title'] = 'Add Category';

        return view('admin.category.create')->with(compact('data'));
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

            // 'image' => 'required|mimes:jpg,png,jpeg,gif|dimensions:min_width=200,min_height=200,max_width=200,max_height=200',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return redirect()->back()->withInput()->with('error', $errorResponse['message']);
            }

            $requestData = $request->all();

            $resourceObj = new Category;
            $resourceObj->title = $requestData['title'];
            // $resourceObj->es_title = $requestData['spanish_title'];

            // $resourceObj->description = $requestData['description'] ?? NULL;

            // if ($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $fileName = time() . '-' . $file->getClientOriginalName();
            //     $file->move(CATEGORY_IMAGE_PATH, $fileName);
            //     $resourceObj->image = $fileName;
            // }

            $resourceObj->save();

            return redirect()->route('category.index')->with('success', 'Category added successfully');
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
        $data = Category::find($id);
        $data['page_title'] = 'Category Detail';

        return view('admin.category.detail')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Category::find($id);
        $data['page_title'] = 'Edit Category';

        return view('admin.category.edit')->with(compact('data'));
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

            $resourceObj = Category::find($id);
            $resourceObj->title = $requestData['title'] ?? $resourceObj->title;
            // $resourceObj->es_title = $requestData['spanish_title'] ?? $resourceObj->es_title;

            // $resourceObj->description = $requestData['description'] ?? $resourceObj->description;

            // if ($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $fileName = time() . '-' . $file->getClientOriginalName();
            //     $file->move(CATEGORY_IMAGE_PATH, $fileName);
            //     $resourceObj->image = $fileName;
            // }

            $resourceObj->save();

            return redirect()->route('category.index')->with('success', 'Category updated successfully');
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
        error_log(print_r($id, true));
        // Need to find all addresses with the contacdt Id and delete them.
        Category::find($id)->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id = NULL)
    {
        error_log(print_r($id, true));

        if (!$id) {
            return redirect()->route('category.index')->with('error', 'Invalid category id');
        }

        $resourceObj = Category::find($id);

        if ($resourceObj->delete()) {
            return redirect()->route('category.index')->with('success', 'Category deleted successfully');
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

            $userObj = Category::find($requestData['resource_id']);
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
