<?php

namespace App\Request;

use Engine\Core\Request\Request;

class RegRequest extends Request
{

    protected function validated(): array
    {
        return [
            'email'=>'required|string|unique:user',
            'password'=>'required|string|confirmation',
            'confirmation_password'=>'required|string',
        ];
    }
}