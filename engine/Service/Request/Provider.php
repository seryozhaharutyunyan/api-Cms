<?php

namespace Engine\Service\Request;

use Engine\Core\Request\Request;
use Engine\Core\Router\Router;
use Engine\Service\AbstractProvider;

class Provider extends AbstractProvider
{
    /**
     * @var string
     */
    public string $serviceName='request';

    public function init()
    {
        $request= new Request();

        $this->di->set($this->serviceName, $request);
    }
}