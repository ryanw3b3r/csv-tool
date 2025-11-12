<?php

namespace CsvTool\System;

use CsvTool\DTO\Route;

class Router
{
    protected static $routes;

    public function __construct()
    {
        if (! file_exists(self::getRoutesFilePath())) {
            throw new \Exception(
                'Routes file cannot be found! Please configure in /config/routes.php'
            );
        }

        self::$routes = require_once(self::getRoutesFilePath());
    }

    public function process()
    {
        $action = $this->get($this->getCurrentPath());

        if ($action->method !== $this->getCurrentMethod()) {
            throw new \Exception("Incorrect method called on path!");
        }

        if (class_exists($action->controller)) {
            $controller = new $action->controller;

            if (is_callable($controller)) {
                return $controller();
            }
            
            throw new \Exception(
                "Controller found but it doesn't have an __invoke method!"
            );
        }

        throw new \Exception("Controller and/or method doesn't exist!");       
    }

    public function routes(string $key = ''): bool|array|Route
    {
        if ($key) {
            return self::$routes[$key] ?? false;
        }

        return self::$routes;
    }

    public function getCurrentUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getCurrentMethod(): string
    {
        return mb_strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function getCurrentPath(): string
    {
        return $this->normalizePath($this->getCurrentUri());
    }

    public function get(string $path): Route
    {
        return $this->routes($path) ?: throw new \Exception("Path $path doesn't exist!");
    }

    protected function normalizePath(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = rtrim($path, '/');

        return $path === '' ? '/' : $path;
    }

    protected static function getRoutesFilePath(): string
    {
        return CONFIG_DIR . '/routes.php';
    }

    protected function pathExists(string $path): bool
    {
        return $this->routes($path);
    }

    protected function unknownPath(string $path): bool
    {
        return ! $this->routes($path);
    }
}
