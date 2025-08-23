<?php

use Illuminate\Support\Str;

return [

    'driver' => env('SESSION_DRIVER', 'file'),

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    'encrypt' => false,

    'files' => storage_path('framework/sessions'),

    'connection' => null,

    'table' => 'sessions',

    'store' => null,

    'lottery' => [2, 100],

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_') . '_session'
    ),

    // 👇 IMPORTANT FOR NGROK / LTI
    'path' => '/',
    'domain' => null, // ⬅️ This must be null to allow ngrok dynamic domains
    'secure' => true, // Set to false for http; true if you're using https with ngrok
    'http_only' => true,
    'same_site' => null, // ⬅️ VERY IMPORTANT — must allow cross-site POST

    'proxy' => false,
];
