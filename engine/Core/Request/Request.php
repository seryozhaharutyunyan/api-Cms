<?php

namespace Engine\Core\Request;

use Engine\Core\Config\Config;
use Engine\Core\Database\Connection;
use Engine\Core\Database\QueryBuilder;

abstract class Request
{
    protected array $get = [];
    protected array $post = [];
    protected array $put = [];
    protected array $patch = [];
    protected array $request = [];
    protected array $cookie = [];
    protected array $file = [];
    protected array $server = [];
    protected array $session = [];
    protected string $table;
    protected Connection $db;
    protected QueryBuilder $queryBuilder;
    protected ?int $id;


    /**
     * Request Constructor
     */
    public function __construct(int|null $id = null)
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->request = $_REQUEST;
        $this->cookie = $_COOKIE;
        $this->file = $_FILES;
        $this->server = $_SERVER;
        $this->session = $_SESSION;
        $this->put = file_get_contents('php://input');
        $this->patch = file_get_contents('php://input');

        $this->queryBuilder = new QueryBuilder();
        $this->db=new Connection();

        $this->id = $id;
    }

    abstract function validate(): array;

    protected function required(mixed $param, string $key): bool|string
    {

        if (!empty($param)) {
            return true;
        }
        return sprintf(Config::item('required', 'messages'), $key);;
    }

    protected function int(mixed $param, string $key): bool|string
    {
        if (is_int($param)) {
            return true;
        }
        return sprintf(Config::item('int', 'messages'), $key);
    }

    protected function array(mixed $param, string $key): bool|string
    {
        if (is_array($param)) {
            return true;
        }
        return sprintf(Config::item('array', 'messages'), $key);
    }

    protected function nullable(mixed $param): bool
    {
        return true;
    }

    protected function regex(mixed $param, string $pattern, string $key): bool|string
    {
        if (preg_match($pattern, $param)) {
            return true;
        }
        return sprintf(Config::item('regex', 'messages'), $key);
    }

    protected function date(mixed $param, string $key): bool|string
    {
        $test_data = preg_replace('/[^0-9\.]/u', '', $param);
        $test_data_ar = explode('.', $test_data);
        if (checkdate($test_data_ar[1], $test_data_ar[0], $test_data_ar[2])) {
            return true;
        }
        return sprintf(Config::item('date', 'messages'), $key);
    }

    protected function string(mixed $param, string $key): bool|string
    {
        if (is_string($param)) {
            return true;
        }
        return sprintf(Config::item('string', 'messages'), $key);
    }

    protected function bool(mixed $param, string $key): bool|string
    {
        if (is_bool($param)) {
            return true;
        }
        return sprintf(Config::item('bool', 'messages'), $key);
    }

    protected function unique(mixed $param, string $key): bool|string
    {
        $query=$this->queryBuilder
            ->select()
            ->from($this->table)
            ->where($key, $param)
            ->sql();

        $data=$this->db->set($query, $this->queryBuilder->values);

        if (!empty($data)){
            if($this->id===$data->id){
                return true;
            }
            return sprintf(Config::item('unique', 'messages'), $key);
        }else{
            return true;
        }
    }

    protected function max(mixed $param, int $length, string $key): bool|string
    {
        if (count($param) <= $length) {
            return true;
        }
        return sprintf(Config::item('max', 'messages'), $key, $length);
    }

    protected function min(mixed $param, int $length, string $key): bool|string
    {
        if (count($param) > $length) {
            return true;
        }
        return sprintf(Config::item('min', 'messages'), $key, $length);
    }

    protected function file(mixed $param, string $key): bool|string
    {
        if (is_file($param)) {
            return true;
        }
        return sprintf(Config::item('file', 'messages'), $key);
    }

    protected function exist(mixed $param, string $table, string $colum, string $key): bool|string
    {
        $query=$this->queryBuilder
            ->select()
            ->from($table)
            ->where($colum, $param)
            ->sql();

        $data=$this->db->set($query, $this->queryBuilder->values);

        if (!empty($data)) {
            return true;
        }
        return sprintf(Config::item('exist', 'messages'), $key, $table);
    }

}