<?php

class Router {
    private $routes = [];

    public function add($method, $path, $callback) {
        $this->routes[] = compact('method', 'path', 'callback');
    }

    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = strtok($_SERVER['REQUEST_URI'], '?');

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                return call_user_func($route['callback']);
            }
        }

        Response::json(['erro' => 'Rota não encontrada'], 404);
    }
}
