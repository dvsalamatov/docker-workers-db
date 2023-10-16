<?php declare(strict_types = 1);

namespace repository;

use contracts\repository\UrlStatisticRepositoryInterface;
use PDO;
use repository\dto\UrlStatDto;

class UrlStacMariaDbRepository implements UrlStatisticRepositoryInterface
{
    public function __construct(private PDO $db){}

    public function addStatistic(UrlStatDto $urlStatDto): void
    {
        $insStatSql = 'INSERT INTO report(timestamp, url, countLines, length) VALUE(:timestamp, :url, :countLines, :length)';
        $params = [
            'timestamp'=> date('Y-m-d H:i:s', $urlStatDto->getTimestamp()),
            'url' => $urlStatDto->getUrl(),
            'countLines' => $urlStatDto->getCountLines(),
            'length' => $urlStatDto->getLength(),
        ];

        $this->db->prepare($insStatSql)->execute($params);
    }
}
