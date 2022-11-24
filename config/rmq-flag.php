<?php

return [
    'host' => env("RABBITMQ_HOST", 'rabbitmq'),
    'port' => env("RABBITMQ_PORT", 5672),
    'user' => env("RABBITMQ_USER", 'guest'),
    'password' => env("RABBITMQ_PASSWORD", 'guest'),
    'exchange' => env('RABBITMQ_EXCHANGE_NAME', '(AMQP default)'),
    'exchange_type' => env('RABBITMQ_EXCHANGE_TYPE', 'direct'),
    'vhost' => env('RABBITMQ_VHOST', '/'),
    'dsn' => env('RABBITMQ_DSN', 'amqp://'),
    'queue' => env('RABBITMQ_QUEUE'),
    'actions' => [
        //'update_users' => \App\Actions\Users\UpdateUserAction::class,
    ]
];
