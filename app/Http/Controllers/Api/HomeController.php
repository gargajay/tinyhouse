<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Setting;
use App\Models\SubscriptionPayment;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Faker\Factory;
use Faker\Provider\en_US\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
    public function applicationBasicDetails()
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $appSetting = Setting::where('name', 'app')->first();
            $requestData = $appSetting->value ?? [];

            $data['app_name'] = $requestData['app_name'] ?? "";
            $data['rate_on_apple_store'] = $requestData['rate_on_apple_store'] ?? "";
            $data['rate_on_google_store'] = $requestData['rate_on_google_store'] ?? "";
            $data['terms_conditions'] = $requestData['terms_conditions'] ?? "";
            $data['privacy_policy'] = $requestData['privacy_policy'] ?? "";
            $data['help'] = $requestData['help'] ?? "";
            $data['search_distance_limit'] = $requestData['search_distance_limit'] ?? "";
            $data['instant_slot_notification'] = $requestData['instant_slot_notification'] ?? "";

//            $this->testData();

            $response['data'] = $data;
            $response['message'] = 'Application basic details fetched successfully';
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }

    public function termsConditions()
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $termsConditions = Setting::where('name', 'terms_conditions')->first();
            $data = $termsConditions->value ?? [];

            $response['data'] = $data;
            $response['message'] = 'Terms conditions fetched successfully';
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }

    public function packageSubscription(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $requestData = $request->all();
            $userId = $requestData['user_id'] ?? $request->user()->id;
            error_log(print_r($request->all(), true));
            $currentDate = Carbon::now()->format('Y-m-d');
            $userObj = User::find($userId);

            $userObj->subscription_package_name = $requestData['subscription_package_name'] ?? "";
            $userObj->subscription_expiry_date = Carbon::parse($userObj->created_at)->addDays($requestData['subscription_days'])->format('m-d-Y') ?? "";
            $userObj->subscription_post_count = $requestData['subscription_post_count'] ?? "";
            $userObj->is_subscription = true ?? false;
            $userObj->is_free_trail = false ?? true;
            if ($userObj->save()) {
                $subscriptionPayment = SubscriptionPayment::where('subscription_traction_id', $requestData['subscription_traction_id'])->latest()->first();
                if (!$subscriptionPayment) {
                    $subscriptionPayment = new SubscriptionPayment;
                    $subscriptionPayment->subscription_traction_id = $requestData['subscription_traction_id'] ?? "";
                }
                $subscriptionPayment->user_id = $userId ?? $userObj->id;
                $subscriptionPayment->subscription_type = $userObj->subscription_package_name ?? "";
                $subscriptionPayment->subscription_amount = $requestData['subscription_amount'] ?? "";
                $subscriptionPayment->subscription_expiry_date = $userObj->subscription_expiry_date ?? "";
                $subscriptionPayment->save();
            }

            $response['data'] = User::where('id', $userObj->id)->first();
            $response['message'] = $msg = __("message.PURCHASED_SUCCESSFULLY") . $userObj->subscription_package_name;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }

    private function testData()
    {

        // Define the boundaries of multiple cities
        $cities = array(
            "New York" => array(
                "lat_min" => 40.4774,
                "lat_max" => 40.9176,
                "lng_min" => -74.2591,
                "lng_max" => -73.7002,
            ),
            "Los Angeles" => array(
                "lat_min" => 33.7037,
                "lat_max" => 34.3373,
                "lng_min" => -118.6682,
                "lng_max" => -118.1553,
            ),
            "Chicago" => array(
                "lat_min" => 40.6445,
                "lat_max" => 41.0230,
                "lng_min" => -88.1571,
                "lng_max" => -88.0069,
            ),
            "Washington" => array(
                "lat_min" => 38.7916,
                "lat_max" => 38.9955,
                "lng_min" => -77.1198,
                "lng_max" => -76.9094,
            ),
            "San Francisco" => array(
                "lat_min" => 37.6398,
                "lat_max" => 37.9298,
                "lng_min" => -123.1738,
                "lng_max" => -122.2818,
            ),
            "Houston" => array(
                "lat_min" => 29.5223,
                "lat_max" => 30.1105,
                "lng_min" => -95.7978,
                "lng_max" => -95.0130,
            ),
            "Seattle" => array(
                "lat_min" => 47.4912,
                "lat_max" => 47.7341,
                "lng_min" => -122.4355,
                "lng_max" => -122.2249,
            ),
            "Schaumburg" => array(
                "lat_min" => 41.9750,
                "lat_max" => 42.0697,
                "lng_min" => -88.1571,
                "lng_max" => -88.0069,
            ),
            "St. Louis" => array(
                "lat_min" => 38.5252,
                "lat_max" => 38.7719,
                "lng_min" => -90.4068,
                "lng_max" => -90.1561,
            ),
            "Montgomery, Alabama" => array(
                "lat_min" => 32.2650,
                "lat_max" => 32.4207,
                "lng_min" => -86.3753,
                "lng_max" => -86.1056,
            ),
            "Juneau, Alaska" => array(
                "lat_min" => 58.2042,
                "lat_max" => 58.4208,
                "lng_min" => -134.0879,
                "lng_max" => -134.0190,
            ),
            "Phoenix, Arizona" => array(
                "lat_min" => 33.2902,
                "lat_max" => 33.8487,
                "lng_min" => -112.4440,
                "lng_max" => -111.6203,
            ),
            "Little Rock, Arkansas" => array(
                "lat_min" => 34.6694,
                "lat_max" => 34.8514,
                "lng_min" => -92.4739,
                "lng_max" => -92.1257,
            ),
            "Sacramento, California" => array(
                "lat_min" => 38.4377,
                "lat_max" => 38.6551,
                "lng_min" => -121.5948,
                "lng_max" => -121.3153,
            ),
            "Denver, Colorado" => array(
                "lat_min" => 39.6144,
                "lat_max" => 39.9142,
                "lng_min" => -105.1099,
                "lng_max" => -104.6003,
            ),
            "Hartford, Connecticut" => array(
                "lat_min" => 41.7258,
                "lat_max" => 41.7949,
                "lng_min" => -72.7786,
                "lng_max" => -72.6715,
            ),
            "Dover, Delaware" => array(
                "lat_min" => 39.1022,
                "lat_max" => 39.1840,
                "lng_min" => -75.5673,
                "lng_max" => -75.4945,
            ),
            "Tallahassee, Florida" => array(
                "lat_min" => 30.4084,
                "lat_max" => 30.5104,
                "lng_min" => -84.3289,
                "lng_max" => -84.1886,
            ),
            "Atlanta, Georgia" => array(
                "lat_min" => 33.6301,
                "lat_max" => 33.8872,
                "lng_min" => -84.5511,
                "lng_max" => -84.2896,
            ),
            "Honolulu, Hawaii" => array(
                "lat_min" => 21.2555,
                "lat_max" => 21.3459,
                "lng_min" => -157.9577,
                "lng_max" => -157.7025,
            ),
            "Boise, Idaho" => array(
                "lat_min" => 43.5650,
                "lat_max" => 43.6817,
                "lng_min" => -116.3103,
                "lng_max" => -116.1625,
            ),
            "Springfield, Illinois" => array(
                "lat_min" => 39.7265,
                "lat_max" => 39.8385,
                "lng_min" => -89.7329,
                "lng_max" => -89.5868
            )
        );

        for ($i = 0; $i < 50000; $i++) {
            $faker = Factory::create();
            $make = $faker->randomElement(["Toyota", "Ford", "Honda", "Chevrolet", "Nissan", "Jeep", "Hyundai", "Kia", "BMW", "Mercedes-Benz", "Audi", "Volkswagen", "Mazda", "Subaru", "Lexus", "Dodge", "Chrysler", "Volvo", "Mitsubishi", "Buick"]);
            $car_models = array(
                "Toyota" => array("Camry", "Corolla", "Rav4", "Highlander", "Tacoma"),
                "Ford" => array("F-150", "Escape", "Explorer", "Mustang", "Focus"),
                "Honda" => array("Civic", "Accord", "CR-V", "Pilot", "Odyssey"),
                "Chevrolet" => array("Silverado", "Equinox", "Malibu", "Camaro", "Tahoe"),
                "Nissan" => array("Altima", "Rogue", "Sentra", "Pathfinder", "Maxima"),
                "Jeep" => array("Wrangler", "Grand Cherokee", "Cherokee", "Compass", "Renegade"),
                "Hyundai" => array("Elantra", "Sonata", "Tucson", "Santa Fe", "Kona"),
                "Kia" => array("Optima", "Soul", "Sorento", "Sportage", "Telluride"),
                "BMW" => array("3 Series", "5 Series", "X3", "X5", "7 Series"),
                "Mercedes-Benz" => array("C-Class", "E-Class", "S-Class", "GLC", "GLE"),
                "Audi" => array("A4", "A6", "Q5", "Q7", "A8"),
                "Volkswagen" => array("Jetta", "Passat", "Tiguan", "Atlas", "Golf"),
                "Mazda" => array("Mazda3", "Mazda6", "CX-5", "CX-9", "MX-5 Miata"),
                "Subaru" => array("Outback", "Forester", "Impreza", "Ascent", "Legacy"),
                "Lexus" => array("ES", "RX", "IS", "LS", "NX"),
                "Dodge" => array("Charger", "Challenger", "Durango", "Journey", "Grand Caravan"),
                "Chrysler" => array("300", "Pacifica", "Voyager"),
                "Volvo" => array("XC90", "XC60", "S90", "S60", "V90"),
                "Mitsubishi" => array("Outlander", "Eclipse Cross", "Mirage", "Outlander Sport", "Pajero"),
                "Buick" => array("Enclave", "Encore", "Regal", "LaCrosse", "Envision")
            );
            $model = $faker->randomElement($car_models[$make]);
            // Select a random city from the array
            $city_name = array_rand($cities);
            $city = $cities[$city_name];

// Generate a random latitude and longitude within the boundaries of the selected city
            $lat = $faker->latitude($city["lat_min"], $city["lat_max"]);
            $lng = $faker->longitude($city["lng_min"], $city["lng_max"]);

            // Replace "New York" with the desired city name
            $faker->addProvider(new Address($faker));
            $address = $faker->address(['city' => $city]);
            $car = array(
                "user_id" => 210,
                "year" => $faker->year(),
                "amount" => $faker->randomFloat(2, 10000, 60000),
                "engine_size" => $faker->sentence(3),
                "car_type" => $faker->randomElement(['shipping', 'pickup']),
                "description" => $faker->paragraph(),
                "find_me_buyer" => true,
                "expiry_date" => null,
                "is_subscription" => false,
                "is_contact" => false,
                "is_payment" => false,
                "vehicle_companies_id" => null,
                "vehicle_models_id" => null,
                "registration_number" => strtoupper($faker->word()),
                "engine_number" => null,
                "meter_reading" => $faker->numberBetween(1000, 30000),
                "car_fuel_type" => $faker->randomElement(['Petrol', 'Diesel', 'CNG', 'Bio-Diesel', 'LPG']),
                "car_number_plate" => null,
                "post_ad_number" => $faker->word(),
                "lat" => "25.97946",
                "lng" => "-80.20591",
                "geolocation" => "POINT ($lng $lat)",
                "city" => $faker->city(),
                "state" => $faker->state(),
                "condition" => null,
                "mileage" => $faker->numberBetween(150, 300),
                "color" => $faker->hexColor(),
                "title_status" => null,
                "exterior_color" => $faker->hexColor(),
                "category_id" => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 10]),
                "make" => $make,
                "model" => $model,
                "car_address" => $address,
                "zip_code" => $faker->postcode(),
                "vin_number" => $faker->word(),
                "sold_at" => null,
                "created_by" => 1,
                "created_at" => '2023-03-28 14:21:00'
            );
            Car::insert($car);
        }
    }
}
