<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\GoCarHubException;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Carmaster;
use App\Models\Category;
use App\Models\Featurelist;
use App\Models\Notification;
use App\Models\SearchLog;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Usercountcar;
use App\Models\Vehiclefeature;
use App\Models\CarSearchResult;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Telescope\Telescope;

use App\Library\PushNotification;


class CarController extends Controller
{
    public function AddCars(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        error_log(print_r($request->all(), true));
        DB::beginTransaction();
        try {
            $rules = ['model' => 'required', 'make' => 'required', 'year' => 'required', 'car_address' => 'required',];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }
            $requestData = $request->all();
            $userId = $request->user()->id ?? 0;;
            $userObj = User::find($userId);

            if (isset($requestData['vehicle_companies_id']) && $requestData['vehicle_companies_id'] != null && $requestData['vehicle_companies_id'] != "") {
                $vehicle_companies_id = $requestData['vehicle_companies_id'];
            }
            if (isset($requestData['vehicle_companies']) && $requestData['vehicle_companies'] != null && $requestData['vehicle_companies'] != "") {
                $vehicle_companies_id = $requestData['vehicle_companies'];
            }

            if (isset($requestData['vehicle_models_id']) && $requestData['vehicle_models_id'] != null && $requestData['vehicle_models_id'] != "") {
                $vehicle_models_id = $requestData['vehicle_models_id'];
            }
            if (isset($requestData['vehicle_models']) && $requestData['vehicle_models'] != null && $requestData['vehicle_models'] != "") {
                $vehicle_models_id = $requestData['vehicle_models'];
            }


            $currentDate = Carbon::now()->format('Y-m-d');
            $userObj = User::find($userId);
            if (($userObj->subscription_post_count > 0 && $userObj->subscription_expiry_date >= $currentDate) || ($userObj->is_free_trail == true)) {
                $resourceObj = new Car;
                $resourceObj->user_id = $userId;

                $resourceObj->year = $requestData['year'] ?? "";
                $resourceObj->make = $requestData['make'] ?? "";
                $resourceObj->model = $requestData['model'] ?? "";
                $resourceObj->registration_number = $requestData['registration_number'] ?? null;
                $resourceObj->engine_number = $requestData['engine_number'] ?? null;
                $resourceObj->meter_reading = $requestData['meter_reading'] ?? null;
                $resourceObj->car_fuel_type = $requestData['car_fuel_type'] ?? null;
                $resourceObj->car_number_plate = $requestData['car_number_plate'] ?? null;
                $resourceObj->engine_size = $requestData['engine_size'] ?? null;
                $resourceObj->amount = $request->amount ? str_replace(',', '', $requestData['amount']) : 0.00;
                $resourceObj->description = $requestData['description'] ?? null;
                // $resourceObj->car_type = $request->car_type ? $request->car_type:"shipping";

                $findme = $requestData['find_me_buyer'];

                if ($findme == 'false' || $findme == 'False') {
                    $findme = false;
                }
                $resourceObj->find_me_buyer = $requestData['find_me_buyer'] ? $findme : false;
                $resourceObj->post_ad_number = generate_string(''); // uniqid('post_', true);

                $resourceObj->lat = $requestData['lat'] ?? ($requestData['latitude'] ?? '26.1128562');
                $resourceObj->lng = $requestData['lng'] ?? ($requestData['longitude'] ?? '-80.1426190');
                $resourceObj->city = $requestData['city'] ?? null;
                $resourceObj->state = $requestData['state'] ?? null;
                $resourceObj->condition = $requestData['condition'] ?? null;
                $resourceObj->mileage = $request->mileage ? str_replace(',', '', $requestData['mileage']) : "";
                $resourceObj->color = $requestData['color'] ?? null;
                $resourceObj->exterior_color = $requestData['exterior_color'] ?? null;

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
                        $files = uploadImages($request->file('file'), IMAGE_UPLOAD_PATH);
                        foreach ($files as $file) {
                            $giftImagesObj = new CarImage;
                            $giftImagesObj->image = $file['file_name'];
                            $giftImagesObj->user_id = $userId;
                            $giftImagesObj->car_id = $resourceObj->id;
                            $giftImagesObj->save();
                        }
                    }
                    if (!empty($request->features)) {
                        $features = explode(",", $request->features);
                        if (!empty($features)) {
                            foreach ($features as $feature) {
                                $featureObjlist = Featurelist::where('id', $feature)->first();
                                if (!empty($featureObjlist)) {
                                    $featuresObj = new Vehiclefeature;
                                    $featuresObj->user_id = $userId;
                                    $featuresObj->feature_id = $featureObjlist->id;
                                    $featuresObj->car_id = $resourceObj->id;
                                    $featuresObj->title = $featureObjlist->title;
                                    $featuresObj->save();
                                }
                            }
                        }
                    }

                    $latitude = $resourceObj->lat;
                    $longitude = $resourceObj->lng;
                    if ($latitude && $longitude) {
                        saveGeolocation(DB::class, 'cars', $resourceObj->id, $latitude, $longitude);
                    }
                    $userObj->subscription_post_count = ($userObj->subscription_post_count - 1);

                    $userObj->save();
                }
                $msg = __("message.CAR_ADDED_SUCCESSFULLY");
                $success = true;
                $status = STATUS_OK;
                $cars = Car::where('id', $resourceObj->id)->with('VehicleModel', 'carImages', 'vehiclefeatures')->first();
                $cars->vehicle_new = $cars->myvechicleFeatures();
                $userdata = User::where('id', $resourceObj->user_id)->select('id', 'name', 'image')->first();
                $resourceObj1 = Featurelist::where('parent_id', 0)->get();

