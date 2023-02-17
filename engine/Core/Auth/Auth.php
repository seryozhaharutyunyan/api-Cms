<?php

namespace Engine\Core\Auth;

use App\Model\User\User;
use Engine\Helper\Cookie;
use Engine\Helper\Session;

class Auth
{
    protected static ?int $id = null;

    /**
     * @return bool
     */
    public static function authorized(): bool
    {
        if(Session::get('auth_authorized')){
            return Session::get('auth_authorized');
        }

        if (Cookie::get('auth_authorized')){
            return Cookie::get('auth_authorized');
        }
        return false;
    }

    /**
     * @return string|null
     */
    public static function hashUser(): string|null
    {
        if(Session::get('auth_user')){
            return Session::get('auth_user');
        }
        return Cookie::get('auth_user');
    }


    /**
     * @param int $id
     * @param string $method
     * @return void
     */
    public static function authorize(int $id, string $method = 'cookie'): void
    {
        if ($method === 'session') {
            Session::set('auth_authorized', true);
            Session::set('auth_user', $id);
        } else {
            Cookie::set('auth_authorized', true);
            Cookie::set('auth_user', $id);
        }
    }

    /**
     * @return void
     */
    public static function unAuthorize(string $method='cookie'): void
    {
        if ($method === 'session') {
            Session::delete('auth_authorized');
            Session::delete('auth_user');
        } else {
            Cookie::delete('auth_authorized');
            Cookie::delete('auth_user');
        }
    }

    /**
     * @return string
     */
    public static function salt(): string
    {
        return (string)rand(1000000000, 9999999999);
    }

    /**
     * @param string $password
     * @param string $salt
     *
     * @return bool|string
     */
    public static function encryptPassword(string $password, string $salt = ""): bool|string
    {
        return hash('sha256', $password . $salt);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public static function createToken(): string
    {
        return bin2hex(random_bytes(64));
    }

    /**
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public static function addToken(User $user): string
    {
        $token = Auth::createToken();
        if ($token) {
            $user->setToken($token);
            $user->save();
            Auth::authorize($user->getId(), \Config::item('saveMethod'));
        }

        return $token;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public static function deleteToken(User $user): void
    {
        $user->setToken(null);
        $user->save();
        Auth::unAuthorize(\Config::item('saveMethod'));
    }
}