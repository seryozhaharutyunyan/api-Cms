<?php
require_once __DIR__ . '/Bootstrap.php';

use \Engine\Core\Database\Connection;
use Engine\Core\Database\QueryBuilder;
use Engine\Core\Migration\Migrations;
use \Engine\Helper\Store;

$db = Connection::getInstance();
$queryBuilder = new QueryBuilder();

$sql = $sql = 'SHOW TABLES';
$tables = $db->setAll($sql);
$flag = false;

foreach ($tables as $table) {
    foreach ($table as $name) {
        if ($name === 'migrations') {
            $sql = $queryBuilder->select()
                ->from('migrations')
                ->sql();
            $migrations = $db->setAll($sql);
        }
    }
}

fwrite(STDERR, "Migration name \n");
$migrationName = fgets(STDIN);
$migrationName = trim($migrationName);
if (isset($migrations) && !empty($migrations)) {
    foreach ($migrations as $migration) {
        if ($migrationName === $migration->name) {
            $flag = true;
        }
    }
}

if(isset($migrations) && empty($migrations) && $migrationName==='all'){
    (new Migrations())->rollback();
    echo "Success";
    exit();
}

$migrationName = ucfirst($migrationName);
if ($flag) {
    if ($migrationName === 'All') {
        $migrations = Store::scanDir('Classes');
        krsort($migrations);

        foreach ($migrations as $migration) {
            $m = "\\Migration\\Classes\\$migration";
            (new $m())->rollback();
        }

        (new Migrations())->rollback();
    } else {
        $m = "\\Migration\\Classes\\$migrationName";
        (new $m())->rollback();
    }

    echo "Success";
} else {
    echo 'No such migration exists';
}

