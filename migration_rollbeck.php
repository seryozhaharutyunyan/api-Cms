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

fwrite(STDERR, "Migration name \n");
$migrationName = fgets(STDIN);
$migrationName=ucfirst(trim($migrationName));

if($migrationName==='All'){
    $migrations=Store::scanDir('migration');
    krsort($migrations);

    foreach ($migrations as $migration){
        $m="\\Migration\\$migration";
        (new $m())->rollback();
    }

    (new Migrations())->rollback();
}else{
    $m="\\Migration\\$migrationName";
    (new $m())->rollback();
}

echo "Success";
