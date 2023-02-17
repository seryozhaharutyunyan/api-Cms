<?php

namespace Engine;

use App\Model\User\User;
use Engine\Core\Auth\Auth;
use Engine\Core\Database\Connection;
use Engine\Core\Database\QueryBuilder;
use Engine\Core\Response\Response;
use Engine\Core\Template\View;
use Engine\DI\DI;

abstract class Controller
{
    protected DI $di;
    protected mixed $get=[];
    protected Connection $db;
    protected array $config;
    protected QueryBuilder $query;
    protected Load $load;
    protected Response $response;
    //protected View $view;

    /**
     * @param DI $di
     */
    public function __construct(DI $di)
    {
        $this->di = $di;
        $this->db = Connection::getInstance();
        $this->config = $this->di->get('config');
        $this->load = $this->di->get('load');
        $this->response = $this->di->get('response');
        //$this->view=$this->di->get('view');

        $this->initVars();

        $this->query= new QueryBuilder();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->di->get($key);
    }

    /**
     * @return mixed
     */
    public function getGetParams(): mixed
    {
        return $this->get;
    }

    /**
     * @param mixed $get
     */
    public function setGetParams(mixed $get): void
    {
        $this->get = $get;
    }

    protected function rout($key)
    {
        $routers = $this->di->get('router')->get_routes();

        foreach ($routers as $k => $router) {
            if ($key === $k) {
                return $router['pattern'];
            }
        }
    }

    /**
     * @return $this
     */
    public function initVars(): static
    {
        $vars=array_keys(get_object_vars($this));

        foreach ($vars as $var){
            if($this->di->has($var)){
                $this->{$var}=$this->di->get($var);
            }
        }

        return $this;
    }

    protected function updateToken(int $id, string $token): string|null
    {
        $user = new User($id);

        if ($user->getToken() === $token) {
            $tokenNew = Auth::createToken();
            if ($tokenNew) {
                $user->setToken($tokenNew);
                $user->save();
                Auth::unAuthorize('session');
                Auth::authorize($tokenNew, 'session');
            }

            return $tokenNew;
        }

        return null;
    }
}