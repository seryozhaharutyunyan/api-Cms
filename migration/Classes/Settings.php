<?php

namespace Migration\Classes;

use Engine\Core\Migration\Migration;

class Settings extends Migration
{
    protected string $table='settings';

    /**
     * @return void
     */
    public function start(): void
    {
        $this->id()
            ->varchar('language', 4)
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