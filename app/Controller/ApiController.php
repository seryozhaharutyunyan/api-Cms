<?php

namespace App\Controller;

use App\Model\User\User;
use App\Request\Home\StoreRequest;
use Engine\Helper\Mail;
use Engine\Helper\Store;

class ApiController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        echo Mail::send('admin@mai.ru', 'Hello', 'Password');
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