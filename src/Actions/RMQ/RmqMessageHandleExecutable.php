<?php

namespace Flagstudio\RmqFlag\Actions\RMQ;

interface RmqMessageHandleExecutable
{
    public function execute(array $data): void;
}
