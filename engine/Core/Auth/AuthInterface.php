<?php

namespace Engine\Core\Auth;

use App\Model\User\User;
use App\Request\LoginRequest;
use App\Request\RegRequest;

interface AuthInterface
{
    public function login(LoginRequest $request);

    public function logout(User $user);

    public function registration(RegRequest $request);

    public function resetPassword();

    public function update();
}