<?php

namespace Flagstudio\RmqFlag\Dto\RMQ;

use Spatie\DataTransferObject\DataTransferObject;

class ActionMessageDto extends DataTransferObject
{
    public string $action;
    public array $payload;
}
