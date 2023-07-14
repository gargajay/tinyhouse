<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\user;
use App\Models\Card;
use App\Models\Addsubscription;
use App\Library\StripeGateway;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Notification;
use App\Models\Subscription;
use App\Models\Usercountcar;
use App\Models\Vehiclefeature;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addPayment(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            $requestData = $request->all();

            $rules = [

                'user_id' => 'required_if:subscription_type,2|Exists:users,id',
                'subscription_id' => 'required|Exists:subscriptions,id',
                'car_id' => 'required|Exists:cars,id',
                'expiry_date' => 'required|date:Y-m-d|after:yesterday',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return $errorResponse;
            }
            $userId = $request->user()->id;
            $requestData = $request->all();

            $userObj = User::find($userId);
            $cars = Car::find($requestData['car_id']);

           $realCar =  DB::table('cars')->where('id',$cars->id)->first();
            
            if (!$cars) {
                $response['message'] = __("message.CAR_NOT_EXIT");
                return response()->json($response, $response['status']);
            }
            if ($realCar->find_me_buyer == true) {
                if (isset($requestData['card_id']) && $requestData['card_id'] != '') {
                    $card_id = $requestData['card_id'];
                    $cardObj = Card::find($card_id);

                    $userObj = User::find($userId);
                    // Get stripe customer id
                    $stripeCustomerId = $userObj->stripe_customer_id;

                    if (empty($stripeCustomerId) || is_null($stripeCustomerId)) {
                        $card = [
                            'card_number' => $cardObj->card_number,
                            'card_expiry_month' => $cardObj->card_expiry_month,
                            'card_expiry_year' => $cardObj->card_expiry_year,
                            'card_cvv' => $cardObj->card_cvv,
                        ];

                        $stripeTokenResponse = StripeGateway::createToken($card);
                        if (!$stripeTokenResponse['success']) {
                            $response['message'] = $stripeTokenResponse['message'];
                            $response['code'] = $stripeTokenResponse['code'] ?? "";

                            return $response;
                        }

                        $stripeToken = $stripeTokenResponse['token'];

                        $customerData = [
                            'email' => $userObj->email,
                            'token' => $stripeToken,
                        ];

                        $stripeCustomerResponse = StripeGateway::createCustomer($customerData);

                        if ($stripeCustomerResponse['success']) {
                            $stripeCustomer = $stripeCustomerResponse['data'];
                            // $providerObj = User::find($userId);
                            $userObj->stripe_customer_id = $stripeCustomer->id;
                            $userObj->save();
                        } else {
                            $response['message'] = $stripeCustomerResponse['message'];

                            return $response;
                        }
                    }

                    $orderData = [
                        'stripe_customer_id' => $userObj->stripe_customer_id ?? $stripeCustomer->id,
                        'amount' => $requestData['amount'] ?? 10,
                        'source' => $cardObj->stripe_card_id,
                    ];

                    $chargeResponse = StripeGateway::createCharge($orderData);

                    $chargeData = [];

                    if ($chargeResponse['success']) {
                        $chargeObj = $chargeResponse['data'];
                        $chargeData = $chargeObj->jsonSerialize();
                    }
                    if (isset($chargeData['status'])) {
                        if ($chargeData['status'] == 'succeeded') {
                            $paymentMessage = STRIPE_PAYMENT_SUCCESS;
                        } elseif ($chargeData['status'] == 'pending') {
                            $paymentMessage = STRIPE_PAYMENT_PENDING;
                        } elseif ($chargeData['status'] == 'failed') {
                            $paymentMessage = STRIPE_PAYMENT_FAILED;
                        } else {
                            $paymentMessage = STRIPE_PAYMENT_FAILED;
                        }

                        $subObj = Subscription::find($requestData['subscription_id']);
                        $userId = $request->user()->id;
                        $subscriptionObj = new Addsubscription;
                        $subscriptionObj->user_id = $userId;
                        $subscriptionObj->car_id = $requestData['car_id'] ?? "";
                        $subscriptionObj->subscription_id = $requestData['subscription_id'] ?? $subObj->id;
                        $subscriptionObj->subscription_type = $requestData['subscription_type'] ?? 'days';
                        $subscriptionObj->amount = $requestData['amount'] ?? $subObj->price;
                        $subscriptionObj->expiry_date = $requestData['expiry_date'];

                        if ($subscriptionObj->save()) {
                            $paymentObj = new Payment;
                            $paymentObj->user_id = $subscriptionObj->user_id;
                            $paymentObj->booking_id =  $subscriptionObj->subscription_id;
                            $paymentObj->subscription_type =  $subscriptionObj->subscription_type;
                            $paymentObj->expiry_date =  $subscriptionObj->expiry_date;
                            $paymentObj->card_id = $requestData['card_id'] ?? "";
                            $paymentObj->car_id =  $subscriptionObj->car_id;
                            $paymentObj->amount = $subscriptionObj->amount ?? $requestData['amount'] ?? 10;
                            $paymentObj->charge_id = $chargeData['id'] ?? NULL;
                            $paymentObj->transaction_id = $chargeData['balance_transaction'] ?? NULL;
                            $paymentObj->currency = $chargeData['currency'] ?? NULL;
                            $paymentObj->payment_message = $paymentMessage ?? NULL;
                            $paymentObj->payment_status = $chargeData['status'] ?? NULL;
                            if ($paymentObj->payment_status != 'succeeded') {
                                DB::rollback();
                                $carIds = Car::where('id', $requestData['car_id'])->pluck('id');
                                $carImageIds = CarImage::whereIn('car_id', $carIds)->forceDelete();
                                $vehicleFeaturesIds = Vehiclefeature::whereIn('car_id', $carIds)->forceDelete();
                                $userCountIds = Usercountcar::whereIn('car_id', $carIds)->forceDelete();
                                $notificationCarIds = Notification::whereIn('car_id', $carIds)->forceDelete();
                                $carObj = Car::where('id', $carIds)->forceDelete();
                            }
                            if ($paymentObj->save()) {
                                $cars = Car::where('id', $requestData['car_id'])->latest()->first();
                                $cars->expiry_date = $subscriptionObj->expiry_date;
                                $cars->is_subscription = true;
                                $cars->save();
                            }
                        }
                    } else {
                        DB::rollback();
                        $carIds = Car::where('id', $requestData['car_id'])->pluck('id');
                        $carImageIds = CarImage::whereIn('car_id', $carIds)->forceDelete();
                        $vehicleFeaturesIds = Vehiclefeature::whereIn('car_id', $carIds)->forceDelete();
                        $userCountIds = Usercountcar::whereIn('car_id', $carIds)->forceDelete();
                        $notificationCarIds = Notification::whereIn('car_id', $carIds)->forceDelete();
                        $carObj = Car::where('id', $carIds)->forceDelete();
                    }
                }
            } else {
                // $paymentObj =  Payment::where('user_id', $userId)->latest()->first();
                $response['data'] = [];
                $response['message'] = __("message.PAYMENT_FAILED");
                $response['success'] = FALSE;
                $response['status'] = STATUS_BAD_REQUEST;
                return response()->json($response, $response['status']);

            }
            //== //payment

            $paymentObj =  Payment::where('user_id', $userId)->latest()->first();
            $response['data'] = $paymentObj;
            $response['message'] = __("message.PAYMENT_ADDED_SUCCESS");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json($response, $response['status']);
    }
}
