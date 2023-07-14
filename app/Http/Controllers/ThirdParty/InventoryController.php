<?php

namespace App\Http\Controllers\ThirdParty;

use App\Exceptions\GoCarHubException;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Featurelist;
use App\Models\User;
use App\Models\Vehiclefeature;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//models


class InventoryController extends Controller
{
    protected $dealer_id = [];
    protected $userObject;
    protected $permission = []; // 1 = 'insert', 2 = 'update', 3 = 'delete'


    //get dealer ids data

    /**
     * @throws Exception
     */
    public function getDealerList(Request $request): JsonResponse
    {
        try {

            $this->getDealerIds($request);

            $userData = [];
            if ($this->dealer_id) {
                $userData = User::select('id', 'name', 'email', 'image')->whereIn('id', $this->dealer_id)->get();
                foreach ($userData as &$value) {
                    $value->setAppends([]);
                }
            }
            return successReturn($userData, __("message.DEALER_FETCHED"), false);
        } catch (Exception $e) {
            throw ($e);
        }
    }

    //get dealer list

    /**
     * @throws GoCarHubException
     */
    public function getDealerIds($request)
    {
        // get user details
        $this->userObject = User::find($request->user()->id);

        //convert permission to array
        $this->permission = explode(',', $this->userObject->permission);

        // get dealer id
        if ($this->userObject->user_type == 'agent') {
            if ($request->dealer_id) {
                $rules = ['dealer_id' => 'comma_separated_number'];
                // validate input data
                GoCarHubException::assertValidation($request->all(), $rules);
                $this->dealer_id = User::where('agent_id', $request->user()->id)->whereIn('id', array_filter(explode(',', $request->dealer_id)))->pluck('id');
            } else {
                $this->dealer_id = User::where('agent_id', $request->user()->id)->pluck('id');
            }
        } else if ($this->userObject->user_type == 'dealer') {
            //$this->dealer_id[] = $request->user()->id;
            throw new GoCarHubException(__("message.UNAUTHORIZED_ACCESS"), 401);
        } else {
            throw new GoCarHubException(__("message.UNAUTHORIZED_ACCESS"), 401);
        }
    }

    //get inventory list

    /**
     * @throws Exception
     */
    public function getInventory(Request $request): JsonResponse
    {
        try {
            $this->getDealerIds($request);

            $rules = [
                'page' => 'nullable|positive_integer',
                'limit' => 'nullable|positive_integer',
            ];

            // validate input data
            GoCarHubException::assertValidation($request->all(), $rules);

            $carData = [];
            if ($this->dealer_id) {
                $carData = Car::whereIn('user_id', $this->dealer_id)->where(function ($query) {
                    $query->whereNull('sold_at')->orWhere('sold_at', '>=', Carbon::now()->subDays(7)->format('Y-m-d'));
                })->with(['carImages', 'category', 'featureList'])->paginate(($request->limit ?? 10), ['*'], 'page', ($request->page ?? 1))->toArray();

                foreach ($carData as $key => $value) {
                    if (!in_array($key, ['data', 'per_page', 'total', 'last_page', 'current_page'])) {
                        unset($carData[$key]);
                    }
                }
            }
            return successReturn($carData, __("message.INVENTORY_FETCHED"), false);
        } catch (Exception $e) {
            throw ($e);
        }
    }


    // insert inventory

