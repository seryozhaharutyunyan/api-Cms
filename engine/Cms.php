<?php

namespace Engine;

use App\Request\Home\StoreRequest;
use App\Request\ProductDotRequest;
use Engine\Core\Router\DispatchedRoute;
use Engine\Core\Router\Router;
use Engine\DI\DI;
use Engine\Helper\Common;

class Cms
{
    private DI $di;
    public Router $router;

    /**
     * @param DI $di
     */
    public function __construct(DI $di)
    {
        $this->di = $di;
        $this->router = $this->di->get('router');
    }

    /**
     * run app
     */
    public function run(): void
    {
        try {
            require_once __DIR__ . "/../routes/routes.php";

            $routerDispatch = $this->router->dispatch(Common::getMethod(), Common::getPathUrl());

            if ($routerDispatch === null) {
                $routerDispatch = new DispatchedRoute('ErrorController:page404');
            }

            [$class, $action] = \explode(':', $routerDispatch->get_controller(), 2);

            $controller = "\\" . ENV . "\\Controller\\" . $class;

            if ($class === 'ErrorController') {
                $controller = '\\Engine\\' . $class;
            }
            $parameters = $routerDispatch->get_parameters();
            $Controller = new $controller($this->di);
            if (!empty($_GET)) {
                $Controller->setGetParams($_GET);
            }

            $requestClass = $this->getRequestClass($controller, $action);

            if ($requestClass) {
                $parameters = [
                    new $requestClass($this->di),
                    $parameters
                ];
            }

            \call_user_func_array([$Controller, $action], $parameters);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * @throws \ReflectionException
     */
    private function getRequestClass($controller, $action): false|string
    {
        $r = new \ReflectionMethod($controller, $action);
        $params = $r->getParameters();
        foreach ($params as $param) {
            $type = (string)$param->getType();
            if (str_contains($type, 'App\\Request\\')) {
                return $type;
            }
        }
        return false;
    }
}