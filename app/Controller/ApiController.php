<?php

namespace App\Controller;

class ApiController extends Controller
{
    public function index(){

        $this->response->setData(['aa'=>111])->send(200);
    }

    public function store(){
        $this->response->setData(['aa2'=>111])->send(200);

    }

}