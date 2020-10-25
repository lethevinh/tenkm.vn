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

    'locales' => ['vi', 'en'],

    'locale_default' => 'vi',

    'cache' => [
        'keys' => [
            'menu' => 'site-menus-',
            'post' => 'site-posts-',
            'page' => 'site-pages-',
            'site' => 'site-pages-site',
            'shortcode' => 'site-shortcode-'
        ],
        'enable' => true,
        'page_enable' => true,
        'post_enable' => false,
        'product_enable' => false,
        'project_enable' => false,
        'shortcode_enable' => false,
        'store'  => 'file'
    ]
];
