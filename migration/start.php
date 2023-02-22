<?php
require_once __DIR__ . '/../engine/MigrationBootstrap.php';

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

$migrations=Store::scanDir('..\\migration\\Classes');
ksort($migrations);

foreach ($migrations as $migration){
    $m="\\Migration\\Classes\\$migration";
    (new $m())->start();
}

echo "Success";
