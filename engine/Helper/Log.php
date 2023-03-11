<?php

namespace Engine\Helper;

class Log
{
    protected static string $path = ROOT_DIR . DS . "log" . DS;


    /**
     * @param string $message
     * @param string $group
     * @return void
     */
    public static function set(string $message, string $group): void
    {
        $filename = self::$path . $group . '.log';
        $log = file_get_contents($filename);
        $log .= date('d.m.Y H:i:s') . "=>$message \n\n";
        file_put_contents($filename, $log);
    }

    /**
     * @param string $group
     * @return void
     */
    public static function delete(string $group): void
    {
        $filename = self::$path . $group . '.log';
        file_put_contents($filename, '');
    }

}