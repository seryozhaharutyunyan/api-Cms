<?php

namespace App\Request;



use Engine\Core\Request\Request;

class ProductDotRequest extends Request
{
    protected function validated(): array
    {
        return [
            'test'=>'required'
        ];
    }
}