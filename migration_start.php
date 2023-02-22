<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

const ROOT_DIR=__DIR__;
const DS=DIRECTORY_SEPARATOR;
const ENV='App';

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/engine/Function.php';

use \Engine\Core\Database\Connection;
use Engine\Core\Migration\Migrations;
use \Engine\Helper\Store;

$db = Connection::getInstance();

$sql = 'SHOW TABLES';
$tables = $db->setAll($sql);
$flag = true;
foreach ($tables as $table) {
    foreach ($table as $name) {
        if ($name === 'migrations') {
            $flag = false;
        }
    }
}

if ($flag) {
    (new Migrations())->start();
}

$migrations=Store::scanDir('migration');

foreach ($migrations as $migration){
    $m="\\Migration\\$migration";
    (new $m())->start();
}

echo "Success";
