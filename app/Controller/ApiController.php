<?php

namespace App\Controller;

use App\Model\User\User;
use App\Request\Home\StoreRequest;
use Engine\Core\Auth\Auth;
use Engine\Helper\Session;

class ApiController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        var_dump($_SESSION);
        //$this->response->setData($_SESSION)->send();
    }

    public function store()
    {
        $this->response->setData(['aa2' => 111])->send(200);
    }

    public function user(User $user)
    {
        echo $user->getEmail();
    }

}