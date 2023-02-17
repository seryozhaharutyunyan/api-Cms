<?php

namespace App\Request;

use Engine\Core\Request\Request;

class LoginRequest extends Request
{

    protected function validated(): array
    {
        return [
            'email'=>'required|string|exist:user,email',
            'password'=>'required|string'
        ];
    }
}