<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Category;

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
        $data['page_title'] = 'Tiny homes';
        $categoryObj = Car::latest();
        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;

            $categoryObj->whereRaw("(make LIKE '%" . $q . "%')");
            $categoryObj->orWhereRaw("(model LIKE '%" . $q . "%')");
            $categoryObj->orWhereRaw("(year LIKE '%" . $q . "%')");

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
        $data['page_title'] = 'Add Tiny home';
        return view('admin.Tiny home.create')->with(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id = NULL)
    {


        if (!$id) {
            return redirect()->route('vehicle.index')->with('error', 'Invalid Tiny home id');
        }

        $resourceObj = Car::find($id);

        if ($resourceObj->delete()) {
            return redirect()->route('vehicle.index')->with('success', 'Tiny home deleted successfully');
        }
        return redirect()->route('vehicle.index')->with('error', DEFAULT_ERROR_MESSAGE);
    }
}
