<?php

declare(strict_types=1);

namespace App\Router;

use App\Router\Exception\ControllerMethodNotDefined;
use App\Router\Exception\ControllerNotFound;
use App\Router\Exception\NotFoundException;
use App\Router\Exception\WrongControllerDefinition;

class RouterMapper
{
    private array $routes = [];

    public function register(string $routeUrl, string $method, array $action): void
    {
        $this->routes[$routeUrl][$method] = $action;
    }

    public function get($routeUrl, array $action): void
    {
        $this->register($routeUrl, 'GET', $action);
    }

    public function post($routeUrl, array $action): void
    {
        $this->register($routeUrl, 'POST', $action);
    }

    public function handleRoute(string $routeUrl, string $method): void
    {
        $action = $this->routes[$routeUrl][$method];

        if (!$action) {
            throw new NotFoundException();
        }

        if (!is_array($action)) {
            throw new WrongControllerDefinition();
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = new $class();

            if (method_exists($class, $method)) {
                call_user_func_array([$class, $method], []);
            } else {
                throw new ControllerMethodNotDefined();
            }
        } else {
            throw new ControllerNotFound();
        }
    }
}