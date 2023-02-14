<?php

namespace App\Controller;

use App\Request\Home\StoreRequest;

class ApiController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index(){

        $request=new StoreRequest($this->di);

        $request=$request->init();

        $this->response->setData($request)->send(200);
    }

    public function store(){
        $this->response->setData(['aa2'=>111])->send(200);

    }

}