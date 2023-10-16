<?php

namespace contracts\actions;

use repository\dto\UrlStatDto;

interface MultipleStacSaverInterface
{
    public function save(UrlStatDto $urlStacDto): void;
}
