<?php

namespace App\Library;

use App\Models\Setting;
use Stripe;
use Exception;

class StripeGateway
{
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(config('mail.stripe.secret_key'));
    }

    public static function setStripeApiKey()
    {
        \Stripe\Stripe::setApiKey(config('mail.stripe.secret_key'));
    }

    public static function createToken($card = NULL)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['message'] = "";
        try {
            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );
            $tokenObj = $stripe->tokens->create([
                'card' => [
                    'number' => $card['card_number'],
                    'exp_month' => $card['card_expiry_month'],
                    'exp_year' => $card['card_expiry_year'],
                    'cvc' => $card['card_cvv'],
                ],
            ]);

            if ($tokenObj) {
                $response['token'] = $tokenObj->id;
                $response['success'] = TRUE;
            }
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;

            return $response;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        return $response;
    }

    public static function createCustomer($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $customerObj = \Stripe\Customer::create(array(
                'email' => $data['email'],
                'source'  => $data['token']
            ));
            $response['success'] = TRUE;
            $response['data'] = $customerObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        return $response;
    }

    public static function createAccount($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient([
                "api_key" => config('mail.stripe.secret_key'),
                "stripe_version" => "2020-08-27"
            ]);

            $accountObj = $stripe->accounts->create([
                'type' => 'custom',
                'country' => 'US',
                'business_type' => 'individual',
                'individual' => [
                    'first_name' => $data['name'],
                ],
                'email' => $data['email'],
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
            ]);

            $response['success'] = TRUE;
            $response['data'] = $accountObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function createExternalAccount($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient([
                "api_key" => config('mail.stripe.secret_key'),
                "stripe_version" => "2020-08-27"
            ]);

            $accountObj = $stripe->accounts->create([
                'type' => 'custom',
                'country' => 'US',
                //'business_type' => 'individual',
                'email' => $data['email'],
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
            ]);

            $response['success'] = TRUE;
            $response['data'] = $accountObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function getStripeCustomer($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient([
                "api_key" => config('mail.stripe.secret_key'),
                "stripe_version" => "2020-08-27"
            ]);

            $accountObj = $stripe->accounts->retrieve(
                $data['stripe_connected_account_id'],
                []
            );

            $response['success'] = TRUE;
            $response['data'] = $accountObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function updateAccount($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient([
                "api_key" => config('mail.stripe.secret_key'),
                "stripe_version" => "2020-08-27"
            ]);

            $accountObj = $stripe->accounts->update(
                $data['stripe_account_id'],
                [
                    'business_type' => 'individual',
                    'business_profile' => [
                        'mcc' => 1520,
                        'product_description' => 'Providing all type of general services like Heating, Plumbing, Electrical Services etc.'
                    ],
                    'individual' => [
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'dob' => [
                            'day' => $data['dob']['day'],
                            'month' => $data['dob']['month'],
                            'year' => $data['dob']['year'],
                        ],
                        'address' => [
                            'line1' => $data['address']['line1'],
                            'postal_code' => $data['address']['postal_code'],
                            'city' => $data['address']['city'],
                            'state' => $data['address']['state'],
                        ],
                        'email' => $data['email'],
                        'phone' => $data['mobile'],
                        'ssn_last_4' => $data['ssn_last_4'],
                    ],
                    'tos_acceptance' => [
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'date' => time()
                    ],
                ]
            );

            $response['success'] = TRUE;
            $response['data'] = $accountObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function getAccountById($accountId)
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );

            $accountObj = $stripe->accounts->retrieve(
                $accountId,
                []
            );

            $response['success'] = TRUE;
            $response['data'] = $accountObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function createBank($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );

            $bankObj = $stripe->accounts->createExternalAccount(
                $data['stripe_connected_account_id'],
                [
                    'external_account' => [
                        'country' => 'US',
                        'currency' => 'usd',
                        'account_number' => $data['account_number'],
                        'account_holder_name' => $data['account_holder_name'],

                        "object" => "bank_account",
                        "country" => "US",
                        "currency" => "usd",
                        "account_holder_name" => $data['account_holder_name'],
                        "account_holder_type" => 'individual',
                        "routing_number" => $data['routing_number'] ?? "110000000",
                        "account_number" => $data['account_number'],
                        //"bank_name" => $data['bank_name'],
                    ],
                ]
            );

            $response['success'] = TRUE;
            $response['data'] = $bankObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function transfer($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );

            $adminCommission = $data['amount'] * (10 / 100);
            $finalAmount = $data['amount'] - $adminCommission;

            $transferObj = $stripe->transfers->create([
                'amount' => $finalAmount * 100,
                'currency' => 'usd',
                'destination' => $data['stripe_connected_account_id'],
                //'destination' => 'ba_1JcrtdRfZbG2fKxKdRe6ndxN',
            ]);

            $response['success'] = TRUE;
            $response['data'] = $transferObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function createChargeOld($orderData = [])
    {
        $response = [];
        $response['success'] = FALSE;

        /* $orderData = [
            'customer' => $orderData['stripe_customer_id'],
            'amount'=> $orderData['amount'] * 100,
            'currency'=> 'usd',
            'source' => $orderData['source'],
        ]; */

        $orderAmount = $orderData['amount'] * 100;
        $adminAmount = $orderAmount * (env('ADMIN_AMOUNT_PERCENTAGE') / 100);
        $restaurantAmount = $orderAmount - $adminAmount;

        $adminAmount = round($adminAmount);
        $restaurantAmount = round($restaurantAmount);

        if (isset($orderData['stripe_connected_account_id']) && !empty($orderData['stripe_connected_account_id'])) {
            $stripeData = [
                'customer' => $orderData['stripe_customer_id'],
                'amount' => $adminAmount,
                'currency' => 'usd',
                'source' => $orderData['source'],
                'transfer_data' => [
                    //"amount" => 100,
                    "amount" => $restaurantAmount,
                    "destination" => $orderData['stripe_connected_account_id'],
                ]
            ];
        } else {
            $stripeData = [
                'customer' => $orderData['stripe_customer_id'],
                'amount' => $orderAmount,
                'currency' => 'usd',
                'source' => $orderData['source'],
            ];
        }

        try {
            self::setStripeApiKey();

            $chargeObj = \Stripe\Charge::create($stripeData);

            $response['data'] = $chargeObj;
            $response['success'] = TRUE;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        print_pre($response);
        return $response;
    }

    public static function createCharge($paymentData = [])
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            self::setStripeApiKey();

            \Stripe\Stripe::setApiKey(config('mail.stripe.secret_key'));

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );

            $amount = $paymentData['amount'] * 100;

            $ssss = $stripe->charges->create([
                'amount' => $amount,
                'currency' => 'usd',
                'customer' => $paymentData['stripe_customer_id'],
                'card' => $paymentData['source'],
            ]);

            $response['data'] = $ssss;
            $response['success'] = TRUE;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function createCard($card = NULL)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            self::setStripeApiKey();

            $token = $card['token'];
            $customer = \Stripe\Customer::retrieve($card['stripe_customer_id']);
            if ($customer->sources) {
                $card = $customer->sources->create(array("source" => $token));
            } else {
                $stripe = new \Stripe\StripeClient(
                    config('mail.stripe.secret_key')
                );
                $card = $stripe->customers->createSource(
                    $card['stripe_customer_id'],
                    ['source' => $token]
                );
            }

            //return $card;

            $response['success'] = TRUE;
            $response['card'] = $card;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        return $response;
        return FALSE;
    }

    public static function deleteCard($card = NULL)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );

            $result = $stripe->customers->deleteSource(
                $card['stripe_customer_id'],
                $card['stripe_card_id'],
                []
            );

            if ($result->deleted) {
                $response['success'] = TRUE;
            }
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        return $response;
        return FALSE;
    }

    public static function createRefund($refundData = [])
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );

            $result = $stripe->refunds->create($refundData);

            // if ($result->deleted) {
            //     $response['success'] = TRUE;
            // }
            $response = $result;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        return $response;
        return FALSE;
    }
}