                $data = [];
                if (!$resourceObj1->isEmpty()) {
                    foreach ($resourceObj1 as $obj) {
                        $childern = $obj->getChildern($cars->id);

                        $obj->children = $childern;

                        $data[] = $obj;
                    }
                }
                $cars->vehicle_list = $data;
                $userdata->car_details = $cars;
                $response['data'] = $userdata;
            } elseif ($userObj->subscription_post_count == 0 && $userObj->subscription_expiry_date < $currentDate) {
                $userObj->is_subscription = false ?? true;
                $userObj->save();
                $msg = "2";
                $success = false;
                $status = UNPROCESSABLE_ENTITY;
                DB::rollback();
            } elseif ($userObj->subscription_post_count == 0 && $userObj->subscription_expiry_date > $currentDate) {
                $userObj->is_subscription = false ?? true;
                $userObj->save();
                $success = false;
                $msg = "3";
                $status = UNPROCESSABLE_ENTITY;
                DB::rollback();
            } elseif ($userObj->subscription_post_count > 0 && $userObj->subscription_expiry_date < $currentDate) {
                $userObj->is_subscription = false ?? true;
                $userObj->save();
                $success = false;
                $msg = "4";
                $status = UNPROCESSABLE_ENTITY;
                DB::rollback();
            } elseif ($userObj->free_trail_expiry_date < $currentDate) {
                $success = false;
                $msg = "5";
                $status = UNPROCESSABLE_ENTITY;
                DB::rollback();
            }
            $response['message'] = $msg;
            // $response['message_1'] =  $msg;
            $response['success'] = $success;
            $response['status'] = $status;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        return response()->json($response, $response['status']);
    }

    public function vehicleFeature(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        error_log(print_r($request->all(), true));
        DB::beginTransaction();
        try {

            $rules = [];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }
            $requestData = $request->all();
            $userId = $request->user()->id ?? 0;;

            $carObj = Car::find($requestData['car_id']);

            $features = $requestData['features'] ?? [];
            foreach ($features as $feature) {
                $featureObj = Featurelist::where('title', $feature['title'])->first();
                if ($featureObj) {
                    $subFeatures = $feature['sub_features'] ?? [];
                    foreach ($subFeatures as $subFeature) {
                        $featuresObj = new Vehiclefeature;
                        $featuresObj->user_id = $userId;
                        $featuresObj->feature_id = $featureObj->id;
                        $featuresObj->car_id = $carObj->id;
                        $featuresObj->title = $subFeature['title'];
                        $featuresObj->save();
                    }
                }
            }

            DB::commit();
            $response['data'] = Car::where('id', $carObj->id)->with('vehicleFeatures')->first();
            $response['message'] = __("message.FEATURE_ADDED_SUCCESSFULLY");
            $response['success'] = true;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        return response()->json($response, $response['status']);
    }

    public function vehicleFeatureUpdate(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $userId = $request->user()->id ?? 0;;
            $requestData = $request->all();

            if (isset($requestData['sub_features_id']) && !empty($requestData['sub_features_id'])) {
                $subFeatureIds = $requestData['sub_features_id'] ?? [];
                foreach ($subFeatureIds as $subFeatureId) {
                    if (Vehiclefeature::where('id', $subFeatureId)->exists()) {
                        Vehiclefeature::where('id', $subFeatureId)->delete();
                    }
                }
            }

            $features = $requestData['features'] ?? [];
            $carObj = Car::find($requestData['car_id']);
            $featuredelete = [];
            foreach ($features as $feature) {
                $featureObj = Featurelist::where('title', $feature['title'])->first();
                if ($featureObj) {
                    $subFeatures = $feature['sub_features'] ?? [];
                    foreach ($subFeatures as $subFeature) {
                        $id = $subFeature['sub_features_id'] ?? [];
                        $featuredelete[] = $id;
                        $featuresObj = Vehiclefeature::where('feature_id', $id)->first();
                        if (!$featuresObj) {
                            $featuresObj = new Vehiclefeature;
                            $featuresObj->user_id = $userId;
                        }
                        $featuresObj->feature_id = $featureObj->id;
                        $featuresObj->car_id = $carObj->id;
                        $featuresObj->title = $subFeature['title'];
                        $featuresObj->save();
                    }
                }
            }

            $response['data'] = Car::find($requestData['car_id'])->with('vehicleFeatures')->latest();
            $response['message'] = __("message.CAR_UPDATED_FEATURE_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }
        return response()->json($response, $response['status']);
    }

    public function updateCar(Request $request)
    {
        $response = [];
        $response['success'] = false;

        try {
            $requestData = $request->all();

            $rules = [];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }

            $userId = $request->user()->id ?? 0;;
            $userObj = User::find($userId);
            $carObj = Car::where('user_id', $userId)->where('id', $requestData['car_id'])->first();

            if (!isset($requestData['car_id']) && $requestData['car_id'] == null && $requestData['car_id'] == "") {
                $response['message'] = "car_id is null";
                return response()->json($response, $response['status']);
            }

            if (empty($carObj)) {
                $response['message'] = "Car not found !";
                return response()->json($response, $response['status']);
            }

            $usid = Auth::user()->id;

            $resourceObj = Car::find($requestData['car_id']);
            $resourceObj->user_id = $request->user()->id;
            $resourceObj->vehicle_companies_id = $requestData['vehicle_companies_id'] ?? $resourceObj->vehicle_companies_id;
            $resourceObj->vehicle_models_id = $requestData['vehicle_models_id'] ?? $resourceObj->vehicle_models_id;
            $resourceObj->year = $requestData['year'] ?? $resourceObj->year;
            $resourceObj->model = $requestData['model'] ?? $resourceObj->model;
            $resourceObj->make = $requestData['make'] ?? $resourceObj->make;
            $resourceObj->registration_number = $requestData['registration_number'] ?? $resourceObj->registration_number;
            $resourceObj->engine_number = $requestData['engine_number'] ?? $resourceObj->engine_number;
            $resourceObj->meter_reading = $requestData['meter_reading'] ?? $resourceObj->meter_reading;
            $resourceObj->car_fuel_type = $requestData['car_fuel_type'] ?? $resourceObj->car_fuel_type;
            $resourceObj->car_number_plate = $requestData['car_number_plate'] ?? $resourceObj->car_number_plate;
            $resourceObj->engine_size = $requestData['engine_size'] ?? $resourceObj->engine_size;
            $resourceObj->amount = $request->amount ? str_replace(',', '', $requestData['amount']) : $resourceObj->amount;
            $resourceObj->description = $requestData['description'] ?? $resourceObj->description;
            // $resourceObj->car_type = $requestData['car_type'] ?? $resourceObj->car_type;

            $findme = $requestData['find_me_buyer'];

            if ($findme == 'false' || $findme == 'False') {
                $findme = false;
            }
            //  dd($findme);
            $resourceObj->find_me_buyer = $requestData['find_me_buyer'] ? $findme : $resourceObj->find_me_buyer;
            $resourceObj->lat = $requestData['latitude'] ?? $resourceObj->lat;
            $resourceObj->lng = $requestData['longitude'] ?? $resourceObj->lng;
            $resourceObj->city = $requestData['city'] ?? $resourceObj->city;
            $resourceObj->state = $requestData['state'] ?? $resourceObj->state;
            $resourceObj->condition = $requestData['condition'] ?? $resourceObj->condition;
            $resourceObj->mileage = $request->mileage ? str_replace(',', '', $requestData['mileage']) : $resourceObj->mileage;
            $resourceObj->color = $requestData['color'] ?? $resourceObj->color;
            $resourceObj->title_status = $requestData['title_status'] ?? $resourceObj->title_status;
            $resourceObj->exterior_color = $requestData['exterior_color'] ?? $resourceObj->exterior_color;
            //  $resourceObj->category_id = $requestData['category_id'] ?? $resourceObj->category_id;

            if (!empty($request->car_address)) {
                $resourceObj->car_address = $requestData['car_address'] ? $requestData['car_address'] : $resourceObj->car_address;
            }

            if (!empty($request->zip_code)) {
                $resourceObj->zip_code = $requestData['zip_code'] ? $requestData['zip_code'] : $resourceObj->zip_code;
            }


            if (!empty($request->type_ios)) {
                $resourceObj->category_id = $requestData['cit'] ?? $resourceObj->category_id;
            } else {
                $resourceObj->category_id = $requestData['category_id'] ?? $resourceObj->category_id;
            }


            if ($resourceObj->save()) {
                $imageIds = $requestData['image_id'] ?? [];
                if (!is_array($imageIds)) {
                    $imageIds = str_replace('"', '', $imageIds);
                    $imageIds = explode(',', $imageIds);
                    //$imageIds = array_filter($imageIds);
                }

                if (count($imageIds) > 0) {
                    CarImage::whereIn('id', $imageIds)->delete();
                }

                if ($request->hasFile('file')) {
                    $files = uploadImages($request->file('file'), IMAGE_UPLOAD_PATH);
                    foreach ($files as $file) {
                        $giftimagesOBj = new CarImage;
                        $giftimagesOBj->image = $file['file_name'];
                        $giftimagesOBj->user_id = $userId;
                        $giftimagesOBj->car_id = $resourceObj->id;
                        $giftimagesOBj->save();
                    }
                }

                $latitude = $requestData['latitude'] ?? NULL;
                $longitude = $requestData['longitude'] ?? NULL;
                if ($latitude && $longitude) {
                    saveGeolocation(DB::class, 'cars', $resourceObj->id, $latitude, $longitude);
                }
            }

            if (!empty($request->features)) {

                $features = explode(",", $request->features);

                if (!empty($features)) {


                    $de = Vehiclefeature::where('car_id', $resourceObj->id)->delete();
                    foreach ($features as $feature) {

                        $featureObjlist = Featurelist::where('id', $feature)->first();

                        if (!empty($featureObjlist)) {
                            $featuresObj = new Vehiclefeature;
                            $featuresObj->user_id = $userId;
                            $featuresObj->feature_id = $featureObjlist->id;
                            $featuresObj->car_id = $resourceObj->id;
                            $featuresObj->title = $featureObjlist->title;
                            $featuresObj->save();
                        }
                    }
                }
            }

            DB::commit();
            $userObj = User::where('id', $resourceObj->user_id)->select('id', 'name', 'image')->first();
            $cars = Car::where('id', $request->car_id)->with('VehicleModel', 'carImages', 'vehiclefeatures')->first();

            $data = [];

            $resourceObj1 = Featurelist::where('parent_id', 0)->get();

            if (!$resourceObj1->isEmpty()) {
                foreach ($resourceObj1 as $obj) {
                    $childern = $obj->getChildern($cars->id);

                    $obj->children = $childern;

                    $data[] = $obj;
                }
            }
            // $featureObj = Featurelist::whereIn('id', $featureIds)->with(['vehicleFeatures' => function ($query) use ($ids, $user_id) {
            //     $query->whereIn('id', $ids)->where('user_id', $user_id);
            // }])->get();


            $cars->vehicle_list = $data;


            $cars->vehicle_new = $cars->myvechicleFeatures();

            $userObj->car_details = $cars;
            $response['data'] = $userObj;
            $response['message'] = __("message.CAR_UPDATED_SUCCESSFULLY");
            $response['success'] = true;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
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
            $vehicleFeaturesIds = Vehiclefeature::whereIn('car_id', $carIds)->forceDelete();
            $userCountIds = Usercountcar::whereIn('car_id', $carIds)->forceDelete();
            $notificationCarIds = Notification::whereIn('car_id', $carIds)->forceDelete();
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

    public function getall(Request $request)
    {
        $rules = ['type' => 'nullable|in:SELL,BUY', 'page' => 'nullable|integer|min:1'];
        GoCarHubException::assertValidation($request->all(), $rules);
        $response = [];
        $response['success'] = false;
        //recent_first//closest_first//price_lh//price_hl//model_newest//mileage_lowest
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
        $userId = Auth::id() ?? 0;
        $userObj = User::find($userId);
        $lat = $requestData['latitude'] ?? NULL;
        $lng = $requestData['longitude'] ?? NULL;
        $carObj = Car::select(["id", "amount", "created_at", "make", "model", "average_rating", "zip_code", "ratings_count", "average_rating", "user_count", "find_me_buyer"])
            ->where(function ($query) {
                $sevenDaysBackDate = Carbon::now()->subDays(7)->format('Y-m-d');
                $query->whereNull('sold_at')
                    ->orWhere('sold_at', '>=', $sevenDaysBackDate);
            });

        if ($request->car_type == "pickup") {
            $carObj = $carObj->where('car_type', 'pickup');
        } else if ($request->car_type == "shipping") {
            $carObj = $carObj->where('car_type', 'shipping');
        }

        if (isset($requestData['search_term']) && $requestData['search_term'] != '') {
            $filter->put('search_term', $request->search_term);
            $lower = strtolower($request->search_term);
            $queryParts = explode(" ", $lower);
            $carObj = $carObj->where(function ($query) use ($queryParts) {
                foreach ($queryParts as $searchTerm) {
                    $bindings = [$searchTerm, 2];
                    $query->where('year', 'ilike', "%{$searchTerm}%")
                        ->orWhere('engine_size', 'ilike', "%{$searchTerm}%")
                        ->orWhere('car_type', 'ilike', "%{$searchTerm}%")
                        ->orWhere('car_fuel_type', 'ilike', "%{$searchTerm}%")
                        ->orWhere('car_number_plate', 'ilike', "%{$searchTerm}%")
                        ->orWhere('color', 'ilike', "%{$searchTerm}%")
                        ->orWhere('exterior_color', 'ilike', "%{$searchTerm}%")
                        ->orWhere('make', 'ilike', "%{$searchTerm}%")
                        ->orWhere('model', 'ilike', "%{$searchTerm}%");
                    if (strlen($searchTerm) > 6) {
                        $query->orWhereRaw("levenshtein(car_type, ?) <= ?", $bindings)
                            ->orWhereRaw("levenshtein(color, ?) <= ?", $bindings)
                            ->orWhereRaw("levenshtein(exterior_color, ?) <= ?", $bindings)
                            ->orWhereRaw("levenshtein(make, ?) <= ?", $bindings);
                    }
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
            $carObj->where('amount', '>=', $request->min_price);
        }
        if (isset($requestData['max_price']) && $requestData['max_price'] != '') {
            $filter->put('max_price', $request->max_price);
            $carObj->where('amount', '<=', $request->max_price);
        }
        $distanceRaw = null;
        if (isset($requestData['latitude']) && $requestData['longitude'] != '') {
            if (isset($requestData['km']) && $requestData['km'] != '') {
                $search_distance_limit = $requestData['km'];
            } else {
                $setting = Setting::where('name', 'search_distance_limit')->first();
                $search_distance_limit = $setting->value ?? 50;
                $search_distance_limit = $search_distance_limit['search_distance_limit'];
            }
            $userLat = $lat ?? $userObj->lat;
            $userLong = $lng ?? $userObj->Lng;
            $meters = ((int) $search_distance_limit * 1609); # Default 80.46 KMS, 50 Miles, 1 miles = 1.609 Kms
            $carObj->whereRaw("ST_DWithin(cars.geolocation, ST_MakePoint($userLong,$userLat),$meters)");
            $distanceRaw = "ST_Distance(cars.geolocation, ST_MakePoint($userLong,$userLat)::geography)";
        }
        if (!empty($request->sort)) {
            if ($request->sort == 'recent_first') {
                $carObj->orderBy("id", "DESC");
            } else if ($request->sort == 'closest_first') {
                if ($distanceRaw) {
                    $carObj->orderBy(DB::raw($distanceRaw), 'asc');
                }
            } else if ($request->sort == 'price_lh') {
                $carObj->orderBy("amount", "ASC");
            } else if ($request->sort == 'price_hl') {
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
        $carObj->with([
            'carImages' => function ($query) {
                $query->select('id', 'car_id', 'image');
            }
        ]);
        ini_set('memory_limit', '-1');
        $pagination = 20;
        $page = $requestData['page'] ?? 1;
        $offset = ($page - 1) * $pagination;
        if (!empty($requestData['type']) && $requestData['type'] == "SELL") {
            $cars = $carObj->where('user_id', $userId)
                ->limit($pagination)
                ->offset($offset)
                ->get();
            $response['sellerObj'] = $cars;
        } else { //BUY
            $cars = $carObj->where('user_id', '!=', $userId)
                ->limit($pagination)
                ->offset($offset)
                ->get();
            $response['buyerObj'] = $cars;
        }
        @$this->saveRequestLog($filter, $request, $cars);
        $response['filter'] = $filter;
        $response['message'] = __("message.CAR_FETCH_SUCCESSFULLY");
        $response['success'] = true;
        $response['status'] = STATUS_OK;
        return response()->json($response, $response['status']);
    }

    /**
     * @param \Illuminate\Support\Collection $filter
     * @param Request $request
     * @param \Illuminate\Support\Collection $response
     * @return void
     */
    public function saveRequestLog(\Illuminate\Support\Collection $filter, Request $request, \Illuminate\Support\Collection $response): void
    {
        $userId = Auth::id() ?? -1;
        //  saving for find me buyer seller side
        if (($filter['make'] != "" || $filter['model'] != "" || $filter['year'] != "") && (!empty($userId) && $userId != -1)) {
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $searchlog = new SearchLog();
            $searchlog->user_id = Auth::id();
            $searchlog->search = json_encode($filter);
            $searchlog->lat = $latitude;
            $searchlog->lng = $longitude;
            if ($latitude && $longitude) {
                $searchlog->geolocation = DB::raw("ST_MakePoint($longitude, $latitude)");
            }
            $searchlog->save();
        }

    }

    public function getCarSearchUsers(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['message'] = __("message.NO_USER_SEARCH_CAR");
        $response['status'] = STATUS_OK;
        $userId = $request->user()->id ?? 0;;
        $requestData = $request->all();
        $carId = (int) $request->car_id;
        $carObj = Car::where('id', $carId)->first();
        $userIds = [];
        if (!empty($carObj)) {
            $lat = $carObj->lat;
            $lng = $carObj->lng;
            if (isset($lat) && isset($lng)) {
                $search_distance_limit = 50;
                $km = 1.609;
                $kms = ((int) $search_distance_limit * $km); # Default 80.46 KMS, 50 Miles, 1 miles = 1.609 Kms
                $userQuery = SearchLog::selectRaw("search_log.*");
                $userQuery->selectRaw('*, search_log.created_at AS created_time, search_log.updated_at AS updated_time, ST_Distance(search_log.geolocation, ST_MakePoint(?,?)::geography) AS distance', [$lng, $lat])->whereRaw("ST_Distance(search_log.geolocation, ST_MakePoint($lng,$lat)::geography) < " . $kms * 1000)
                    ->orderByRaw('distance ASC');
                $userObjs = $userQuery->whereIn('search->year', [$carObj->year, $carObj->year - 1, $carObj->year + 1])->where('search->make', '=', $carObj->make)->where('search->model', '=', $carObj->model)
                    ->where('created_at', '>=', now()->subDays(3))
                    ->get();
                $userIds = $userObjs->pluck('user_id');
            }
        }
        $resourceObj = User::where('id', '!=', $userId)->where('user_type', '!=', 'admin')->whereIn('id', $userIds)->with('userAddress')->limit(10);
        $resourceObj = $resourceObj->get();
        if (!$resourceObj->isEmpty()) {
            $response['success'] = TRUE;
            $response['message'] = __("message.FETCH_DATA");
        }

        $response['data'] = $resourceObj;

        return response()->json($response, $response['status']);
    }

    public function getcategory(Request $request)
    {
        $response = [];

        $resourceObj = Category::orderBy('order', 'asc')->get();
        $response['data'] = $resourceObj;
        $response['message'] = __("message.CAR_CATEGORY_FETCH_SUCCESSFULLY");
        $response['success'] = true;
        $response['status'] = STATUS_OK;

        return response()->json($response, $response['status']);
    }

    public function carDetails(Request $request)
    {
        $response = [];
        $response['success'] = false;

        try {
            $requestData = $request->all();
            $userId = $request->user()->id ?? 0;;
            $resourceObj = Car::where(['id' => $requestData['car_id']])->with('VehicleModel', 'cars_images', 'vehiclefeatures', 'user_details', 'category')->latest()->first();
            $resourceObj1 = Featurelist::where('parent_id', 0)->get();
            $data = [];

            if (!empty($resourceObj)) {
                if (!$resourceObj1->isEmpty()) {
                    foreach ($resourceObj1 as $obj) {
                        $childern = $obj->getChildern($resourceObj->id);

                        $obj->children = $childern;

                        $data[] = $obj;
                    }
                }
            }
            $resourceObj->vehicle_list = $data;
            $resourceObj->vehicle_new = $resourceObj->myvechicleFeatures();
            if(!empty($userId) && $userId != 0) {
                $userVisitCount = Usercountcar::where([
                    'user_id' => $userId,
                    'car_id'  => $requestData['car_id']
                ])->first();
                if (!$userVisitCount) {

                    if (empty($check)) {
                        $userVisitCount = new Usercountcar;
                        $userVisitCount->user_id = $userId;
                        $userVisitCount->car_id = $requestData['car_id'];
                        $userVisitCount->save();
                    }
                }
            }
            $response['data'] = $resourceObj;
            $response['message'] = __("message.CAR_FETCH_SUCCESSFULLY");
            $response['success'] = true;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }

    public function userCarCount(Request $request)
    {
        $response = [];
        $response['success'] = false;

        try {
            $rules = ['car_id' => 'required|Exists:cars,id',];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }

            $requestData = $request->all();
            $userId = $request->user()->id ?? 0;;
            $userObj = User::find($userId);

            $check = Car::where('id', $request->car_id)->where('user_id', $userId)->first();

            $resourceObj = Usercountcar::where(['user_id' => $userId, 'car_id' => $requestData['car_id']])->first();
            if (!$resourceObj) {

                if (empty($check)) {
                    $resourceObj = new Usercountcar;
                    $resourceObj->user_id = $userId;
                    $resourceObj->car_id = $requestData['car_id'];
                    $resourceObj->save();
                }
            }
            $resourceObj = Usercountcar::where('car_id', $request->car_id)->count();
            //  $response['data'] =  $resourceObj;
            $response['message'] = __("message.CAR_FETCH_SUCCESSFULLY");
            $response['success'] = true;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }
        return response()->json($response, $response['status']);
    }

    public function getsubscription(Request $request)
    {
        $response = [];
        $response['success'] = false;
        try {
            $requestData = $request->all();
            $userId = $request->user()->id ?? 0;;
            $resourceObj = Subscription::orderBy('id', 'asc')->get();
            $response['data'] = $resourceObj;
            $response['message'] = __("message.SUBSCRIPTION_FETCH_SUCCESSFULLY");
            $response['success'] = true;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }

    public function getBuyerCars(Request $request): JsonResponse
    {
        $response = [];
        $requestData = $request->all();

        $carObj = Car::select(["id", "amount", "created_at", "make", "model", "average_rating", "zip_code", "ratings_count", "average_rating", "user_count", "find_me_buyer"])
            ->where(function ($query) {
                $sevenDaysBackDate = Carbon::now()->subDays(7)->format('Y-m-d');
                $query->whereNull('sold_at')
                    ->orWhere('sold_at', '>=', $sevenDaysBackDate);
            });

        $carObj->orderBy('id', 'DESC');
        $carObj->with([
            'carImages' => function ($query) {
                $query->select('id', 'car_id', 'image');
            }
        ]);
        ini_set('memory_limit', '-1');
        $pagination = 20;
        $page = $requestData['page'] ?? 1;
        $offset = ($page - 1) * $pagination;
        $cars = $carObj->where('user_id', $requestData['user_id'])
            ->limit($pagination)
            ->offset($offset)
            ->get();
        $response['sellerObj'] = $cars;
        $response['message'] = __("message.CAR_FETCH_SUCCESSFULLY");
        $response['success'] = true;
        $response['status'] = STATUS_OK;
        return response()->json($response, $response['status']);
    }

    public function getfeatureslist(Request $request)
    {
        $response = [];
        $response['success'] = false;

        $carId = $request->car_id ? $request->car_id : "";

        try {
            $requestData = $request->all();
            $userId = $request->user()->id ?? 0;;
            $resourceObj = Featurelist::where('parent_id', 0)->get();

            $data = [];
            if (!$resourceObj->isEmpty()) {
                foreach ($resourceObj as $obj) {
                    $childern = $obj->getChildern($carId);

                    $obj->children = $childern;

                    $data[] = $obj;
                }
            }
            $response['data'] = $data;
            $response['message'] = __("message.CAR_FEATURES_FETCH_SUCCESSFULLY");
            $response['success'] = true;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }

    public function getyear(Request $request)
    {
        $response = [];
        $response['success'] = false;
        $requestData = $request->all();
        $userId = $request->user()->id ?? 0;
        $min = Carmaster::min('year_from');
        $max = Carmaster::max('year_from');
        $years = range($min, $max);

        $collection = new Collection();
        foreach ($years as $item) {
            $collection->push((object) [
                'year' => $item

            ]);
        }
        $response['data'] = $collection;
        $response['message'] = __("message.CAR_YEAR_FETCH_SUCCESSFULLY");
        $response['success'] = true;
        $response['status'] = STATUS_OK;

        return response()->json($response, $response['status']);
    }

    public function getVehicleCompany(Request $request)
    {
        $response = [];
        $response['success'] = false;
        $year = $request->year;
        $rules = ['year' => 'required',];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorResponse = validation_error_response($validator->errors()->toArray());
            return $errorResponse;
        }
        $response['data'] = Carmaster::groupBy('make')->where('year_from', '<=', $year)->where('year_to', '>=', $year)->select('make')->orderBy('make', 'asc')->get();
        $response['message'] = __("message.CAR_MAKE_FETCH_SUCCESSFULLY");
        $response['success'] = true;
        $response['status'] = STATUS_OK;
        return response()->json($response, $response['status']);
    }

    // api for get vechil trim

    public function getVehicleModel(Request $request)
    {
        $response = [];
        $response['success'] = false;

        try {

            $year = $request->year;

            $rules = ['year' => 'required', 'make' => 'required',];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }
            $requestData = $request->all();
            $userId = $request->user()->id ?? 0;;
            $response['data'] = Carmaster::groupBy('model')->where('year_from', '<=', $year)->where('year_to', '>=', $year)->where('make', $request->make)->select('model')->orderBy('model', 'asc')->get();
            $response['message'] = __("message.CAR_MODEL_FETCH_SUCCESSFULLY");
            $response['success'] = true;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw $e;
        }
        return response()->json($response, $response['status']);
    }

    // sold car

    public function getVehicleTrim(Request $request)
    {
        $response = [];
        $response['success'] = false;

        try {

            $year = $request->year;

            $rules = ['year' => 'required', 'make' => 'required', 'model' => 'required',];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }
            $requestData = $request->all();
            $userId = $request->user()->id ?? 0;
            $response['data'] = Carmaster::groupBy('vehicle_trim', 'series', 'drive_wheels')->where('year_from', '<=', $year)->where('year_to', '>=', $year)->where('make', $request->make)->where('model', $request->model)->select([DB::raw("CONCAT(series,' ',vehicle_trim,' ',drive_wheels)  AS vehicle_trim")])->orderBy('vehicle_trim', 'asc')->get();
            $response['message'] = __("message.CAR_TRIM_FETCH_SUCCESSFULLY");
            $response['success'] = true;
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
            GoCarHubException::assertValidation($request->all(), $rules);

            $carData = [];
            $carData = Car::where('id', $request->car_id)->where('user_id', $user_id)->first();
            if (!empty($carData)) {
                $carData->sold_at = date('Y-m-d');
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

    // send  notification to buyers after search request
    public function sendNotifictonToBuyer(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $rules = [
                // 'make' => 'required', 
                // 'model' => 'required', 
            ];
            // validate input data
            GoCarHubException::assertValidation($request->all(), $rules);
            $userId = $request->user()->id ?? 0;;
            $userObj = User::find($userId);
            $lat = $request->latitude;
            $lng = $request->longitude;
            $carObj = Car::select(["id", "lat", "lng", "user_id", "make", "model","amount","year"])
            ->with('sellerDetails:id,name,image,mobile')
            ->with('carImageSingle')
            ->where(function ($query) {
                $sevenDaysBackDate = Carbon::now()->subDays(7)->format('Y-m-d');
                $query->whereNull('sold_at')
                    ->orWhere('sold_at', '>=', $sevenDaysBackDate);
            });
        
        if ($request->model) {
            $carObj->where('model', $request->model);
        }
        
        if ($request->make) {
            $carObj->where('make', $request->make);
        }

        if ($request->year) {
            $year = (int) $request->year;
            $carObj->whereIn('year', [$year - 1, $year, $year + 1]);
        }

       
        

        if ($request->latitude && $request->longitude) {
            $searchDistanceLimit = 500; // 50 miles
            $distance = (int) ($searchDistanceLimit * 1609.34); // Conversion from miles to meters
            
            // Divide the distance by 1000 to get the result in kilometers
            
            $carObj
            ->selectRaw("ST_Distance(cars.geolocation::geography, 'POINT(" . $lng . " " . $lat . ")'::geography) / 1000 as distance") 
            ->whereRaw("ST_DWithin(cars.geolocation::geography, 'POINT(" . $lng . " " . $lat . ")'::geography, " . $distance . ")")
            ->orderBy('distance');
        }

        // saving for car search result data or findme  buyer side

        $cars = $carObj->get();

        if(!$cars->isEmpty())
        {
            if ($request->make != "" && $request->model != "") {
                //  check if search result with same make and model
                $searchResult = CarSearchResult::where('user_id', Auth::id())->where(['model' => $request->model, 'make' => $request->make])->first();
                if (empty($searchResult)) {
                    $searchResult = new CarSearchResult();
                }
                $searchResult->user_id = Auth::id();
                $searchResult->request_data = json_encode($request->all());
                $searchResult->response = json_encode($cars);
                $searchResult->make = $request->make;
                $searchResult->model = $request->model;
                $searchResult->year = $request->year;
                $searchResult->save();

                $data = [
                    'id' =>$searchResult->id,
                    'make'=>$request->make,
                    'model' =>$request->model,
                    'year' =>$request->year,
                ];
        

                $notificationType = 'FindCars';
                $notificationMsg = __("message.WE_FIND",['make'=>$request->make,'model'=>$request->model]);
                $notificationObj = new Notification;
                $notificationObj->user_id = $userObj->id;
                $notificationObj->message = $notificationMsg;
                $notificationObj->type = $notificationType;
                $notificationObj->data = json_encode($data);

               
                if ($notificationObj->save()) {
        
                $notificationData = [
                    'title' => "Hi ".$userObj->name,
                    'message' => $notificationMsg,
                    'user_id' => $userObj->id,
                    'id' => $searchResult->id,
                    'badge' => Notification::where(['user_id' => $userObj->id, 'is_seen' => 0])->count(),
                    'send_by'=>'user',
                    'type' => 'FindCars',
                    'data' => $data
                ];
              PushNotification::send($notificationData,'yes');
        
              }
            }
        }
        $response['message'] = __("message.SENT_MESSAGE");
        $response['success'] = true;
        $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            throw ($e);
        }

        return response()->json($response, $response['status']);
    }

    // get all cars on map with car search table id

    public function getCarsOnMap(Request $request)
    {
        $user_id = Auth::user()->id;
        // search log id from notification
        $rules = [
            'id' => 'required', 
        ];
        // validate input data
        GoCarHubException::assertValidation($request->all(), $rules);
        $searchResult = CarSearchResult::where('id',$request->id)->first();
        if(!empty($searchResult)){
            $response['data'] =  isset($searchResult->response) ? json_decode($searchResult->response):[];
            $response['message'] = __("message.CAR_FETCH_SUCCESSFULLY");
            $response['success'] = true;
            $response['status'] = STATUS_OK;
        }else{
            $response['data'] =  [];
            $response['message'] = __("message.CAR_NOT_EXIT");
            $response['success'] = false;
            $response['status'] = STATUS_OK;
           
        }
        return response()->json($response, $response['status']);

    }

    // Api for send push notifcation to seller when buyer click on specific car on map

    public function sendNotifictonToSeller(Request $request)
    {
        $user_id = Auth::user()->id;
        $userObj = User::find($user_id);
        // search log id from notification
        $rules = [
            'car_id' => 'required', 
        ];
        // validate input data
        GoCarHubException::assertValidation($request->all(), $rules);
        $searchResult = Car::where('id',$request->car_id)->first();
        if(!empty($searchResult))
        {
            $data = [
                'id' =>$searchResult->id,
                'user_id'=>$user_id,
                'seller' =>$searchResult->user_id,
            ];

            $sendTo = User::find($searchResult->user_id);
    
            $data['user_details'] = $userObj;


            $notificationType = 'SELLERFIND';
            $notificationMsg = $userObj->name.' '. __("message.IS_INTERSTED") .' '. $searchResult->make .' '. $searchResult->model;
            $notificationObj = new Notification;
            $notificationObj->user_id = $sendTo->id;
            $notificationObj->message = $notificationMsg;
            $notificationObj->type = $notificationType;
            $notificationObj->data = json_encode($data);


           
            if ($notificationObj->save()) {
    
                
            $notificationData = [
                'title' => "Hi ".$sendTo->name,
                'message' => $notificationMsg,
                'user_id' => $sendTo->id,
                'id' => $searchResult->id,
                'badge' => Notification::where(['user_id' => $userObj->id, 'is_seen' => 0])->count(),
                'send_by'=>'user',
                'type' => $notificationType,
                'data' => $data
            ];
            PushNotification::send($notificationData,'yes');

            }

            $response['message'] = __("message.SENT_MESSAGE");
            $response['success'] = true;
            $response['status'] = STATUS_OK;



           

        }else{
            $response['message'] = __("message.CAR_NOT_EXIT");
            $response['success'] = false;
            $response['status'] = STATUS_OK;
           
        }
        return response()->json($response, $response['status']);

    }
}



