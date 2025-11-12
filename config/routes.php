<?php

use CsvTool\Controllers\IndexController;
use CsvTool\Controllers\UploadController;
use CsvTool\Controllers\DownloadController;
use CsvTool\DTO\Route;

return [
    '/' => new Route([
        'method' => 'GET',
        'controller' => IndexController::class,
    ]),

    '/upload' => (new Route())
        ->setMethod('POST')
        ->setController(UploadController::class),

    '/download' => (new Route())
        ->setController(DownloadController::class),
];