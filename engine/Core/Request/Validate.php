<?php

namespace Engine\Core\Request;

use Engine\Core\Config\Config;

trait Validate
{
    protected function required(mixed $param, string $key): bool|string
    {

        if (!empty($param)) {
            return true;
        }
        return sprintf(Config::item('required', 'messages'), $key);
    }

    protected function int(mixed $param, string $key): bool|string
    {
        if (is_int($param)) {
            return true;
        }
        return sprintf(Config::item('int', 'messages'), $key);
    }

    protected function nullable(): bool
    {
        return  true;
    }


    protected function array(mixed $param, string $key): bool|string
    {
        if (is_array($param)) {
            return true;
        }
        return sprintf(Config::item('array', 'messages'), $key);
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

        if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/u', $param)) {
            $date = explode('-', $param);
        }

        if (preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}/u', $param)) {
            $date = array_reverse(explode('.', $param));
        }

        if (checkdate($date[1], $date[2], $date[0])) {
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
        $query = $this->queryBuilder
            ->select()
            ->from($this->table)
            ->where($key, $param)
            ->sql();

        $data = $this->db->set($query, $this->queryBuilder->values);

        if (!empty($data)) {
            if ($this->id === $data->id) {
                return true;
            }
            return sprintf(Config::item('unique', 'messages'), $key);
        } else {
            return true;
        }
    }

    protected function max(mixed $param, mixed $length, string $key): bool|string
    {
        if (strlen($param) <= (int)$length) {
            return true;
        }
        return sprintf(Config::item('max', 'messages'), $key, $length);
    }

    protected function min(mixed $param, mixed $length, string $key): bool|string
    {
        if (strlen($param) > (int)$length) {
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
        $query = $this->queryBuilder
            ->select()
            ->from($table)
            ->where($colum, $param)
            ->sql();

        $data = $this->db->set($query, $this->queryBuilder->values);

        if (!empty($data)) {
            return true;
        }
        return sprintf(Config::item('exist', 'messages'), $key, $table);
    }
}