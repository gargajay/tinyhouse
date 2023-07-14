<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Library\StripeGateway;
use App\Models\Card;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Exception;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    public function get(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $userId = $request->user()->id ?? 0;

            $response['data'] = Card::where('user_id', $userId)->get();
            $response['message'] = __("message.CARD_FETCH_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            DB::rollback();

            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        if ($response['success']) {
            return response()->json($response, STATUS_OK);
        }
        return response()->json($response, STATUS_BAD_REQUEST);
    }

    public function save(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_OK;


        try {
            DB::beginTransaction();
            $rules = [
                //'name_on_card' => 'required',
                'card_number' => 'required|digits_between:13,19|numeric',
                'card_expiry_month' => 'required|numeric',
                'card_expiry_year' => 'required|numeric',
                'card_cvv' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());

                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }

            $requestData = $request->all();
            $userId = $request->user()->id ?? 0;

            // Check card already added
            $cardObj = Card::where(['user_id' => $userId])->get();

            if ($cardObj->where('card_last_four', (int)substr($requestData['card_number'], -4))->count() > 0) {
                $response['message'] = __("message.CARD_ALREADY_SAVED");
                return response()->json($response, STATUS_BAD_REQUEST);
            }

            $cardObj = new Card;
            $cardObj->user_id = $userId;
            $cardObj->name_on_card = $requestData['name_on_card'] ?? "";
            $cardObj->card_number = (int)$requestData['card_number'];
            $cardObj->card_last_four = (int)substr($requestData['card_number'], -4);
            $cardObj->card_expiry_month = (int)$requestData['card_expiry_month'];
            $cardObj->card_expiry_year = (int)$requestData['card_expiry_year'];
            $cardObj->card_cvv = (int)$requestData['card_cvv'];
            $cardObj->country = $requestData['country'] ?? "";

            if ($cardObj->save()) {
                // Get stripe customer id
                DB::commit();

                $stripeCustomerId = $request->user()->stripe_customer_id;
                if (empty($stripeCustomerId) || is_null($stripeCustomerId)) {
                    $cardObj = Card::find($cardObj->id);

                    $card = [
                        'card_number' => $cardObj->card_number,
                        'card_expiry_month' => $cardObj->card_expiry_month,
                        'card_expiry_year' => $cardObj->card_expiry_year,
                        'card_cvv' => $cardObj->card_cvv,
                    ];

                    $stripeTokenResponse = StripeGateway::createToken($card);
                    if (!$stripeTokenResponse['success']) {
                        Card::where('id', $cardObj->id)->forceDelete();
                        $response['message'] = $stripeTokenResponse['message'];
                        $response['code'] = $stripeTokenResponse['code'] ?? "";

                        return $response;
                    }
                    $stripeToken = $stripeTokenResponse['token'];
                    $customerData = [
                        'email' => $request->user()->email,
                        'token' => $stripeToken,
                    ];

                    $stripeCustomerResponse = StripeGateway::createCustomer($customerData);

                    if ($stripeCustomerResponse['success']) {
                        $stripeCustomer = $stripeCustomerResponse['data'];
                        $userObj = User::find($userId);
                        $userObj->stripe_customer_id = $stripeCustomer->id;
                        $userObj->save();
                    } else {
                        Card::where('id', $cardObj->id)->forceDelete();

                        $response['message'] = $stripeCustomerResponse['message'];
                        $response['code'] = $stripeCustomerResponse['code'] ?? "";

                        return $response;
                    }
                }
                $card = [
                    'card_number' => $cardObj->card_number,
                    'card_expiry_month' => $cardObj->card_expiry_month,
                    'card_expiry_year' => $cardObj->card_expiry_year,
                    'card_cvv' => $cardObj->card_cvv,
                ];
                $stripeTokenResponse = StripeGateway::createToken($card);
                if (!$stripeTokenResponse['success']) {
                    Card::where('id', $cardObj->id)->forceDelete();
                    $response['message'] = $stripeTokenResponse['message'];
                    $response['code'] = $stripeTokenResponse['code'] ?? "";

                    return $response;
                }

                $stripeToken = $stripeTokenResponse['token'];

                $data = [
                    'token' => $stripeToken,
                    'stripe_customer_id' => $request->user()->stripe_customer_id ?? $stripeCustomer->id,
                ];

                $stripeCardData = StripeGateway::createCard($data);
                if ($stripeCardData['success']) {
                    $stripeCardObj = $stripeCardData['card'];
                    $cardObj = Card::find($cardObj->id);
                    $cardObj->stripe_card_id = $stripeCardObj->id;
                    $cardObj->card_number = null;
                    $cardObj->card_last_four = substr($requestData['card_number'], -4);
                    $cardObj->card_expiry_month = $requestData['card_expiry_month'];
                    $cardObj->card_expiry_year = $requestData['card_expiry_year'];
                    $cardObj->card_cvv = NULL;
                    $cardObj->save();
                } else {
                    Card::where('id', $cardObj->id)->forceDelete();

                    return  $response['message'] = $stripeCardData['message'] ?? "";
                    $response['code'] = $stripeCardData['code'] ?? "";

                    return $response;
                }

                DB::commit();
            }

            $response['data'] = $cardObj;
            $response['message'] = __("message.CARD_ADDED_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            DB::rollback();

            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        if ($response['success']) {
            return response()->json($response, STATUS_OK);
        }
        return response()->json($response, STATUS_BAD_REQUEST);
    }

    public function delete(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $rules = [
                //'name_on_card' => 'required',
                'card_id' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }

            $requestData = $request->all();

            Card::where('id', $requestData['card_id'])->delete();
            $response['message'] = __("message.CARD_DELETED_SUCCESSFULLY");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            DB::rollback();

            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        if ($response['success']) {
            return response()->json($response, STATUS_OK);
        }
        return response()->json($response, STATUS_BAD_REQUEST);
    }

    public function validateCard(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $rules = [
                'card_id' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, STATUS_BAD_REQUEST);
            }

            $requestData = $request->all();

            $cardObj = Card::where('id', $requestData['card_id'])->first();

            if (!$cardObj) {
                $response['message'] = __("message.CARD_INVALID");
                return response()->json($response, STATUS_BAD_REQUEST);
            }

            $card = [
                'card_number' => $cardObj->card_number,
                'card_expiry_month' => $cardObj->card_expiry_month,
                'card_expiry_year' => $cardObj->card_expiry_year,
                'card_cvv' => $cardObj->card_cvv,
            ];
            $stripeTokenResponse = StripeGateway::createToken($card);
            if (!$stripeTokenResponse['success']) {
                Card::where('id', $cardObj->id)->forceDelete();
                $response['message'] = $stripeTokenResponse['message'];
                $response['code'] = $stripeTokenResponse['code'] ?? "";

                return $response;
            }

            $stripeToken = $stripeTokenResponse['token'];

            $data = [
                'token' => $stripeToken,
                'stripe_customer_id' => $request->user()->stripe_customer_id,
            ];

            $stripeCardData = StripeGateway::createCard($data);

            if ($stripeCardData['success']) {
                $response['message'] = 'Valid card';

                // DELETE DUPLICATE CARD
                $stripeCardObj = $stripeCardData['card'];
                $stripeCardId = $stripeCardObj->id;

                $cardData = [
                    'stripe_customer_id' => $request->user()->stripe_customer_id,
                    'stripe_card_id' => $stripeCardId
                ];

                StripeGateway::deleteCard($cardData);
            } else {
                $response['message'] = $stripeCardData['message'] ?? "";
                $response['code'] = $stripeCardData['code'] ?? "";

                return $response;
            }

            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        if ($response['success']) {
            return response()->json($response, STATUS_OK);
        }
        return response()->json($response, STATUS_BAD_REQUEST);
    }
    public function getState(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $requestData = $request->all();
            $response['data'] = Country::where('country_code', $requestData['country_code'])->get();
            $response['message'] =  __("message.STATE_FETCHED");
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            DB::rollback();

            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        if ($response['success']) {
            return response()->json($response, STATUS_OK);
        }
        return response()->json($response, STATUS_BAD_REQUEST);
    }
}
