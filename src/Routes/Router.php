<?php

namespace Ganesh\PhpRestApi\Routes;

class Router
{
    private $routes;

    public $baseRoute = '/api/v1/';

    public function register($requestMethod, $route, $action)
    {
        $route = $this->baseRoute . trim($route, '/');

        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route, $action)
    {
        return $this->register('GET', $route, $action);
    }

    public function post(string $route, $action)
    {
        return $this->register('POST', $route, $action);
    }

    public function delete(string $route, $action)
    {
        return $this->register('DELETE', $route, $action);
    }

    public function update(string $route, $action)
    {
        return $this->register('UPDATE', $route, $action);
    }

    public function put(string $route, $action)
    {
        return $this->register('PUT', $route, $action);
    }

    public function patch(string $route, $action)
    {
        return $this->register('PATCH', $route, $action);
    }

    public function routes()
    {
        return $this->routes;
    }

    public function resolve($requestUri, $requestMethod)
    {
        $route = rtrim(explode('?', $requestUri)[0], '/');

        $action = null;

        foreach ($this->routes[$requestMethod] as $routePattern => $actionCallback) {
            // Convert the route pattern to a regular expression
            $routePattern = str_replace('/', '\/', $routePattern);
            $routePattern = preg_replace('/:[^\s\/]+/', '([^\/]+)', $routePattern);
            $routePattern = '/^' . $routePattern . '$/';

            // If the request URI matches the route pattern, extract the URL parameters
            if (preg_match($routePattern, $route, $matches)) {
                $params = array_slice($matches, 1);
                $action = $actionCallback;
                break;
            }
        }

        if (!$action) {
            sendResponse(404, false, '404 Page not found ', []);
        }

        if (is_array($action) && count($action) == 2 && is_string($action[1])) {
            // If the action is an array, assume it's a class method
            [$class, $method] = $action;

            if (class_exists($class)) {
                $class = new $class();

                if (method_exists($class, $method)) {
                    // Pass the parameters to the method
                    return call_user_func_array([$class, $method], $params ?? []);
                }
            }
        } else {
            // If the action is a callable function, just call it
            return call_user_func($action);
        }

        sendResponse(404, false, '404 Page not found ', []);
    }
}
