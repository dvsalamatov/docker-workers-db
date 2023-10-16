<?php declare(strict_types = 1);

namespace queue;

use contracts\queue\QueueInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Queue implements QueueInterface
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    private string $queueName;

    public function __construct(string $queueName)
    {
        $this->queueName = $queueName;
    }

    public function publish(AMQPMessage $message): void
    {
        $this->init();

        $this->channel->basic_publish($message, routing_key: $this->queueName);
    }

    public function consume(Callable $callback): void
    {
        $this->init();

        $this->channel->basic_consume($this->queueName, no_ack: true, callback: $callback);

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

        $this->close();
    }

    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }

    private function init(): void
    {
        if (isset($this->connection)) {
            return;
        }

        $this->connection = new AMQPStreamConnection(
            $_ENV['RABBIT_HOST'],
            $_ENV['RABBIT_SERVICE_PORT'],
            $_ENV['RABBIT_USER'],
            $_ENV['RABBIT_PASS'],
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queueName, durable: true, auto_delete: false);
    }
}
