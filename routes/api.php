<?php

use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ThirdParty;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware("localization")->group(function () {


    if (Auth::guard('api')->check()) {
        // Auth users

        Route::group(['middleware' => ['auth:api','UserDeviceInfo']], function () {

            Route::get('/car-year', [CarController::class, 'getyear']);
            Route::get('/car-make', [CarController::class, 'getVehicleCompany']);
            Route::get('/car-model', [CarController::class, 'getVehicleModel']);
            Route::get('/car-trim', [CarController::class, 'getVehicleTrim']);
            Route::get('/car-category', [CarController::class, 'getcategory']);
            Route::get('/get-car-old', [CarController::class, 'getall']);
            Route::post('/car-details', [CarController::class, 'carDetails']);
            Route::get('/get-state', [CardController::class, 'getState']);
            Route::get('/get-subscription', [CarController::class, 'getsubscription']);
            Route::get('/get-cars-on-map', [CarController::class, 'getCarsOnMap']);
            Route::get('/car-featureslist',[CarController::class, 'getfeatureslist']);

        });
    } else {
        
        Route::get('/car-year', [CarController::class, 'getyear']);
        Route::get('/car-make', [CarController::class, 'getVehicleCompany'])->middleware('ip.whitelist');
        Route::get('/car-model', [CarController::class, 'getVehicleModel'])->middleware('ip.whitelist');
        Route::get('/car-category', [CarController::class, 'getcategory'])->middleware('ip.whitelist');
        Route::get('/car-trim', [CarController::class, 'getVehicleTrim'])->middleware('ip.whitelist');
        Route::get('/car-category', [CarController::class, 'getcategory'])->middleware('ip.whitelist');
        Route::get('/get-car-old', [CarController::class, 'getall'])->middleware('ip.whitelist');
        Route::post('/car-details', [CarController::class, 'carDetails'])->middleware('ip.whitelist');
        Route::get('/get-state', [CardController::class, 'getState'])->middleware('ip.whitelist');
        Route::get('/get-subscription', [CarController::class, 'getsubscription'])->middleware('ip.whitelist');
        Route::get('/get-cars-on-map', [CarController::class, 'getCarsOnMap'])->middleware('ip.whitelist');
        Route::get('/car-featureslist',[CarController::class, 'getfeatureslist'])->middleware('ip.whitelist');

    }

    Route::group(['namespace' => 'Api', 'middleware' => ['\App\Http\Middleware\LogAfterRequest::class']], function () {




        Route::get('/app-basic-details', [HomeController::class, 'applicationBasicDetails']);
        Route::get('/terms-conditions', [HomeController::class, 'termsConditions']);
        Route::post('upload-image', [ImageController::class, 'upload_image']);
        Route::post('/signup', [UserController::class, 'signup']);
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
        Route::post('/social-login', [UserController::class, 'socialLogin']);
        Route::post('/send-otp', [UserController::class, 'sendOtp']);
        Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
        Route::group(['middleware' => ['auth:api','UserDeviceInfo']], function () {

           
            Route::post('/change-password', [UserController::class, 'changePassword']);
            Route::post('/switch-role', [UserController::class, 'switchRole']);

            Route::post('/update-profile', [UserController::class, 'updateProfile']);
            Route::post('/seller-profile', [UserController::class, 'sellerAddress']);
            Route::post('/logout', [UserController::class, 'logout']);
            Route::get('/get-notification', [UserController::class, 'notifications']);
            Route::post('/status-update', [UserController::class, 'userstatusupdate']);
            Route::post('/delete-account', [UserController::class, 'DeleteUser']);
            Route::get('/get-user', [UserController::class, 'getUser']);
            Route::get('/profile-detail', [UserController::class, 'profileDetail']);
            Route::post('/add-car', [CarController::class, 'AddCars']);
            Route::post('/update-car', [CarController::class, 'updateCar']);
            Route::post('/sold-car', [CarController::class, 'soldCar']);

            
            Route::post('/v1/update-car', [CarController::class, 'updateCar_v']);

            Route::post('/view-gift', 'CarController@giftview');
            Route::post('/delete-car', [CarController::class, 'carDelete']);
            Route::post('/delete-image', [CarController::class, 'image_delete']);
            Route::post('/buyer-views-cars', [CarController::class, 'getBuyerCars']);
            Route::post('/user-count', 'CarController@userCarCount');
        

            Route::post('/vehicle-feature', [CarController::class, 'vehicleFeature']);
            Route::post('/vehicle-feature-update', [CarController::class, 'vehicleFeatureUpdate']);
            Route::post('/car-add-features', 'CarController@addfeatures');
            Route::post('/chat-list', 'ChatController@chatList');
            Route::post('/chat-detail', 'ChatController@chatDetail');
            Route::get('/buyer-review', 'ReviewController@Index');
            Route::post('/seller-review', 'ReviewController@user_review');
            Route::post('/get-review-car', 'ReviewController@getReviewCar');
            Route::get('/get-car-search-users', 'CarController@getCarSearchUsers');

            Route::get('get-review-list', [ReviewController::class, 'getReviewList']);

            Route::post('/review', [ReviewController::class, 'review']);
            Route::get('card-get', 'CardController@get');
            Route::post('card-save', 'CardController@save');
            Route::post('card-delete', 'CardController@delete');
            Route::post('/booking-add', 'BookingController@add');
            Route::post('booking-status', 'BookingController@BookingStatusUpdate');
            Route::post('/add-payment', 'PaymentController@addPayment');

            Route::post('package-subscription', [HomeController::class, 'packageSubscription']);


            // user block

            Route::post('block-unblock-user', [UserController::class, 'blockUnblockUser']);
            Route::get('block-user-list', [UserController::class, 'blockUserList']);
            Route::post('report-user', [UserController::class, 'reportUser']);

             // new cr 17-05-2023
             //sendNotifictonToBuyer
             Route::any('/send-notification-to-buyer', [CarController::class, 'sendNotifictonToBuyer']);
             Route::any('/send-notification-to-seller', [CarController::class, 'sendNotifictonToSeller']);

             
             

        });
        
        Route::post('/send-message', 'ChatController@sendMessage');
        Route::post('/save-message', 'ChatController@saveMessage');
        Route::post('/seen-message', 'ChatController@seenMessage');
        Route::post('/seen-all-message', 'ChatController@seenAllMessage');

    });


});

// Route::group(['namespace' => 'Api'], function () {
//     Route::post('/update-job-geolocation', 'JobController@updateJobGeolocation');
// });



Route::prefix('external')->group(function () {
    Route::middleware("localization")->group(function () {
        Route::group(['middleware' => ['\App\Http\Middleware\LogAfterRequest::class']], function () {
            //without auth routes
            Route::post('/login', [ThirdParty\UserController::class, 'login']);

            Route::group(['middleware' => ['auth:api']], function () {

                //routes with auth
                Route::post('/create-dealer', [ThirdParty\UserController::class, 'createDealer']);
                Route::post('/dealer-list', [ThirdParty\InventoryController::class, 'getDealerList']);
                Route::post('/inventory-list', [ThirdParty\InventoryController::class, 'getInventory']);
                Route::post('/insert-inventory', [ThirdParty\InventoryController::class, 'insertInventory']);
                Route::post('/update-inventory', [ThirdParty\InventoryController::class, 'updateInventory']);
                Route::post('/delete-inventory', [ThirdParty\InventoryController::class, 'deleteInventory']);
                Route::post('/sold-inventory', [ThirdParty\InventoryController::class, 'soldInventory']);
            });
        });
    });
});
