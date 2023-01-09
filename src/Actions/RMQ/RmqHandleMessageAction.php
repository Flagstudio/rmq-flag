<?php

namespace Flagstudio\RmqFlag\Actions\RMQ;

use Flagstudio\RmqFlag\Actions\RMQ\RmqMessageHandleExecutorAction;
use Flagstudio\RmqFlag\Dto\RMQ\ActionMessageDto;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Message\AMQPMessage;
use RuntimeException;

class RmqHandleMessageAction
{
    private ActionMessageDto $actionMessageDto;

    /**
     * @throws \JsonException
     */
    public function execute(AMQPMessage $message): void
    {
        $this->setActionMessageDto($message->body);

        if (isset($this->actionMessageDto)) {
            app(RmqMessageHandleExecutorAction::class)
                ->execute($this->actionMessageDto);
        }
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
                return;
            }

            $this->actionMessageDto = new ActionMessageDto(['action' => $messageBody->action, 'payload' => $messageBody->payload]);
        } catch (Exception $e) {
            Log::error("Can't decode message body - " . $e->getMessage());
            die();
        }
    }
}
