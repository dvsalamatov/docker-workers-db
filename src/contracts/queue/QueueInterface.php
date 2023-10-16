<?php

namespace contracts\queue;

use PhpAmqpLib\Message\AMQPMessage;

interface QueueInterface
{
    public function publish(AMQPMessage $message): void;

    public function consume(Callable $callback): void;

    public function close(): void;
}
