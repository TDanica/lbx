<?php

namespace App\Services;

use App\Jobs\ProcessCsvDataJob;

class CsvService
{
    const CHUNK_SIZE = 1000;

    public function processCsv($filePath)
    {
        $file = fopen($filePath, 'r');
        if (!$file) {
            throw new \Exception("Unable to open file: $filePath");
        }

        $header = fgetcsv($file);
        $columnNames = $header ? $header : [];

        while (!feof($file)) {
            $chunk = [];
            for ($i = 0; $i < self::CHUNK_SIZE && !feof($file); $i++) {
                $line = fgetcsv($file);
                if ($line !== false) {
                    $chunk[] = $line;
                }
            }

            if (!empty($chunk)) {
                $this->dispatchCsvProcessingJob($chunk, $columnNames);
            }
        }

        fclose($file);
    }

    private function dispatchCsvProcessingJob(array $data, array $columnNames)
    {
        dispatch(new ProcessCsvDataJob($data, $columnNames));
    }
}
