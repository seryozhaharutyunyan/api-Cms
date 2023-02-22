<?php

namespace Migration;

use Engine\Core\Migration\Migration;

class Users extends Migration
{
    protected string $table='users';

    /**
     * @return void
     */
    public function start(): void
    {
        $this->id()
            ->varchar('email')
            ->varchar('password')
            ->enum('role', ['admin', 'user'])->defaultValue('admin')
            ->text('token')->nullable()
            ->createAt()
            ->get();
    }

    /**
     * @return void
     */
    public function rollback(): void
    {
        $this->dropTable()->get();
    }
}