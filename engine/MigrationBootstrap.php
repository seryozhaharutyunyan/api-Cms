<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

const ROOT_DIR=__DIR__;
const DS=DIRECTORY_SEPARATOR;
const ENV='App';

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Function.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__.'../'));
$dotenv->load();


