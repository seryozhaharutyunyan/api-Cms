<?php

namespace Engine\Helper;

class Request
{
    public static function is(string $method): bool
    {
        return match (strtolower($method)) {
            'https' => self::https(),
            'ajax' => self::ajax(),
            default => $method === self::method(),
        };
    }

    /**
     * Get the current request method.
     *
     * @return string
     */
    public static function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD'] ?? 'get');
    }

    /**
     * Check if the request is over a https connection.
     *
     * @return bool
     */
    public static function https(): bool
    {
        return ($_SERVER['HTTPS'] ?? '') === 'on';
    }

    /**
     * Check if the request is an AJAX request.
     *
     * @return bool
     */
    public static function ajax(): bool
    {
        return ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest';
    }

}