<?php

namespace Engine\Core\Migration;

class Migrations extends Migration
{

    public function start()
    {
        $this->id()
            ->varchar('name', 255)->unique()
            ->createAt()
            ->get();
    }

    public function rollback()
    {
        $this->dropTable()->get();
    }
}