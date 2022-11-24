<?php

namespace Flagstudio\RmqFlag\Actions\RMQ;

use Flagstudio\RmqFlag\Dto\RMQ\ActionMessageDto;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Message\AMQPMessage;
use RuntimeException;
use Flagstudio\RmqFlag\Actions\RMQ\RmqMessageHandleExecutorAction;

class RmqHandleMessageAction
{
    private ActionMessageDto $actionMessageDto;

    /**
     * @throws \JsonException
     */
    public function execute(AMQPMessage $message): void
    {
        $this->setActionMessageDto($message->body);

        app(RmqMessageHandleExecutorAction::class)
            ->execute($this->actionMessageDto);
    }

    /**
     * @param string $body
     * @return void
     */
    private function setActionMessageDto(string $body): void
    {
        try {
            $messageBody = json_decode($body, false, 512, JSON_THROW_ON_ERROR);

            if (empty($messageBody->action) || empty($messageBody->payload)) {
                throw new RuntimeException("'action' or 'payload' does not exists");
            }

            $this->actionMessageDto = new ActionMessageDto(['action' => $messageBody->action, 'payload' => $messageBody->payload]);
        } catch (Exception $e) {
            Log::error("Can't decode message body - " . $e->getMessage());
            die();
        }
    }
}
