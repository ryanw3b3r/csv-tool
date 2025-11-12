<?php

namespace CsvTool\Controllers;

use CsvTool\DTO\Session;
use CsvTool\DTO\View;
use CsvTool\System\CSV;

class UploadController
{
    public function __invoke()
    {
        try {
            Session::set('summary', CSV::fromUpload());
        } catch (\Throwable $e) {
            Session::set('error', $e->getMessage());
        }

        View::make('index');
    }
}
