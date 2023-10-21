<?php declare(strict_types = 1);

namespace repository\dto;

use DateTime;

class ReportRaw
{
    private int $sumCountLines;
    private float $avgLength;
    private int $minute;
    private DateTime $maxTime;
    private DateTime $minTime;

    public function createFromRaw(array $data): self
    {
        $reportRaw = new self();
        $reportRaw->sumCountLines = intval($data['sumCountLines']);
        $reportRaw->avgLength = floatval($data['avgLength']);
        $reportRaw->minute = intval($data['minute']);
        $reportRaw->maxTime = DateTime::createFromFormat('Y-m-d H:i:s', $data['maxTime']);
        $reportRaw->minTime = DateTime::createFromFormat('Y-m-d H:i:s', $data['minTime']);

        return $reportRaw;
    }

    /**
     * @return int
     */
    public function getSumCountLines(): int
    {
        return $this->sumCountLines;
    }

    /**
     * @return float
     */
    public function getAvgLength(): float
    {
        return $this->avgLength;
    }

    /**
     * @return int
     */
    public function getMinute(): int
    {
        return $this->minute;
    }

    /**
     * @return DateTime
     */
    public function getMaxTime(): DateTime
    {
        return $this->maxTime;
    }

    /**
     * @return DateTime
     */
    public function getMinTime(): DateTime
    {
        return $this->minTime;
    }
}
