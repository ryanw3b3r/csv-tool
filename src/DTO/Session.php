<?php

namespace CsvTool\DTO;

class Session
{
    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function flash(string $key)
    {
        echo $_SESSION[$key] ?? null;
        self::delete($key);
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
