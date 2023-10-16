<?php declare(strict_types = 1);

namespace repository\dto;

class UrlStatDto
{
    public function __construct(
        private string $url,
        private int $length,
        private int $countLines,
        private int $timestamp,
    ){}

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getCountLines(): int
    {
        return $this->countLines;
    }

    public function getLength(): int
    {
        return $this->length;
    }
}
