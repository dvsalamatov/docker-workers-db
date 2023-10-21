<?php

namespace components\fileReader;

use contracts\fileReader\FileReaderInterface;
use phpseclib3\Exception\FileNotFoundException;

class FileReaderArray implements FileReaderInterface
{
    private string $fileName;

    public function __construct(string $appDir, string $fileName)
    {
        $this->fileName = $appDir . '/' . $fileName;
    }

    public function read(): iterable
    {
        if (!file_exists($this->fileName)) {
            return [];
        }

        yield from file($this->fileName, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
    }
}
