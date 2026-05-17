<?php

return [
    'base_url' => env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1'),
    'api_key' => env('OPENROUTER_API_KEY'),
    'model' => env('OPENROUTER_MODEL', 'deepseek/deepseek-v4-flash:free'),
    'verify_tls' => env('OPENROUTER_VERIFY_TLS', true),
    'timeout' => (int) env('OPENROUTER_TIMEOUT', 60),
    'connect_timeout' => (int) env('OPENROUTER_CONNECT_TIMEOUT', 10),
];
