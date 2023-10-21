<?php declare(strict_types = 1);

namespace command;

use contracts\fileReader\FileReaderInterface;
use contracts\queue\QueueInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Sender
{
    private const SLEEP_INTERVAL_MULTIPLE = 10;

    public function __construct(private QueueInterface $queue, private FileReaderInterface $fileReader){}

    public function run(): void
    {
        foreach ($this->fileReader->read() as $url) {

            if (!$this->validateUrl($url)) {
                continue;
            }

            $this->sendMessage($url);

            $this->sleep();
        }

        $this->finish();
    }

    private function validateUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    private function sendMessage($url): void
    {
        $this->queue->publish(new AMQPMessage($url, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]));
    }

    private function sleep(): void
    {
        static $numIteration = 1;

        sleep($numIteration * self::SLEEP_INTERVAL_MULTIPLE);
    }

    private function finish(): void
    {
        $this->queue->close();
    }
}
