<?php

namespace CsvTool\DTO;

class View
{
    public static function __callStatic(string $name, array $arguments)
    {
        return (new self())->render($arguments[0]);
    }

    public function render(string $filename)
    {
        require_once VIEW_DIR . "/{$filename}.php";
    }
}
