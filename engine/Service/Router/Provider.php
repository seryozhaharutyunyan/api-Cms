<?php

namespace Engine\Service\Router;

use Engine\Core\Config\Config;
use Engine\Core\Router\Router;
use Engine\Service\AbstractProvider;

class Provider extends AbstractProvider
{
    /**
     * @var string
     */
    public string $serviceName='router';

    /**
     * @throws \Exception
     */
    public function init()
    {
        $db= new Router(Config::item('base_url'));

        $this->di->set($this->serviceName, $db);
    }
}