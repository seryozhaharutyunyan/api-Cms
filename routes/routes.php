<?php
/**
 * list routes
 */

$this->router->add('api', 'get', '/', 'ApiController:index');
$this->router->add('login', "POST", '/login', 'AuthController:login');
$this->router->add('registration', "POST", '/reg', 'AuthController:registration');
$this->router->add('logout', 'get', '/logout/{id:int}', 'AuthController:logout');
$this->router->add('user', 'GET', '/user/{id:int}', 'ApiController:user');
$this->router->add('api1', 'DELETE', '/aaa', 'ApiController:store');
$this->router->add('Product', 'POST', '/product/{id:int}', 'ProductController:storeProduct');

