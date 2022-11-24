# RMQ-Flag

This package for handling RabbitMQ messages in the Flagstudio Services

- add environment variables

```dotenv
###RABBITMQ
RABBITMQ_EXCHANGE_NAME=
RABBITMQ_EXCHANGE_TYPE=fanout
RABBITMQ_QUEUE=
RABBITMQ_HOST=
RABBITMQ_PORT=5672
RABBITMQ_USER=
RABBITMQ_PASSWORD=
RABBITMQ_VHOST=/
RABBITMQ_DSN=amqp://
```

- export config file

```shell
php artisan vendor:publish --provider="Flagstudio\RmqFlag\Providers\RmqFlagServiceProvider" --tag="config"
```

- add class which implements `RmqMessageHandleExecutable` interface for handling message by `action` value to `rmq-flag.ations` array

```php
# /config/rmq-flag.php

return [
    #...
    'actions' => [
        # for example
        'update_users' => \App\Actions\Users\UpdateUserAction::class,
    ]
    #...
];
```
