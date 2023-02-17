<?php

namespace App\Controller;

use App\Model\User\User;
use App\Request\Home\StoreRequest;
use Engine\Core\Auth\Auth;

class ApiController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        var_dump(Auth::authorized());
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