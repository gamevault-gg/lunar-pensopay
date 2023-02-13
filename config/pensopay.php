<?php

// config for Gamevault/Pensopay
return [
    /*
    |--------------------------------------------------------------------------
    | Capture policy
    |--------------------------------------------------------------------------
    |
    | Here is where you can set whether you want to capture and charge payments
    | straight away, or create the Payment Intent and release them at a later date.
    |
    | true - Capture the payment straight away.
    | false - Don't take payment straight away and capture later.
    |
    */
    'autoCapture' => env('AUTO_CAPTURE', false),
    'url' => env('PENSOPAY_URL'),
    'token' => env('PENSOPAY_TOKEN'),

];
