<?php

return [
    'botman' => [
        'conversation_cache_time' => 0
    ],
    'telegram' => [
        'token' => env('TG_BOT_TOKEN', ''),
        'webhook_url' => env('TG_WEBHOOK_URL', ''),
    ]
];
