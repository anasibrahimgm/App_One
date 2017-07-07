<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
       'client_id' => '410148912712065',
       'client_secret' => '3eef54470d0fcd7bbbab2aa81097fe00',
       'redirect' => 'http://one.app/auth/facebook/callback',
   ],
   'twitter' => [
       'client_id' => 'paeFCDozieuhYLgaB7vK1iOwd',
       'client_secret' => 'gmhNJcaQ7ZtKalWwUmrLKlPNJFWagst3SZX23Q7aJDSoiUxCJI',
       'redirect' => 'http://one.app/auth/twitter/callback',
   ],
   'github' => [
       'client_id' => '07d1881979dbb9f80b36',
       'client_secret' => '17b518f1184b115323c2d39aaec884eeb417907c',
       'redirect' => 'http://one.app/auth/github/callback',
   ],

   
];
