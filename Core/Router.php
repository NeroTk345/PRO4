<?php

namespace Core;

use Core\Middleware\Middleware;

class Router
{
    protected $routes = [];

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];
        return $this;
    }

    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        return $this;
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            // Check if URI matches with parameters
            $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^/]+)', $route['uri']);
            $pattern = "#^" . $pattern . "$#";
            
            if (preg_match($pattern, $uri, $matches) && $route['method'] === strtoupper($method)) {
                Middleware::resolve($route['middleware']);
                
                // Extract parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                // Check if it's a controller@method format
                if (strpos($route['controller'], '@') !== false) {
                    [$controller, $action] = explode('@', $route['controller']);
                    
                    // Build controller class name
                    $controllerClass = "App\\Http\\Controllers\\{$controller}";
                    
                    if (!class_exists($controllerClass)) {
                        throw new \Exception("Controller {$controllerClass} not found");
                    }
                    
                    $controllerInstance = new $controllerClass();
                    
                    if (!method_exists($controllerInstance, $action)) {
                        throw new \Exception("Method {$action} not found in controller {$controllerClass}");
                    }
                    
                    // Call controller method with parameters
                    return call_user_func_array([$controllerInstance, $action], $params);
                } else {
                    // Old style - file based routing (for backward compatibility)
                    // FIXED: Changed 'controller' to 'Controllers' with capital C and plural
                    return require base_path('Http/Controllers/' . $route['controller']);
                }
            }
        }

        $this->abort();
    }

    protected function abort($code = 404)
    {
        http_response_code($code);
        require base_path("views/{$code}.php");
        die();
    }
}