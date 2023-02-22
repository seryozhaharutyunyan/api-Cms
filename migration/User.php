<?php

namespace Migration;

use Engine\Core\Migration\Migration;

class User extends Migration
{

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
        $this->dropTable();
    }
}