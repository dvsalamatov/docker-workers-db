<?php declare(strict_types = 1);

namespace repository\dto;

use DateTime;
use Stringable;

class ReportRaw implements Stringable
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

    public function __toString(): string
    {
        return implode(', ', [
            'Sum Count Lines = ' . $this->sumCountLines,
            'Average Length = ' . $this->avgLength,
            'Group Minute = ' . $this->minute,
            'Min Time = ' . $this->minTime->format('Y-m-d H:i:s'),
            'Max Time = ' . $this->maxTime->format('Y-m-d H:i:s'),
        ]);
    }
}