    /**
     * @throws Exception
     */
    public function insertInventory(Request $request): JsonResponse
    {
        try {

            $this->getDealerIds($request);

            //check permissions
            if (!in_array('1', $this->permission)) {
                throw new GoCarHubException(__("message.NO_PERMISSION"));
            }

            $rules = [
                'dealer_id' => 'required|positive_integer|exists:users,id,agent_id,' . $this->userObject->id,
                'year' => 'required|positive_integer|digits:4',
                'amount' => 'required|positive_decimal',
                'engine_size' => 'nullable|max:191',
                'car_type' => 'required|in:shipping,pickup|max:255',
                'description' => 'nullable',
                'find_me_buyer' => 'nullable|boolean',
                'expiry_date' => 'nullable|date_format:Y-m-d',
                // 'vehicle_companies_id' => 'nullable|positive_integer',
                // 'vehicle_models_id' => 'nullable|positive_integer',
                'registration_number' => 'nullable|max:191',
                'engine_number' => 'nullable|max:191',
                'meter_reading' => 'nullable|max:191',
                'car_fuel_type' => 'nullable|in:Gas,Diesel,Hybrid,Electric,Flex',
                'car_number_plate' => 'nullable|max:191',
                'lat' => 'nullable|latitude',
                'lng' => 'nullable|longitude',
                'city' => 'nullable|max:191',
                'state' => 'nullable|max:191',
                'condition' => 'nullable|in:New,Excellent,Very Good,Good,Fair',
                'mileage' => 'nullable|positive_integer|max:191',
                'color' => 'nullable|max:191',
                'title_status' => 'nullable|in:Clean,Rebuilt,Salvage',
                'exterior_color' => 'nullable|max:191',
                'make' => 'required|max:191',
                'model' => 'required|max:191',
                'car_address' => 'required|max:191',
                'zip_code' => 'required|max:191',
                'vin_number' => 'nullable|max:191',

                'category_id' => 'required|positive_integer|exists:categories,id',
                'features' => 'nullable|comma_separated_number',
                'images' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ];

            // validate input data
            GoCarHubException::assertValidation($request->all(), $rules, [], ['images.*' => 'images']);

            DB::beginTransaction();

            $carObject = new Car;
            $carObject->user_id = $request->dealer_id;
            $carObject->year = $request->year;
            $carObject->amount = $request->amount ?? '0.00';
            $carObject->engine_size = $request->engine_size;
            $carObject->car_type = $request->car_type;
            $carObject->description = $request->description;
            $carObject->find_me_buyer = $request->find_me_buyer ? true : false;
            $carObject->expiry_date = $request->expiry_date;
            // $carObject->vehicle_companies_id = $request->vehicle_companies_id ;
            // $carObject->vehicle_models_id = $request->vehicle_models_id ;
            $carObject->registration_number = $request->registration_number;
            $carObject->engine_number = $request->engine_number;
            $carObject->meter_reading = $request->meter_reading;
            $carObject->car_fuel_type = $request->car_fuel_type;
            $carObject->car_number_plate = $request->car_number_plate;
            $carObject->post_ad_number = generate_string('');
            $carObject->lat = $request->lat ?? '26.1128562';
            $carObject->lng = $request->lng ?? '-80.1426190';
            $carObject->city = $request->city;
            $carObject->state = $request->state;
            $carObject->condition = $request->condition;
            $carObject->mileage = $request->mileage;
            $carObject->color = $request->color;
            $carObject->title_status = $request->title_status;
            $carObject->exterior_color = $request->exterior_color;
            $carObject->category_id = $request->category_id;
            $carObject->make = $request->make;
            $carObject->model = $request->model;
            $carObject->car_address = $request->car_address;
            $carObject->zip_code = $request->zip_code;
            $carObject->vin_number = $request->vin_number;
            $carObject->created_by = 1; // 0 for app 1 for third party api
            
            if ($carObject->save()) {
                if ($carObject->lat && $carObject->lng) {
                    saveGeolocation(DB::class, 'cars', $carObject->id, $carObject->lat, $carObject->lng);
                }

                if ($request->hasFile('images')) {
                    $files = uploadImages($request->file('images'), IMAGE_UPLOAD_PATH);
                    foreach ($files as $file) {
                        $carImageObject = new CarImage;
                        $carImageObject->image = $file['file_name'];
                        $carImageObject->user_id = $request->dealer_id;
                        $carImageObject->car_id = $carObject->id;
                        $carImageObject->save();
                    }
                }

                if ($request->features) {
                    $featuresIds = explode(",", $request->features);
                    $featureListObject = Featurelist::whereIn('id', $featuresIds)->get();
                    foreach ($featureListObject as $feature) {
                        $VehiclefeatureObject = new Vehiclefeature;
                        $VehiclefeatureObject->user_id = $request->dealer_id;
                        $VehiclefeatureObject->feature_id = $feature->id;
                        $VehiclefeatureObject->car_id = $carObject->id;
                        $VehiclefeatureObject->title = $feature->title;
                        $VehiclefeatureObject->save();
                    }
                }
            }

            $carData = $carObject->load(['carImages', 'category', 'featureList']);

            return successReturn($carData, __("message.CAR_ADDED_SUCCESSFULLY"));
        } catch (Exception $e) {
            DB::rollback();
            throw ($e);
        }
    }


    // update inventory

