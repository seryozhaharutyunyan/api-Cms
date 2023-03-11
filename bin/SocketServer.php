<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

const DS = DIRECTORY_SEPARATOR;
define("ROOT_DIR", substr(__DIR__, 0, strrpos(__DIR__, DS,)));

require_once ROOT_DIR . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__.'../'));;
$dotenv->load();
$clientName="\\App\\SocketClient\\".$_ENV['clientName'];
$client=new $clientName();
$server=new \Engine\Core\Socket\Server($client);

$server->run();
