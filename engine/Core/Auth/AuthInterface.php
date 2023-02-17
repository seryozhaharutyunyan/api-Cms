<?php

namespace Engine\Core\Auth;

use App\Model\User\User;
use App\Request\LoginRequest;

interface AuthInterface
{
    public function login(LoginRequest $request);

    public function logout(User $user);

    public function registration();

    public function resetPassword();

    public function update();
}