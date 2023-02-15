<?php

namespace App\Request\Home;

use Engine\Core\Request\Request;

class StoreRequest extends Request
{
    protected function validated(): array
    {
       return [
           'name'=>'required|string',
           'date'=>'nullable|date',
           'theme'=>'nullable|string',
           'file'=>'nullable|array|file'
       ];
    }
}