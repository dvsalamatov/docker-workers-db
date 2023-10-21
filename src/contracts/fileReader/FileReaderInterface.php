<?php

namespace contracts\fileReader;

interface FileReaderInterface
{
    public function read(): Iterable;
}
