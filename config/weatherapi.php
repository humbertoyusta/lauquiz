<?php

return [
    'foreca' => [
        'user' => env('FORECA_USER'),
        'password' => env('FORECA_PASSWORD'),
        'base_url' => env('FORECA_BASE_URL'),
        'login_endpoint' => env('FORECA_LOGIN_ENDPOINT', 'authorize/token'),
        'current_endpoint' => env('FORECA_CURRENT_ENDPOINT', 'api/v1/current'),
        'daily_forecast_endpoint' => env('FORECA_DAILY_FORECAST_ENDPOINT', 'api/v1/forecast/daily'),
    ],
];
