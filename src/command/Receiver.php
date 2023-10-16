<?php declare(strict_types = 1);

namespace command;

use contracts\queue\QueueInterface;
use contracts\repository\UrlStatisticRepositoryInterface;
use PhpAmqpLib\Message\AMQPMessage;
use repository\dto\UrlStatDto;

class Receiver
{
    public function __construct(
        private QueueInterface $queue,
        private UrlStatisticRepositoryInterface $urlStatisticRepository,
    ){}

    public function run(): void
    {
        $this->queue->consume(fn($msg) => $this->messageCallback($msg));
    }

    private function messageCallback(AMQPMessage $message): void
    {
        $url = $message->body;
        ['length' => $length, 'countLines' => $countLines] = $this->contentInfo($url);
        $urlStatDto = new UrlStatDto($url, $length, $countLines, time());

        $this->urlStatisticRepository->addStatistic($urlStatDto);
    }

    private function contentInfo(string $url): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $html = curl_exec($ch);
        curl_close($ch);

        return [
            'length' => intval(curl_getinfo($ch)['size_download']),
            'countLines' => count(explode("\n", $html)),
        ];
    }
}
