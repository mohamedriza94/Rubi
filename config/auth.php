<?php

return [
    
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
    
    //guards
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        
        
        'rubiAdmin' => [
            'driver' => 'session',
            'provider' => 'rubiAdmins',
        ],
    ],
    
    //providers
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        
        'rubiAdmins' => [
            'driver' => 'eloquent',
            'model' => App\Models\RubiAdmin::class,
        ],
        
    ],
    
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'rubiAdmins' => [
            'provider' => 'rubiAdmins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */
    
    'password_timeout' => 10800,
    
];
