<?php

namespace CsvTool\System;

class CSV
{
    public static function fromUpload()
    {
        if (!isset($_FILES['csv_file']) ||
            $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK
        ) {
            throw new \RuntimeException('Error uploading file!');
        }

        return self::from($_FILES['csv_file']['tmp_name']);
    }

    public static function from($filepath): array
    {
        $summary = [];

        if (($handle = fopen($filepath, 'r')) === false) {
            throw new \RuntimeException('Unable to open the file.');
        }

        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) !== 3) {
                continue;
            }

            [$category, $price, $amount] = $data;

            if (!is_numeric($price) || !is_numeric($amount)) {
                continue;
            }

            $category = preg_replace('/[^a-zA-Z0-9 ._-]/', '', $category);
            $category = preg_replace('/\s+/', ' ', trim($category));
            $price = (float) $price;
            $amount = (float) $amount;

            if (!isset($summary[$category])) {
                $summary[$category] = 0;
            }

            $summary[$category] += $price * $amount;
        }

        fclose($handle);

        if (empty($summary)) {
            throw new \RuntimeException('No valid data found.');
        }

        return $summary;
    }

    public static function download($summary): bool
    {
        if (! $summary) {
            return false;
        }

        self::sendFile($summary);

        return true;
    }

    public static function formatValue(float $value): string|int
    {
        return (int) $value == $value ?
            (int) $value :
            number_format($value, 2, '.', '');
    }

    protected static function sendFile(array $summary)
    {
        $tstamp = date('Y-m-d-H-i-s');

        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=summary-{$tstamp}.csv");

        $output = fopen('php://output', 'w');

        foreach ($summary as $category => $total) {
            fputcsv($output, [$category, CSV::formatValue($total)]);
        }

        fclose($output);
    }
}
