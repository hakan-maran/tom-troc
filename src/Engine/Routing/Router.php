<?php

namespace TomTroc\Engine\Routing;

use TomTroc\Engine\Routing\BadParameterException;

/**
 * @todo Need a big refactorisation
 */
class Router
{
    private array $routes = [];
    private string $action = '';
    private array $errorRoutes = [];

    public function __construct(string $action, array $routes)
    {
        $this->action = $action;
        $this->routes = $routes;
    }

    public function errorRoutes(array $errorRoutes)
    {
        $this->errorRoutes = $errorRoutes;
    }

    public function route()
    {
        foreach ($this->routes as $route) {
            if ($route->action() === $this->action and $this->requestIs($route->verb())) {
                if ($route->hasParameters() and !$this->parametersMatch($route->parameters())) {
                    throw new BadParameterException('Les paramètres de la route ne correspondent pas à ceux de la requête');
                }
                if ($route->hasMiddlewares()) {
                    $this->callMiddlewares($route->middlewares());
                }
                return $this->callController($route->controller(), $route->method(), $route->parameters());
            }
        }
        foreach ($this->errorRoutes as $route) {
            if ($route->action() === $this->action and $this->requestIs('GET')) {
                http_response_code($this->action);
                return $this->callController($route->controller(), $route->method());
            }
        }
        return header('location: index.php?action=404');
    }

    private function parametersMatch(array $parameters)
    {
        // Merge GET and POST so query parameters (like id) are available on POST requests
        $source = array_merge($_GET, $_POST);
        foreach ($parameters as $parameter => $constraints) {
            if (is_string($constraints)) {
                $parameter = $constraints;
            }
            if ($this->parameterIsRequired($constraints) and empty($source[$parameter])) {
                return false;
            }
            if (!$this->parameterHasGoodFormat($parameter, $constraints, $source)) {
                return false;
            }
        }
        return true;
    }
    private function callMiddlewares(array $middlewares)
    {
        foreach ($middlewares as $middleware => $method) {
            $middleware = new $middleware();
            $middleware->$method();
        }
    }

    private function callController(string $controller, string $method, array $parameters = [])
    {
        if (!method_exists($controller, $method)) {
            throw new \InvalidArgumentException('Impossible d\'appeler la méthode du contrôleur');
        }
        $controller = new $controller();

        // Extraire les paramètres de la requête (GET ou POST selon la méthode HTTP)
        $requestParams = [];
        // Ensure parameters are read from both GET and POST (query string preserved)
        $source = array_merge($_GET, $_POST);
        foreach ($parameters as $param => $constraints) {
            if (is_string($param)) {
                $requestParams[$param] = $source[$param] ?? null;
            }
        }

        // Appeler la méthode avec les paramètres si nécessaire
        if (!empty($requestParams)) {
            $controller->$method(...array_values($requestParams));
        } else {
            $controller->$method();
        }
    }

    private function requestIs(string $verb): bool
    {
        return $_SERVER['REQUEST_METHOD'] === $verb;
    }

    private function parameterIsRequired(array|string $constraints): bool
    {
        if (!is_array($constraints)) {
            return true;
        }
        // Le paramètre est requis s'il n'y a pas required OU que required est true
        return !isset($constraints['required']) || $constraints['required'];
    }

    private function parameterHasGoodFormat(string $parameter, array|string $constraints, array $source = []): bool
    {
        if (empty($source)) {
            $source = $_GET;
        }

        if (is_array($constraints) and isset($constraints['format']) and !empty($source[$parameter])) {
            return preg_match('/^' . $constraints['format'] . '$/', $source[$parameter]);
        }

        return true;
    }
}
