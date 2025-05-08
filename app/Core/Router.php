<?php

namespace App\Core;

class Router {
    protected $routes = [];

    public function add($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['path'] === $uri && $route['method'] === $method) {
                $controller = new $route['controller']();
                $action = $route['action'];
                return $controller->$action();
            }
        }

        // Handle 404
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
} 