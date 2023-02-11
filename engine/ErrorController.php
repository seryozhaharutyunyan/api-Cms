<?php

namespace Engine;

class ErrorController extends Controller
{

    public function page404()
    {
        $this->response->send(404);
    }
}