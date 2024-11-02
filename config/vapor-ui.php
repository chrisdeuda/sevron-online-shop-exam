<?php


return [
    'domain' => env('VAPOR_UI_DOMAIN'),
    'path' => env('VAPOR_UI_PATH', 'vapor-ui'),
    'middleware' => [
        'web',
        // 'auth',
    ],
];