    /**
     * @throws Exception
     */
    public function updateInventory(Request $request): JsonResponse
    {
        try {

            $this->getDealerIds($request);

            //check permissions
            if (!in_array('2', $this->permission)) {
                throw new GoCarHubException(__("message.NO_PERMISSION"));
            }

            $rules = [
                'car_id' => 'required|positive_integer|exists:cars,id',
                'dealer_id' => 'sometimes|required|positive_integer|exists:users,id,agent_id,' . $this->userObject->id,
                'year' => 'required|positive_integer|digits:4',
                'amount' => 'sometimes|required|positive_decimal',
                'engine_size' => 'nullable|max:191',
                'car_type' => 'required|in:shipping,pickup|max:255',
                'description' => 'nullable',
                'find_me_buyer' => 'nullable|boolean',
                'expiry_date' => 'nullable|date_format:Y-m-d',
                // 'vehicle_companies_id' => 'nullable|positive_integer',
                // 'vehicle_models_id' => 'nullable|positive_integer',
                'registration_number' => 'nullable|max:191',
                'engine_number' => 'nullable|max:191',
                'meter_reading' => 'nullable|max:191',
                'car_fuel_type' => 'nullable|in:Gas,Diesel,Hybrid,Electric,Flex',
                'car_number_plate' => 'nullable|max:191',
                'lat' => 'nullable|latitude',
                'lng' => 'nullable|longitude',
                'city' => 'nullable|max:191',
                'state' => 'nullable|max:191',
                'condition' => 'nullable|in:New,Excellent,Very Good,Good,Fair',
                'mileage' => 'nullable|positive_integer|max:191',
                'color' => 'nullable|max:191',
                'title_status' => 'nullable|in:Clean,Rebuilt,Salvage',
                'exterior_color' => 'nullable|max:191',
                'make' => 'required|max:191',
                'model' => 'required|max:191',
                'car_address' => 'required|max:191',
                'zip_code' => 'required|max:191',
                'vin_number' => 'nullable|max:191',

                'category_id' => 'sometimes|required|positive_integer|exists:categories,id',
                'features' => 'nullable|comma_separated_number',
                'delete_image_id' => 'nullable|comma_separated_number',
                'images' => 'sometimes|required|array',
                'images.*' => 'sometimes|required|image|mimes:jpeg,png,jpg|max:2048',
            ];

            // validate input data
            GoCarHubException::assertValidation($request->all(), $rules, [], ['images.*' => 'images']);

            DB::beginTransaction();


            $carObject = Car::where('id', $request->car_id)->whereIn('user_id', $this->dealer_id);

            if (!$carObject->count()) {
                throw new GoCarHubException(__("message.INVALID_IDS"));
            }
            $carObject = $carObject->first();
            $carObject->user_id = $request->dealer_id ?? $carObject->user_id;
            $carObject->year = $request->input('year', $carObject->year);
            $carObject->amount = $request->input('amount', $carObject->amount);
            $carObject->engine_size = $request->input('engine_size', $carObject->engine_size);
            $carObject->car_type = $request->input('car_type', $carObject->car_type);
            $carObject->description = $request->input('description', $carObject->description);
            $carObject->find_me_buyer = $request->input('find_me_buyer', $carObject->find_me_buyer) ? true : false;
            $carObject->expiry_date = $request->input('expiry_date', $carObject->expiry_date);
            // $carObject->vehicle_companies_id = $request->input('vehicle_companies_id',$carObject->vehicle_companies_id);
            // $carObject->vehicle_models_id = $request->input('vehicle_models_id',$carObject->vehicle_models_id);
            $carObject->registration_number = $request->input('registration_number', $carObject->registration_number);
            $carObject->engine_number = $request->input('engine_number', $carObject->engine_number);
            $carObject->meter_reading = $request->input('meter_reading', $carObject->meter_reading);
            $carObject->car_fuel_type = $request->input('car_fuel_type', $carObject->car_fuel_type);
            $carObject->car_number_plate = $request->input('car_number_plate', $carObject->car_number_plate);
            $carObject->post_ad_number = generate_string('');
            $carObject->lat = $request->input('lat', $carObject->lat) ?? '26.1128562';
            $carObject->lng = $request->input('lng', $carObject->lng) ?? '-80.1426190';
            $carObject->city = $request->input('city', $carObject->city);
            $carObject->state = $request->input('state', $carObject->state);
            $carObject->condition = $request->input('condition', $carObject->condition);
            $carObject->mileage = $request->input('mileage', $carObject->mileage);
            $carObject->color = $request->input('color', $carObject->color);
            $carObject->title_status = $request->input('title_status', $carObject->title_status);
            $carObject->exterior_color = $request->input('exterior_color', $carObject->exterior_color);
            $carObject->category_id = $request->input('category_id', $carObject->category_id);
            $carObject->make = $request->input('make', $carObject->make);
            $carObject->model = $request->input('model', $carObject->model);
            $carObject->car_address = $request->input('car_address', $carObject->car_address);
            $carObject->zip_code = $request->input('zip_code', $carObject->zip_code);
            $carObject->vin_number = $request->input('vin_number', $carObject->vin_number);

            if ($carObject->save()) {
                if ($carObject->lat && $carObject->lng) {
                    saveGeolocation(DB::class, 'cars', $carObject->id, $carObject->lat, $carObject->lng);
                }

                if ($request->delete_image_id) {
                    CarImage::whereIn('id', explode(',', $request->delete_image_id))->where('car_id', $carObject->id)->delete();
                }

                if ($request->hasFile('images')) {
                    $files = uploadImages($request->file('images'), IMAGE_UPLOAD_PATH);
                    foreach ($files as $file) {
                        $carImageObject = new CarImage;
                        $carImageObject->image = $file['file_name'];
                        $carImageObject->user_id = $request->dealer_id ?? $carObject->user_id;
                        $carImageObject->car_id = $carObject->id;
                        $carImageObject->save();
                    }
                }

                if ($request->has('features')) {

                    $oldFeatureId = Vehiclefeature::where('car_id', $carObject->id)->pluck('feature_id')->toArray();
                    $newFeatureId = explode(",", $request->features);

                    $deleteFeatureId = array_filter(array_diff($oldFeatureId, $newFeatureId));
                    $addFeatureId = array_filter(array_diff($newFeatureId, $oldFeatureId));

                    if ($deleteFeatureId) {
                        Vehiclefeature::where('car_id', $carObject->id)->whereIn('feature_id', $deleteFeatureId)->delete();
                    }

                    if ($addFeatureId) {
                        $featureListObject = Featurelist::whereIn('id', $addFeatureId)->get();
                        foreach ($featureListObject as $feature) {
                            $VehiclefeatureObject = new Vehiclefeature;
                            $VehiclefeatureObject->user_id = $request->dealer_id ?? $carObject->user_id;
                            $VehiclefeatureObject->feature_id = $feature->id;
                            $VehiclefeatureObject->car_id = $carObject->id;
                            $VehiclefeatureObject->title = $feature->title;
                            $VehiclefeatureObject->save();
                        }
                    }

                }
            }

            $carData = $carObject->load(['carImages', 'category', 'featureList']);

            return successReturn($carData, __("message.CAR_UPDATED_SUCCESSFULLY"));
        } catch (Exception $e) {
            DB::rollback();
            throw ($e);
        }
    }



