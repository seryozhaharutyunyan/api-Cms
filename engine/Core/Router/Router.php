<?php

namespace Engine\Core\Router;

final class Router
{

    private array $routes;
    private string $host;
    private ?UrlDispatcher $dispatcher = null;

    /**
     * @param $host
     */
    public function __construct($host)
    {
        $this->host = $host;
    }

    /**
     * @return array
     */
    public function get_routes(): array
    {
        return $this->routes;
    }

    /**
     * @param   string  $key
     * @param   string  $pattern
     * @param   string  $controller
     * @param   string  $method
     *
     * @return void
     */
    public function add(string $key, string $pattern, string $controller, string $method = 'GET'): void
    {
        $this->routes[$key] = [
            'pattern'    => $pattern,
            'controller' => $controller,
            'method'     => $method,
        ];
    }

    /**
     * @param $method
     * @param $uri
     *
     * @return DispatchedRoute|null
     */
    public function dispatch($method, $uri): ?DispatchedRoute
    {
        return $this->getDispatcher()->dispatch($method, $uri);
    }


    /**
     * @return UrlDispatcher
     */
    public function getDispatcher(): UrlDispatcher
    {
        if ($this->dispatcher === null) {
            $this->dispatcher = new UrlDispatcher();

            foreach ($this->routes as $route) {
                $this->dispatcher->register($route['method'], $route['pattern'], $route['controller']);
            }
        }

        return $this->dispatcher;
    }
}