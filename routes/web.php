<?php

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VehicleModelController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\HomeController as ControllersHomeController;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function (Request $request) {
//     //return view('welcome');

//     $userId = $request->user()->id ?? NULL;

//     if ($userId) {
//         return redirect()->route('dashboard');
//     } else {
//         return view('admin.login');
//     }
// })->name('/');


Route::get('/', 'HomeController@index')->name('/');
Route::get('/search', 'HomeController@search');
Route::post('/search2', 'HomeController@search2');
Route::get('/post-detail', 'HomeController@postDetail');



Route::group(['middleware' => ['auth']], function () {
    Route::get('/create-post', 'HomeController@createPost');
    Route::get('/my-home', 'HomeController@myHome');
    Route::get('/account-setting', 'HomeController@accountSetting');
    Route::post('/add-car', 'HomeController@AddCars');
    


});





/**********************************************************admin route************************************************ */
Auth::routes();

Route::get('/getpayment', [PaymentController::class,'getPayments']);
Route::get('/password-reset/{token}', 'ForgotPasswordController@resetPassword')->name('password.reset');
Route::post('/password-reset-update', 'ForgotPasswordController@updatePassword')->name('password.reset.update');
Route::get('/congratulation', 'ForgotPasswordController@congratulation')->name('congratulation');

Route::group(['namespace' => 'Admin'], function () {
    Route::match(['GET', 'POST'], '/login', 'AdminController@login')->name('login');
    Route::get('/forgot-password', 'AdminController@forgotPassword')->name('forgot.password');
    Route::post('/send-forgot-password-mail', 'AdminController@sendForgotPasswordMail')->name('send.forgot.password.mail');

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::post('/update-profile-admin', 'AdminController@updateProfile')->name('update.profile.admin');
        Route::match(['GET', 'POST'], '/settings', 'AdminController@settings')->name('settings');
        Route::get('/admin-logout', 'AdminController@logout')->name('admin.logout');
        Route::post('/change-password-admin', 'AdminController@changePasswordAdmin')->name('change.password.admin');

        // USER
        Route::get('job-details/{id}', 'UserController@jobDetail')->name('user.job.detail');
        Route::post('update.user.status', 'UserController@updateStatus')->name('update.user.status');
        Route::resource('user', 'UserController');
        Route::get('delete-user/{id}', 'UserController@delete')->name('user.delete');

        // Seller Users
        Route::get('seller-user', [UserController::class, 'getSellerUser'])->name('seller-user');
        Route::get('seller-user/{id}', [UserController::class, 'sellerUserShow'])->name('seller-user.show');
        Route::get('delete-user/{id}', 'UserController@delete')->name('user.delete');

        Route::get('seller-car-detail/{id}', [UserController::class, 'sellerCarDetails'])->name('seller-car-detail.sellerCarDetails');

        // CATEGORY SUB_CATEGORY
        Route::get('delete-category/{id}', 'CategoryController@delete')->name('category.delete');
        Route::resource('category', 'CategoryController');
        Route::get('delete-sub-category/{id}', 'SubCategoryController@delete')->name('sub-category.delete');
        Route::resource('sub-category', 'SubCategoryController');


        Route::get('delete-featurelist/{id}', 'FeaturelistController@delete')->name('featurelist.delete');
        Route::resource('featurelist', 'FeaturelistController');
        //Terms Conditions
        Route::match(['GET', 'POST'], 'terms-conditions', 'AdminController@termsConditions')->name('terms-conditions');

        //Slider
        Route::get('/payments', 'PaymentController@index')->name('payments');
        Route::resource('vehicle','CarController');
        Route::get('delete-vehicle/{id}', [CarController::class, 'delete'])->name('vehicle.delete');

        //subscription 
        Route::resource('subscription', 'SubscriptionController');
        Route::get('delete-subscription/{id}', 'SubscriptionController@delete')->name('subscription.delete');
        Route::post('import', 'AdminController@import')->name('import');

        Route::post('importmake', 'AdminController@importmake')->name('importmake');
        Route::post('importmodel', 'AdminController@importmodel')->name('importmodel');

        //Make
        Route::resource('make', 'VehicleMakeController');

        //Model
        Route::resource('sub-feature','SubFeatureController');
        Route::get('delete-sub-feature/{id}','SubFeatureController@delete')->name('sub-feature.delete');

        Route::resource('vehicle-model','VehicleModelController');
        Route::get('delete-vehicle-model/{id}','VehicleModelController@delete')->name('vehicle-model.delete');

        //year
        Route::resource('year', 'VehicleYearController');
        Route::get('delete-year/{id}', 'VehicleYearController@delete')->name('year.delete');
        Route::get('importExportView', 'AdminController@importExportView');
        Route::get('export', 'AdminController@export')->name('export');
    });
    Route::post('/check-email-exist', 'AdminController@checkEmailExist')->name('check.email.exist');
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
/************************************************end admin route */
});

