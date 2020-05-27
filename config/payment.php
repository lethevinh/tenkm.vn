<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Gateway
    |--------------------------------------------------------------------------
    |
    | Here you can specify the gateway that the facade should use by default.
    |
    */
    'gateway' => env('PAYMENT_GATEWAY', 'Payoo'),

    /*
    |--------------------------------------------------------------------------
    | Default settings
    |--------------------------------------------------------------------------
    |
    | Here you can specify default settings for gateways.
    |
    */
    'defaults' => [
        'testMode' => env('PAYMENT_TESTMODE', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Gateway specific settings
    |--------------------------------------------------------------------------
    |
    | Here you can specify gateway specific settings.
    |
    */
    'gateways' => [
        'PayPal_Express' => [
            'username' => env('PAYMENT_GATEWAY_PAYPAL_USERNAME', 'sb-lv4bc1529332_api1.business.example.com'),
            'password' => env('PAYMENT_GATEWAY_PAYPAL_USERNAME', 'ANPH3LLEKKYVK3WP'),
            'signature' => env('PAYMENT_GATEWAY_PAYPAL_USERNAME', 'AEP7cVBHKQZwSWgwTVXLZhLEUHgkAZIaz8MsleISjsL7cNlNzH4KbWQn'),
            'returnUrl' => 'http://localhost:8888/payment/str',
            'cancelUrl' => 'http://localhost:8888/payment/str',
            'landingPage' => ['billing', 'login'],
        ],
        'Payoo' => [
            'businessUsername' => env('PAYMENT_GATEWAY_PAYOO_USERNAME', 'iss_shop_client'),
            'shopId' => env('PAYMENT_GATEWAY_PAYOO_SHOP_ID', '691'),
            'shopTitle' => env('PAYMENT_GATEWAY_PAYOO_SHOP_TITLE', 'shop_client'),
            'shopDomain' => env('PAYMENT_GATEWAY_PAYOO_SHOP_DOMAIN', 'http://localhost'),
            '_ShopBackUrl' => env('PAYMENT_GATEWAY_PAYOO_SHOP_BACK', 'http://localhost:8888/payment/payoo/back'),
            'notifyUrl' => env('PAYMENT_GATEWAY_PAYOO_SHOP_NOTIFY', 'http://192.168.11.31:8333/NotifyListener.aspx'),
            '_PayooPaymentUrl' => env('PAYMENT_GATEWAY_PAYOO_PAYMENT_URL', 'https://newsandbox.payoo.com.vn/v2/paynow'),
            '_PayooPaymentAPI' => env('PAYMENT_GATEWAY_PAYOO_PAYMENT_API', 'https://newsandbox.payoo.com.vn/v2/paynow/order/create'),
            '_BusinessAPIUrl' => env('PAYMENT_GATEWAY_PAYOO_API_URL', 'https://bizsandbox.payoo.com.vn/BusinessRestAPI.svc'),
            'apiUsername' => env('PAYMENT_GATEWAY_PAYOO_API_USERNAME', 'iss_shop_client_BizAPI'),
            'apiPassword' => env('PAYMENT_GATEWAY_PAYOO_API_PASSWORD', 'xL0EFyakWD925t8V'),
            'apiSignature' => env('PAYMENT_GATEWAY_PAYOO_API_SIGNATURE', 'hsiPxtzDUjkfb2iRHhP3JSwgw4uMTJoV16AW3aSPmP36IdeZIwU2Wgmv4AyCd1cQ'),
            'secretKey' => env('PAYMENT_GATEWAY_PAYOO_SECRET', '73b3f5b8efa2c3654b75bf6f5afb76d0'),
        ],
    ],

];
