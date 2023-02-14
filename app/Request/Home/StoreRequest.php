<?php

namespace App\Request\Home;

use Engine\Core\Request\Request;

class StoreRequest extends Request
{
    protected string $table='user';

    protected function validate(): array
    {
       return [
           'name'=>'required|int',
           'date'=>'nullable|date',
           'theme'=>'required|string'
       ];
    }
}