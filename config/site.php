<?php

return [
    'name' => env('SITE_NAME', 'Vi-Site'),

    'theme' => env('SITE_THEME', 'default'),

    'options' => [
        'theme' => env('SITE_THEME', 'default'),
        'phone' => '',
        'address' => '',
        'email' => '',
        'website' => '',
        'facebook_app' => '',
        'facebook' => ''
    ],

    'cache' => [
        'keys' => [
            'menu' => 'site-menus-',
            'post' => 'site-posts-',
            'page' => 'site-pages-',
            'site' => 'site-pages-site'
        ],
        'enable' => true,
        'store'  => 'file'
    ]
];
