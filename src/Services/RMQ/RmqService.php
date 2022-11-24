<?php

namespace Flagstudio\RmqFlag\Services\RMQ;

use Flagstudio\RmqFlag\Actions\RMQ\RmqHandleMessageAction;
use Flagstudio\RmqFlag\Dto\RMQ\RmqOptionsDto;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RmqService
{
    protected AbstractConnection $connection;

    protected ?AbstractChannel $channel;

    protected RmqOptionsDto $options;
    private RmqHandleMessageAction $rmqHandleMessageAction;

    public function __construct(RmqOptionsDto $options, RmqHandleMessageAction $rmqHandleMessageAction)
    {
        $this->connection = ConnectionFactory::create();
        $this->options = $options;
        $this->channel = null;
        $this->rmqHandleMessageAction = $rmqHandleMessageAction;
    }

    public function publish(string $messageBody): void
    {
        $connectedChannel = $this->getChannel();

        $this->declareExchange();
        //$this->declareQueue($queue);

        $message = new AMQPMessage($messageBody, [
            'content_type'  => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        ]);

        $connectedChannel->basic_publish($message, $this->options->exchange);

        $this->closeChannel();
    }

    public function listen(string $queue): void
    {
        $connectedChannel = $this->getChannel();

        $this->declareExchange();
        $this->declareQueue($queue);

        $connectedChannel->basic_consume(
            $queue,
            '',
            false,
            false,
            false,
            false,
            [$this, 'processMessage']
        );

        while ($connectedChannel->is_consuming()) {
            $connectedChannel->wait();
        }

        $this->closeChannel();
    }

    public function closeConnection()
    {
        $this->connection->close();
    }

    protected function getChannel(): AbstractChannel
    {
        return $this->channel ?? $this->connection->channel();
    }

    protected function closeChannel(): void
    {
        if ($this->channel) {
            $this->channel->close();
            $this->channel = null;
        }
    }

    protected function declareQueue(string $queue): void
    {
        $connectedChannel = $this->getChannel();
        $connectedChannel->queue_declare(
            $queue,
            $this->options->passive,
            $this->options->durable,
            $this->options->exclusive,
            $this->options->autoDelete
        );
        $connectedChannel->queue_bind($queue, $this->options->exchange, $queue);
    }

    protected function declareExchange(): void
    {
        $this->getChannel()->exchange_declare(
            $this->options->exchange,
            $this->options->exchangeType,
            $this->options->passive,
            $this->options->exchangeDurable,
            $this->options->autoDelete,
            $this->options->internal,
            $this->options->noWait,
            $this->options->arguments,
            $this->options->ticket
        );
    }

    public function processMessage(AMQPMessage $message): void
    {
        $this->rmqHandleMessageAction->execute($message);
        $message->ack();
    }
}
