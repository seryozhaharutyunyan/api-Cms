<?php

namespace App\Model\User;

use Engine\Core\Database\ActiveRecord;

class User
{
    use ActiveRecord;


    protected string $table = 'user';
    protected int $id;
    private string $email;
    private string $password;
    private string $role;
    private string $hash;
    private string $date_reg;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getDateReg(): string
    {
        return $this->date_reg;
    }

    /**
     * @param mixed $date_reg
     */
    public function setDateReg(string $date_reg): void
    {
        $this->date_reg = $date_reg;
    }
}