<?php

namespace App\Controller;

use App\Model\User\User;
use Migration\User_add_ob_column;

class ApiController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index()
    {
       echo 'hello world';
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