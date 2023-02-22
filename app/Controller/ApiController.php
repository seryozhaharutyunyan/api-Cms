<?php

namespace App\Controller;

use App\Model\User\User;
use App\Request\Home\StoreRequest;
use Engine\Core\Migration\Migration;
use Engine\Core\Migration\Migrations;
use Engine\Helper\Mail;
use Engine\Helper\Store;
use Migration\User_add_ob_column;
use Migration\users;

class ApiController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        $m= new User_add_ob_column();
        $m->start();
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