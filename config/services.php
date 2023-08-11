<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'plans' => [
            [
            'plan' => 'price_1NdjsWC2kWkG1GrQNebWbyo2',
            'name' => '30 day ad - $50 + GST',
            'price' =>'55'
            ],
            [
                'plan' => 'price_1NdjtlC2kWkG1GrQXqfGoCym',
                'name' => '90 day ad - $150 + GST',
                'price' =>'165'
                ],
            [
                'plan' => 'price_1NdjucC2kWkG1GrQjvn7ogVv',
                'name' => '180 day ad - $300 + GST',
                'price' =>'330'
                ],
                [
                    'plan' => 'price_1NdjwIC2kWkG1GrQVmj494Vb',
                    'name' => '1 year ad - $600 + GST',
                    'price' =>'660'
                    ],
           
        ],
    ],

];
