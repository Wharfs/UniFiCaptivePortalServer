<?php

return [
    'name' => 'UniFi',
    'config' => [
        'url' => env('UNIFI_URL'),
        'user' => env('UNIFI_USERNAME'),
        'password' => env('UNIFI_PASSWORD'),
        'site_id' => env('UNIFI_SITEID', ''),
        'version' => env('UNIFI_VERSION', '6.0.0.'),
        'debug' => env('UNIFI_DEBUG', false)
    ]
];
