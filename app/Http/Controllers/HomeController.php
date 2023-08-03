<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use App\Exceptions\GoCarHubException;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data['categories'] = Car::getCategories();

        $data['cars']   = Car::latest()->get();
        return view('user.home', $data);
    }

    public function search(Request $request)
    {
        $data['years'] = Car::getDataList('year');
        $data['makes'] = Car::getDataList('make');
        $data['models'] = Car::getDataList('model');
        $data['categories'] = Car::getCategories();
        $data['conditions'] = Car::getDataList('condition');
        $data['sleeps'] = Car::getDataList('sleep');
        $data['shower'] = Car::getDataList('shower/toilet');
        $data['appliances'] = Car::getDataList('kitchen/appliances');
        $data['windows'] = Car::getDataList('windows');
        $data['availability'] = Car::getDataList('availability');
        $data['frame'] = Car::getDataList('frame');
        $data['budget'] = Car::getDataList('budget');
        $data['shipping'] = Car::getDataList('national_shipping');

       


        return view('user.search',$data);

    }

    public function search2(Request $request)
    {
        // dd(1);
        $searchQuery = $request->input('search_term');
        $data['cars'] = $this->performSearch($request,$searchQuery);
        return view('user.search-result', $data);
    }

    public function performSearch($request,$searchQuery)
    {
        // Perform your search logic here using the $searchQuery
        // For example:
        $filter = collect();
        $filter->put('search_term', "");
        $filter->put('category_id', "");
        $filter->put('condition', "");
        $filter->put('mileage', "");
        $filter->put('miles', "");
        $filter->put('min_price', "");
        $filter->put('max_price', "");
        $filter->put('make', "");
        $filter->put('model', "");
        $filter->put('year', "");
        $filter->put('engine_size', "");
        $filter->put('sort', "");

        $requestData = $request->all();


        $carObj = Car::
            where(function ($query) {
                $sevenDaysBackDate = Carbon::now()->subDays(7)->format('Y-m-d');
                $query->whereNull('sold_at')
                    ->orWhere('sold_at', '>=', $sevenDaysBackDate);
            });
        if (isset($requestData['search_term']) && $requestData['search_term'] != '') {
            $filter->put('search_term', $request->search_term);
            $lower = strtolower($request->search_term);
            $queryParts = explode(" ", $lower);
            $carObj = $carObj->where(function ($query) use ($queryParts) {
                foreach ($queryParts as $searchTerm) {
                    $bindings = [$searchTerm, 2];
                    $query->where('year', 'like', "%{$searchTerm}%")
                        ->orWhere('engine_size', 'like', "%{$searchTerm}%")
                        ->orWhere('car_type', 'like', "%{$searchTerm}%")
                        // ->orWhere('car_fuel_type', 'like', "%{$searchTerm}%")
                        // ->orWhere('color', 'like', "%{$searchTerm}%")
                        ->orWhere('make', 'like', "%{$searchTerm}%")
                        ->orWhere('model', 'like', "%{$searchTerm}%");
                    
                }
            });
        }
        if (isset($requestData['category_id']) && $requestData['category_id'] != '') {
            $category_id = $request->category_id;
            $carObj->Where(function ($query) use ($category_id) {
                $query->where('category_id', $category_id)->orWhere('category_id', null);
            });
            $filter->put('category_id', $request->category_id);
        }
        if (isset($requestData['year']) && $requestData['year'] != '') {
            $year = (int) $request->year;
            $carObj->whereIn('year', [$year - 1, $year, $year + 1]);
                        $filter->put('year', $request->year);
        }
        if (isset($requestData['make']) && $requestData['make'] != '') {
            $carObj->where('make', '=', $request->make);
            $filter->put('make', $request->make);
        }
        if (isset($requestData['model']) && $requestData['model'] != '') {
            $carObj->where('model', '=', $request->model);
            $filter->put('model', $request->model);
        }
        if (isset($requestData['engine_size']) && $requestData['engine_size'] != '') {
            $engine_size = $request->engine_size;
            $carObj->where(function ($query) use ($engine_size) {
                $query->where('engine_size', $engine_size)->orWhere('engine_size', null);
            });
            $filter->put('engine_size', $request->engine_size);
        }

        if (isset($requestData['condition']) && $requestData['condition'] != '') {
            $condition = $request->condition;
            $carObj->where(function ($query) use ($condition) {
                $query->where('condition', $condition)->orWhere('condition', null);
            });
            $filter->put('condition', $request->condition);
        }

        if (isset($requestData['mileage']) && $requestData['mileage'] != '') {
            $mileage = $request->mileage;
            $carObj->where(function ($query) use ($mileage) {
                $query->where('mileage', '<=', $mileage)->orWhere('mileage', null);
            });
            $filter->put('mileage', $request->mileage);
        }

        if (isset($requestData['min_price']) && $requestData['min_price'] != '') {
            $filter->put('min_price', $request->min_price);
            $carObj->where('amount', '>=', $requestData['min_price']);
        }
        if (isset($requestData['max_price']) && $requestData['max_price'] != '') {
            $filter->put('max_price', $request->max_price);
            $carObj->where('amount', '<=', $requestData['max_price']);
        }

        $distanceRaw = null;
    if (isset($requestData['latitude']) && $requestData['longitude'] != '') {
        if (isset($requestData['km']) && $requestData['km'] != '') {
            $search_distance_limit = $requestData['km'];
        } else {
            $setting = Setting::where('name', 'search_distance_limit')->first();
            $search_distance_limit = $setting->value ?? 50;
        }
        $userLat = $requestData['latitude'];
        $userLong = $requestData['longitude']; // Fix typo "Lng" to "lng"
        $meters = ((int) $search_distance_limit * 1000); // Convert km to meters (1 km = 1000 meters)
        // Note: In MySQL, the order of latitude and longitude is reversed compared to PostgreSQL.
        // The function ST_DWithin() in PostgreSQL is similar to ST_Distance() in MySQL.
        // We use ST_Distance() to filter cars within the specified distance (in meters).
        $carObj->whereRaw("ST_Distance_Sphere(cars.geolocation, POINT($userLong, $userLat)) <= $meters");
        $distanceRaw = "ST_Distance_Sphere(cars.geolocation, POINT($userLong, $userLat))";
    }


        if (!empty($request->sort)) {
            if ($request->sort == 'recent_first') {
                $carObj->orderBy("id", "DESC");
            } else if ($request->sort == 'closest_first') {
                // if ($distanceRaw) {
                //     $carObj->orderBy(DB::raw($distanceRaw), 'asc');
                // }
            } else if ($request->sort == 'price_lh') {
                $carObj->orderBy("min_amount", "ASC");
                $carObj->orderBy("amount", "ASC");
            } else if ($request->sort == 'price_hl') {
                $carObj->orderBy("min_amount", "DESC");
                $carObj->orderBy("amount", "DESC");
            } else if ($request->sort == 'model_newest') {
                $carObj->orderBy("year", "DESC");
            } else if ($request->sort == 'mileage_lowest') {
                $carObj->orderBy("mileage", "ASC");
            } else {
                $carObj->orderBy("id", "DESC");
            }
            $filter->put('sort', $request->sort);
        } else {
            $carObj->orderBy('id', 'DESC');
        }
        // $carObj->with([
        //     'carImages' => function ($query) {
        //         $query->select('id', 'car_id', 'image');
        //     }
        // ]);

       $results =  $carObj->paginate(20);

        return $results;
    }

    public function postDetail(Request $request)
    {
        $id = $request->id;
        $data['post'] =  Car::with('cars_images')->findOrFail($request->id);
        // dd($data['post']);
        return view('user.single-post', $data);
    }

    public function myHome(Request $request)
    {
        $data['cars']   = Car::where('user_id',Auth()->id())->latest()->get();
        return view('user.myhome',$data);
    }

    public function about(Request $request)
    {
        
        return view('user.about');
    }

    public function privacy(Request $request)
    {
        
        return view('user.privacy');
    }

    
    public function termCondition(Request $request)
    {
        
        return view('user.term-condition');
    }

    public function accountSetting(Request $request)
    {
        
        return view('user.account-setting');
    }

    public function CreatePost(Request $request)
    {
        $data['years'] = Car::getDataList('year');
        $data['makes'] = Car::getDataList('make');
        $data['models'] = Car::getDataList('model');
        $data['categories'] = Car::getCategories();
        $data['conditions'] = Car::getDataList('condition');
        $data['sleeps'] = Car::getDataList('sleep');
        $data['shower'] = Car::getDataList('shower/toilet');
        $data['appliances'] = Car::getDataList('kitchen/appliances');
        $data['windows'] = Car::getDataList('windows');
        $data['availability'] = Car::getDataList('availability');
        $data['frame'] = Car::getDataList('frame');
        $data['budget'] = Car::getDataList('budget');
        $data['shipping'] = Car::getDataList('national_shipping');

        return view('user.post', $data);
    }

    public function showSignupForm()
    {
        return view('admin.signup');
    }
   

    public function signup(Request $request)
    {
    try {

        // For GET requests, show the signup form view
        if ($request->isMethod('get')) {
            return $this->showSignupForm();
        }
        
        DB::beginTransaction();
        
        $rules = [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            // 'confirm_password' => 'required|min:6',
             'accept_term_and_conditons' =>'required'
            // Add other validation rules for your form fields
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $requestData = $request->all();
        // $setting = Setting::where('name', 'subscription')->first();
        // $subscription_expiry_days = $setting->value ?? 30;

        $userObj = new User;
        $userObj->first_name = $requestData['first_name'] ?? "";
        $userObj->last_name = $requestData['last_name'] ?? "";
        $userObj->name = $userObj->first_name . " " . $userObj->last_name;
        $userObj->email = strtolower($requestData['email']);
        $userObj->password = Hash::make($requestData['password']);
        $userObj->device_token = $requestData['device_token'] ?? "";
        $userObj->device_type = $requestData['device_type'] ?? "";
        $userObj->lat = $requestData['latitude']  ?? '30.00000';
        $userObj->lng = $requestData['longitude']  ?? '78.0000';
        $userObj->country_code = $requestData['country_code'] ?? "";
        $userObj->mobile = $requestData['mobile'] ?? "";

      //  dd($userObj);
        // Add other fields similar to the API signup
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(IMAGE_UPLOAD_PATH, $fileName);
            $userObj->image = $fileName;
        }

        if ($userObj->save()) {

            $address = Address::where('user_id', $userObj->id)->first();
            if (!$address) {
                $address = new Address;
                $address->user_id = $userObj->id;
            }
            $address->address1 = $requestData['address1'] ?? '';
            $address->address2 = $requestData['address2'] ?? '';
            $address->city = $requestData['city'] ?? '';
            $address->state = $requestData['state'] ?? '';
            $address->country = $requestData['country'] ?? '';
            $address->zip = $requestData['zip'] ?? '';
            $address->lat = $requestData['latitude']  ?? '';
            $address->lng = $requestData['longitude']  ??  '';

            if ($address->save()) {
                $latitude = $requestData['latitude']  ?? NULL;
                $longitude = $requestData['longitude']  ?? NULL;
                if ($latitude && $longitude) {
                    saveGeolocation(DB::class, 'addresses', $address->id, $latitude, $longitude);
                    saveGeolocation(DB::class, 'users', $address->user_id, $latitude, $longitude);
                }
            }
          

            Auth::login($userObj);
            // Perform additional actions if needed
        }

        DB::commit();

        // Redirect to a success page or wherever you want
        return redirect('/')->with('message', __("message.REGISTERED_SUCCESSFULLY"));
    } catch (\Exception $e) {
        DB::rollback();
        dd($e);
        Log::error($e->getTraceAsString());

        // Redirect back with error message if any exception occurs
        return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
    }
}



    public function AddCars(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        error_log(print_r($request->all(), true));
        DB::beginTransaction();
        try {
            $rules = ['model' => 'required', 'make' => 'required', 'year' => 'required', 'car_address' => 'required'];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }
            $requestData = $request->all();
            $userId = $request->user()->id ?? 0;;
            $userObj = User::find($userId);
            $currentDate = Carbon::now()->format('Y-m-d');
            $userObj = User::find($userId);
            $resourceObj = new Car;
            $resourceObj->user_id = $userId;

            $resourceObj->year = $requestData['year'] ?? "";
            $resourceObj->make = $requestData['make'] ?? "";
            $resourceObj->model = $requestData['model'] ?? "";
            // $resourceObj->engine_number = $requestData['engine_number'] ?? null;
            // $resourceObj->meter_reading = $requestData['meter_reading'] ?? null;
            // $resourceObj->car_fuel_type = $requestData['car_fuel_type'] ?? null;
            $resourceObj->car_number = $requestData['car_number_plate'] ?? generate_string('');;
            $resourceObj->post_ad_number = generate_string(''); // uniqid('post_', true);

            $resourceObj->engine_size = $requestData['engine_size'] ?? null;
            $splitParts = explode("-", $request->amount);

            // if (isset($splitParts)) {
            //     $part1 = $splitParts[0];
            //     $part2 = $splitParts[1];
            // }


            // $resourceObj->min_amount = $part1 ?? 0;
            $resourceObj->amount = $request->amount ?? 0;

            $resourceObj->description = $requestData['description'] ?? null;
            // $resourceObj->car_type = $request->car_type ? $request->car_type:"shipping";

            $findme = $requestData['find_me_buyer'] ?? false;

            if ($findme == 'false' || $findme == 'False') {
                $findme = false;
            }
            $resourceObj->find_me_buyer = $findme;
            $resourceObj->post_ad_number = generate_string(''); // uniqid('post_', true);

            $resourceObj->lat = $requestData['lat'] ?? ($requestData['latitude'] ?? '26.1128562');
            $resourceObj->lng = $requestData['lng'] ?? ($requestData['longitude'] ?? '-80.1426190');
            $resourceObj->city = $requestData['city'] ?? null;
            $resourceObj->state = $requestData['state'] ?? null;
            $resourceObj->condition = $requestData['condition'] ?? null;
            $resourceObj->mileage = $request->mileage ? str_replace(',', '', $requestData['mileage']) : "";
            $resourceObj->color = $requestData['color'] ?? null;
            // $resourceObj->exterior_color = $requestData['exterior_color'] ?? null;

            if (!empty($request->car_address)) {
                $resourceObj->car_address = $requestData['car_address'] ?? "";
            }

            if (!empty($request->zip_code)) {
                $resourceObj->zip_code = $requestData['zip_code'] ?? "";
            }

            if (!empty($request->type_ios)) {
                $resourceObj->category_id = $requestData['cit'] ?? null;
            } else {
                $resourceObj->category_id = $requestData['category_id'] ?? null;
            }
            $resourceObj->title_status = $requestData['title_status'] ?? null;

            if ($resourceObj->save()) {

                if ($request->hasFile('file')) {
                                   //dd($request->file);

                    $files = uploadImages($request->file('file'), IMAGE_UPLOAD_PATH);
                    foreach ($files as $file) {
                        $giftImagesObj = new CarImage();
                        $giftImagesObj->image = $file['file_name'];
                        $giftImagesObj->user_id = $userId;
                        $giftImagesObj->car_id = $resourceObj->id;
                        $giftImagesObj->save();
                    }
                }
                // if (!empty($request->features)) {
                //     $features = explode(",", $request->features);
                //     if (!empty($features)) {
                //         foreach ($features as $feature) {
                //             $featureObjlist = Featurelist::where('id', $feature)->first();
                //             if (!empty($featureObjlist)) {
                //                 $featuresObj = new Vehiclefeature;
                //                 $featuresObj->user_id = $userId;
                //                 $featuresObj->feature_id = $featureObjlist->id;
                //                 $featuresObj->car_id = $resourceObj->id;
                //                 $featuresObj->title = $featureObjlist->title;
                //                 $featuresObj->save();
                //             }
                //         }
                //     }
                // }

                $latitude = $resourceObj->lat;
                $longitude = $resourceObj->lng;
                if ($latitude && $longitude) {
                    saveGeolocation(DB::class, 'cars', $resourceObj->id, $latitude, $longitude);
                }

                $userObj->save();
            }
            $msg = 'Home Added successfully';
            $success = true;
            $status = STATUS_OK;
            $cars = Car::where('id', $resourceObj->id)->with('carImages')->first();
           
            $response['data'] = [];

            $response['message'] = $msg;
            $response['success'] = $success;
            $response['status'] = $status;
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        // return response()->json([
        //     'status' => 'success',
        //     'data' => $cars,
        // ]);
       // return json_encode($response);
       return response()->json($response, $response['status']);
    }


    public function getSellerModalContent($sellerId)
    {
        // Get the seller data based on the $sellerId
        $seller = User::find($sellerId);

        $sellercars = Car::where('user_id',$sellerId)->get();

        // Load the view and pass the seller data to the view
        $html = View::make('user.seller-modal', ['seller' => $seller,'cars'=>$sellercars])->render();

        return response()->json(['html' => $html]);
    }

    public function updateProfile(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;


        try {
            $requestData = $request->all();
            $rules = [];
            $userId = $request->user()->id;


            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }
            $requestData = $request->all();
            $userId = $request->user()->id;
            $userObj = User::find($userId);
            $userObj->first_name = $requestData['first_name'] ?? $userObj->first_name;
            $userObj->last_name = $requestData['last_name'] ?? $userObj->last_name;
            $userObj->name = $userObj->first_name . " " . $userObj->last_name;
            $userObj->country_code = $requestData['country_code'] ?? $userObj->country_code;
            $userObj->email = $requestData['email'] ?? $userObj->email;
            $userObj->mobile = $requestData['mobile'] ?? $userObj->mobile;
            $userObj->lat = $requestData['latitude']  ??  $userObj->lat;
            $userObj->lng = $requestData['longitude']  ??  $userObj->lng;
            $userObj->description = $requestData['description'] ??  $userObj->description;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(IMAGE_UPLOAD_PATH, $fileName);
                $userObj->image = $fileName ?? $userObj->image;
            }


            if ($userObj->save()) {
                $latitude = $requestData['latitude']  ?? NULL;
                $longitude = $requestData['longitude']  ?? NULL;

                if ($latitude && $longitude) {
                    saveGeolocation(DB::class, 'users', $userObj->id, $latitude, $longitude);
                }
            }

            //============= address===========

            $address = Address::where('user_id', $userId)->first();
            if (!$address) {
                $address = new Address;
                $address->user_id = $userObj->id;
            }
            $address->address1 = $requestData['address1'] ?? $address->address1;
            $address->address2 = $requestData['address2'] ?? $address->address2;
            $address->city = $requestData['city'] ?? $address->city;
            $address->state = $requestData['state'] ?? $address->state;
            $address->country = $requestData['country'] ?? $address->country;
            $address->zip = $requestData['zip'] ?? $address->zip;
            $address->lat = $requestData['latitude']  ?? $address->lat;
            $address->lng = $requestData['longitude'] ??  $address->lng;
            if ($address->save()) {
                // Save point
                $latitude = $requestData['latitude'] ?? NULL;
                $longitude = $requestData['longitude']  ?? NULL;

                if ($latitude && $longitude) {
                    saveGeolocation(DB::class, 'addresses', $address->id, $latitude, $longitude);
                    saveGeolocation(DB::class, 'addresses', $address->user_id, $latitude, $longitude);
                }
            }
            $userData = User::where('id', $userId)->with('userAddress')->first();
            $response['data'] =  $userData;
            $response['message'] = __("message.PROFILE_UPDATED_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }


    public function soldCar(Request $request)
    {
        try {

            $user_id = Auth::user()->id;
            $rules = [
                'car_id' => 'required', // 'sold_date' => 'required|date_format:Y-m-d'
            ];

            // validate input data
            

            $carData = [];
            $carData = Car::where('id', $request->car_id)->where('user_id', $user_id)->first();
            if (!empty($carData)) {

                if($carData->sold_at){
                    $carData->sold_at= null;
                }else{
                    $carData->sold_at = date('Y-m-d');

                }
                $carData->save();
            }

            $response['message'] = __("message.SOLD_SUCCESS");
            $response['success'] = true;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw ($e);
        }

        return response()->json($response, $response['status']);
    }

    public function carDelete(Request $request)
    {
        $response = [];
        $response['success'] = false;

        try {
            $requestData = $request->all();
            $userId = $request->user()->id ?? 0;;

            $carIds = Car::where('id', $requestData['car_id'])->pluck('id');
            $carImageIds = CarImage::whereIn('car_id', $carIds)->forceDelete();
                     $carObj = Car::where('id', $carIds)->forceDelete();


            $response['message'] = __("message.CAR_DELETED_SUCCESSFULLY");
            $response['success'] = true;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }
        DB::commit();
        return response()->json($response, $response['status']);
    }

}