    // update inventory

    /**
     * @throws Exception
     */
    public function deleteInventory(Request $request): JsonResponse
    {
        try {

            $this->getDealerIds($request);

            //check permissions
            if (!in_array('3', $this->permission)) {
                throw new GoCarHubException(__("message.NO_PERMISSION"));
            }

            $rules = [
                'delete_id' => 'required|comma_separated_number',
            ];

            // validate input data
            GoCarHubException::assertValidation($request->all(), $rules);

            DB::beginTransaction();
            $carObject = Car::whereIn('id', explode(',', $request->delete_id))->whereIn('user_id', $this->dealer_id);

            if ($carObject->count()) {
                $finalDeletedIds = $carObject->pluck('id')->toArray();
                if ($finalDeletedIds) {
                    Car::whereIn('id', $finalDeletedIds)->delete();
                    CarImage::whereIn('car_id', $finalDeletedIds)->delete();
                    Vehiclefeature::whereIn('car_id', $finalDeletedIds)->delete();
                }
                return successReturn($finalDeletedIds, __("message.CAR_DELETED_SUCCESSFULLY"));
            }

            throw new GoCarHubException(__("message.INVALID_IDS"));

        } catch (Exception $e) {
            DB::rollback();
            throw ($e);
        }
    }


    //sold inventory list

    /**
     * @throws Exception
     */
    public function soldInventory(Request $request): JsonResponse
    {
        try {
            $this->getDealerIds($request);

            $rules = [
                'car_id' => 'required|comma_separated_number',
                'sold_date' => 'required|date_format:Y-m-d'
            ];

            // validate input data
            GoCarHubException::assertValidation($request->all(), $rules);

            DB::beginTransaction();
            $carData = [];
            if ($this->dealer_id) {
                $carData = Car::whereIn('id', explode(',', $request->car_id))->whereIn('user_id', $this->dealer_id);
                if ($carData->count()) {
                    $carData->update(['sold_at' => $request->sold_date]);
                    return successReturn($carData->pluck('id'), __("message.SOLD_INVENTORY"));
                }
            }
            throw new GoCarHubException(__("message.INVALID_IDS"));
        } catch (Exception $e) {
            DB::rollback();
            throw ($e);
        }
    }
}
