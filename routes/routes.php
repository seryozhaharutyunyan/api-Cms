<?php
/**
 * list routes
 */

$this->router->add('api', '/', 'ApiController:index');
$this->router->add('login', '/login', 'AuthController:login', "POST");
$this->router->add('logout', '/logout/{id:int}', 'AuthController:logout');
$this->router->add('user', '/user/{id:int}', 'ApiController:user');
$this->router->add('api1', '/aaa', 'ApiController:store', 'DELETE');
$this->router->add('Product', '/product/{id:int}', 'ProductController:storeProduct', 'POST');

