<?php

return [
    'default' => env('APP_ENV', 'production'),
    'environments' => [
        'local' => [
            'driver' => 'file',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'replace' => true,
        ],
        'production' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'info'),
        ],
    ],
];