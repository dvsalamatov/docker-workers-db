<?php

namespace contracts\repository;

use repository\dto\ReportRaw;
use repository\dto\UrlStatDto;

interface ReportRepositoryInterface
{
    public function addStatistic(UrlStatDto $urlStatDto): void;

    /**
     * @return ReportRaw[]
     */
    public function getStatistic(): array;
}
