<?php

namespace App\Controller;

use App\Model\User\User;
use App\Request\Home\StoreRequest;
use Engine\Helper\Store;

class ApiController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index(StoreRequest $request)
    {
        $data=$request->validate();

        $phat=Store::saveFile('user', $data['file'][0]);

        $this->response->setData($phat)->send();
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