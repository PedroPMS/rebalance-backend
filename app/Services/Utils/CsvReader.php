<?php

namespace App\Services\Utils;

class CsvReader
{
    private $file;

    public function __construct(string $fileName)
    {
        $this->file = fopen($fileName, 'r');
    }

    public function readAllFile(): iterable
    {
        while (!feof($this->file)) {
            yield fgetcsv($this->file);
        }
    }

    public function __destruct()
    {
        fclose($this->file);
    }
}
