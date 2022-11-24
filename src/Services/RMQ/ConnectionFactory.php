<?php

namespace Flagstudio\RmqFlag\Services\RMQ;

use Exception;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConnectionFactory
{
    /**
     * @throws Exception
     */
    public static function create(): AbstractConnection
    {
        return new AMQPStreamConnection(config('rmq-flag.host'), config('rmq-flag.port'), config('rmq-flag.user'), config('rmq-flag.password'));
    }
}
