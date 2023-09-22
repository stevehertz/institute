<?php

return [

     //Specify the environment mpesa is running, sandbox or production
     'mpesa_env' => env('MPESA_ENV','sandbox'),
    /*-----------------------------------------
    |The App consumer key
    |------------------------------------------
    */
    'consumer_key' =>  env('MPESA_CONSUMER_KEY'),

    /*-----------------------------------------
    |The App consumer Secret
    |------------------------------------------
    */
    'consumer_secret' => env('MPESA_CONSUMER_SECRET'),

    /*-----------------------------------------
    |The paybill number
    |------------------------------------------
    */
    'paybill'         => env('MPESA_PAYBILL'),

    /*-----------------------------------------
    |Lipa Na Mpesa Online Shortcode
    |------------------------------------------
    */
    'lipa_na_mpesa'  => env('MPESA_LIPA_NA_MPESA'),

    /*-----------------------------------------
    |Lipa Na Mpesa Online Passkey
    |------------------------------------------
    */
    'lipa_na_mpesa_passkey' => env('MPESA_PASS_KEY'),

    /*-----------------------------------------
    |Initiator Username. stawitech1
    |------------------------------------------
    */
    'initiator_username' => env('MPESA_INITIATOR_USERNAME'),

    /*-----------------------------------------
    |Initiator Password
    |------------------------------------------
    */
    'initiator_password' => env('MPESA_INITIATOR_PASSWORD'),

    /*-----------------------------------------
    |Test phone Number
    |------------------------------------------
    */
    'test_msisdn ' => '254708374149',

    /*-----------------------------------------
    |Lipa na Mpesa Online callback url
    |------------------------------------------
    */
    'lnmocallback' => env('APP_URL').'api/validate?key=ertyuiowwws',

     /*-----------------------------------------
    |C2B  Validation url
    |------------------------------------------
    */
    'c2b_validate_callback' =>env('APP_URL').'api/validate?key=ertyuiowwws',

    /*-----------------------------------------
    |C2B confirmation url
    |------------------------------------------
    */
    'c2b_confirm_callback' => env('APP_URL').'api/confirm?key=ertyuiowwws',

    /*-----------------------------------------
    |B2C timeout url
    |------------------------------------------
    */
    'b2c_timeout' => env('APP_URL').'api/validate?key=ertyuiowwws',

    /*-----------------------------------------
    |B2C results url
    |------------------------------------------
    */
    'b2c_result' => env('APP_URL').'api/validate?key=ertyuiowwws'

];
