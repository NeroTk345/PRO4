<?php

namespace Core\Middleware;

use Exception;

class Middleware
{
    public const MAP = [
        'guest' => Guest::class,
        'auth' => Authenticated::class,
    ];

    public static function resolve($key)
    {
        if (!$key) {
            return;
        }
        $Middleware = static::MAP[$key] ?? false;

        if (!$Middleware) {
            throw new Exception("Not the right middle ware that corresponds with the key" . $key);
        }

        (new $Middleware)->handle();
    }
}