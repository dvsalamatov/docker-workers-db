<?php

namespace contracts\repository;

use repository\dto\UrlStatDto;

interface UrlStatisticRepositoryInterface
{
    public function addStatistic(UrlStatDto $urlStatDto): void;
}
