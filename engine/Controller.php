<?php

namespace Engine;

use Engine\Core\Config\Config;
use Engine\Core\Database\Connection;
use Engine\Core\Database\QueryBuilder;
use Engine\Core\Request\Request;
use Engine\Core\Response\Response;
use Engine\Core\Template\View;
use Engine\DI\DI;

abstract class Controller
{
    protected DI $di;
    protected mixed $get=[];
    protected Connection $db;
    protected array $config;
    protected Request $request;
    protected QueryBuilder $query;
    protected Load $load;
    protected Response $response;

    /**
     * @param DI $di
     */
    public function __construct(DI $di)
    {
        $this->di = $di;
        $this->db = $this->di->get('db');
        $this->config = $this->di->get('config');
        $this->request = $this->di->get('request');
        $this->load = $this->di->get('load');
        $this->response = $this->di->get('response');

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
}