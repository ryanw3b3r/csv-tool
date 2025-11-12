<?php

namespace CsvTool\DTO;

class Route
{
    protected string $method = 'GET';
    protected string $controller;

    public function __construct(array $data = [])
    {
        if ($data) {
            $this->setMethod($data['method'] ?? 'GET');
            $this->setController(
                $data['controller'] ??
                throw new \Exception('Controller not specified!')
            );
        }
    }

    public function __get(string $key)
    {
        return $this->$key;
    }

    public function setMethod(string $method): self
    {
        $this->method = mb_strtoupper($method);

        return $this;
    }

    public function setController(string $controller): self
    {
        $this->controller = $controller;

        return $this;
    }
}
