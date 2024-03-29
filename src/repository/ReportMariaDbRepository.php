<?php declare(strict_types = 1);

namespace repository;

use contracts\repository\ReportRepositoryInterface;
use PDO;
use repository\dto\ReportRaw;
use repository\dto\UrlStatDto;

class ReportMariaDbRepository implements ReportRepositoryInterface
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

    /**
     * @return ReportRaw[]
     */
    public function getStatistic(): array
    {
        $sql = '
            SELECT
                SUM(countLines) as sumCountLines,
                AVG(length) as avgLength,
                EXTRACT(MINUTE from timestamp) as minute,
                MAX(timestamp) as maxTime,
                MIN(timestamp) as minTime
            FROM report
            GROUP BY minute
        ';

        $stmt = $this->db->query($sql);

        $res = [];

        while ($row = $stmt->fetch()) {
            $res[] = (new ReportRaw())->createFromRaw($row);
        }

        return $res;
    }
}
