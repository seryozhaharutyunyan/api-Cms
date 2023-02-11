<?php

namespace Engine\Core\Auth;

use Engine\Helper\Cookie;
use Engine\Helper\Session;

class Auth implements AuthInterface
{
    protected bool $authorized = false;
    protected ?string $hash_user = null;

    /**
     * @return bool
     */
    public function authorized(): bool
    {
        return $this->authorized;
    }

    /**
     * @return string|null
     */
    public function hashUser(): string|null
    {
        if(Session::get('auth_user')){
            return Session::get('auth_user');
        }
        return Cookie::get('auth_user');
    }


    /**
     * @param string $hash_user
     * @param string $method
     * @return void
     */
    public function authorize(string $hash_user, string $method = 'cookie'): void
    {
        if ($method === 'session') {
            Session::set('auth_authorized', true);
            Session::set('auth_user', $hash_user);
        } else {
            Cookie::set('auth_authorized', true);
            Cookie::set('auth_user', $hash_user);
        }

        $this->hash_user = $hash_user;
        $this->authorized = true;
    }

    /**
     * @return void
     */
    public function unAuthorize($method='cookie'): void
    {
        if ($method === 'session') {
            Session::delete('auth_authorized');
            Session::delete('auth_user');
        } else {
            Cookie::delete('auth_authorized');
            Cookie::delete('auth_user');
        }

        $this->hash_user = null;
        $this->authorized = false;
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
    protected static function createToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}