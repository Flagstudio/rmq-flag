<?php

namespace Flagstudio\RmqFlag\Actions\RMQ;

use Flagstudio\RmqFlag\Dto\RMQ\ActionMessageDto;
use Illuminate\Support\Arr;
use RuntimeException;

class RmqMessageHandleExecutorAction
{
    public function execute(ActionMessageDto $actionMessageDto): void
    {
        $action = Arr::get(config('rmq-flag.actions'), $actionMessageDto->action);

        if (empty($actionMessageDto->payload)) {
            throw new RuntimeException('Action payload is empty');
        }

        if (class_implements($action, RmqMessageHandleExecutable::class)) {
            app($action)
                ->execute($actionMessageDto->payload);
        } else {
            throw new RuntimeException('Action class does not implement `RmqMessageHandleExecutable` interface');
        }
    }
}
