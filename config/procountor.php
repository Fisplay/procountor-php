<?php

return [
    'api_version'   => env('PROCOUNTOR_API_VERSION', 'latest'),
    'api_key'       => env('PROCOUNTOR_API_KEY'),
    'client_id'     => env('PROCOUNTOR_CLIENT_ID'),
    'client_secret' => env('PROCOUNTOR_CLIENT_SECRET'),
    'base_uri'      => env('PROCOUNTOR_BASE_URI', 'https://api-test.procountor.com'),
    'redirect_uri'  => env('PROCOUNTOR_REDIRECT_URI'),
    'state_key'     => env('PROCOUNTOR_STATE_KEY', 'procountor-m2m'),
    'bank_account'  => env('PROCOUNTOR_BANK_ACCOUNT'),
];
