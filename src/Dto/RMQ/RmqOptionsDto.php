<?php

namespace Flagstudio\RmqFlag\Dto\RMQ;

use Spatie\DataTransferObject\DataTransferObject;

class RmqOptionsDto extends DataTransferObject
{
    public string $exchange = 'default';
    public string $exchangeType = 'fanout';
    public bool $exchangeDurable = true;
    public bool $passive = false;
    public bool $durable = true;
    public bool $exclusive = false;
    public bool $autoDelete = false;
    public bool $noWait = false;
    public array $arguments = [];
    public bool $internal = false;
    public ?string $ticket = null;
    public bool $usePcntl = false;
    public int $prefetchCount = 1;
    public bool $autoAck = true;
    public bool $declare = false;
    public array $bindingKeys = [];
    public string $prefix = "";
}
