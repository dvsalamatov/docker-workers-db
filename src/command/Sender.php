<?php declare(strict_types = 1);

namespace command;

use contracts\queue\QueueInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Sender
{
    public function __construct(private QueueInterface $queue){}

    public function run(): void
    {
        $this->queue->publish(new AMQPMessage('https://www.drive2.ru', ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]));
        $this->queue->close();
    }
}
