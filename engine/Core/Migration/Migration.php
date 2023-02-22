<?php

namespace Engine\Core\Migration;

use Engine\Core\Database\Connection;
use Engine\Core\Database\QueryBuilder;

abstract class Migration
{
    use MigrationBuilder;

    protected string $table;
    protected string $prefix = '';
    protected string $create = '';
    protected Connection $db;
    protected QueryBuilder $queryBuilder;


    public function __construct()
    {
        $className = \explode('\\', \get_class($this));
        $table = \strtolower($className[\count($className) - 1]);
        if (preg_match('/(^[a-z_]+)(-[a-z_]+)/', $table, $matches)) {
            $this->table = $matches[1];
            $this->prefix = $matches[2];
        } else {
            $this->table = $table;
        }

        $this->db = Connection::getInstance();

        $this->queryBuilder = new QueryBuilder();

        $this->create .= "CREATE TABLE $this->table (";
    }

    public abstract function start();

    public abstract function rollback();

    /**
     * @return string
     */
    public function getCreate(): string
    {
        return $this->create;
    }


}