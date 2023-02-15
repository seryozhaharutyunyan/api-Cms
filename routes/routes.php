<?php
/**
 * list routes
 */

$this->router->add('api', '/', 'ApiController:index', "PUT");
$this->router->add('api1', '/aaa', 'ApiController:store', 'DELETE');
$this->router->add('Product', '/product/{id:int}', 'ProductController:storeProduct', 'POST');

