<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use CsvTool\System\Application;

(new Application)->start();
