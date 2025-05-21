<?php

namespace Core;

class Response
{
    const NOT_FOUND = 404;
    const FORBIDDEN = 403;

    public static function view($view, $data = [])
    {
        extract($data);
        $viewPath = base_path("views/{$view}.php");

        if (!file_exists($viewPath)) {
            http_response_code(self::NOT_FOUND);
            die("View not found: {$view}");
        }

        require $viewPath;
    }
}