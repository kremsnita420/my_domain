<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, array $controller): void
    {
        $path = $this->normalizePath($path);
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller

        ];
    }

    private function normalizePath(string $path)
    {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);

        return $path;
    }

    public function dispatch(string $path, string $method)
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            $pattern = "#^{$route['path']}$#";
            
            if (!preg_match($pattern, $path) || $route['method'] !== $method) {
                continue;
            }
            
            [$class, $function] = $route['controller'];
            $controllerInstance = new $class;
            $controllerInstance->$function();
        }
        
    }
}
