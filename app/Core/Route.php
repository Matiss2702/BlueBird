<?php

namespace App\Core;

use App\Middlewares\AccountMiddleware;

class Route
{
    private string $uri;
    private string $method;
    private array $params;
    private string $controller;
    private string $action;
    private array $middlewares = [];

    public function __construct(string $uri, string $method, string $controller, string $action)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function addMiddleware(string $middleware, array $constructorParams = [], array $handleParams = []): void
    {
        $this->middlewares[] = [
            'middleware'        => $middleware,
            'constructorParams' => $constructorParams,
            'handleParams'      => $handleParams,
        ];
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function match(string $requestUri, string $requestMethod): bool
    {
        if ($this->method !== $requestMethod) {
            return false;
        }

        $routeUriParts = explode('/', trim($this->uri, '/'));
        $requestUriParts = explode('/', trim($requestUri, '/'));

        if (count($routeUriParts) !== count($requestUriParts)) {
            return false;
        }

        $params = [];

        for ($i = 0; $i < count($routeUriParts); $i++) {
            if (strpos($routeUriParts[$i], '{') === 0
            &&  strpos($routeUriParts[$i], '}') === strlen($routeUriParts[$i]) - 1) {
                $paramName = trim($routeUriParts[$i], '{}');
                $paramValue = $requestUriParts[$i];
                $params[$paramName] = $paramValue;
            } elseif ($routeUriParts[$i] !== $requestUriParts[$i]) {
                return false;
            }
        }

        $this->params = $params;

        return true;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action . 'Action';
    }
}
