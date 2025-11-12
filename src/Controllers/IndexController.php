<?php

namespace CsvTool\Controllers;

use CsvTool\DTO\View;

class IndexController
{
    public function __invoke()
    {
        View::make('index');
    }
}
