<?php

namespace CsvTool\Controllers;

use CsvTool\DTO\Session;
use CsvTool\System\CSV;

class DownloadController
{
    public function __invoke()
    {
        try {
            if (CSV::download(Session::get('summary'))) {
                Session::delete('summary');
                return;
            }
            throw new \RuntimeException('Something went wrong!');
        } catch (\Throwable $e) {
            Session::set(
                'error',
                'No summary data to export. ' . $e->getMessage()
            );
            header('Location: /');
        }
    }
}
