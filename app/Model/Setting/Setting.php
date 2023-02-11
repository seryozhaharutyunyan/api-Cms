<?php

namespace App\Model\Setting;

use Engine\Core\Database\ActiveRecord;

class Setting
{
    use ActiveRecord;

    protected string $table = 'setting';
    protected int $id;
    private string $name;
    private string $key_field;
    private string $value;


    public function getId(): int
    {
        return $this->id;
    }


    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function getKeyField(): string
    {
        return $this->key_field;
    }

    public function setKeyField($key_field): void
    {
        $this->key_field = $key_field;
    }
}