<?php

return [
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'connection' => env('PLATFORM_DB_CONNECTION', 'sqlite'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
];
