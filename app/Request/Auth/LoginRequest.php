<?php

namespace App\Request\Auth;

use Engine\Core\Request\Request;

class LoginRequest extends Request
{

    protected function validated(): array
    {
        return [
            'email'=>'required|string|email|exist:user,email',
            'password'=>'required|string'
        ];
    }
}