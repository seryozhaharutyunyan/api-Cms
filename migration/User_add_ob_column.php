<?php

namespace Migration;

use Engine\Core\Migration\Migration;

class User_add_ob_column extends Migration
{
    protected string $table='users';

    public function start()
    {
        $this->addColumn()
            ->varchar('ob', 15)
            ->get();
    }

    public function rollback()
    {
        $this->dropColumn('ob')
            ->get();
    }
}