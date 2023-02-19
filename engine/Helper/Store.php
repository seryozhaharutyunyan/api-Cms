<?php

namespace Engine\Helper;

use Engine\Core\Auth\Auth;
use Engine\Core\Config\Config;

class Store
{
    /**
     * @param string $dirName
     * @param array $file
     * @return string[]
     * @throws \Exception
     */
    public static function saveFile(string $dirName, array $file): array
    {
        $path = ROOT_DIR . DS . "src\\store\\$dirName" . DS;
        $url = Config::item('base_url') . "/src/store/$dirName/";
        if (!is_dir($path)) {
            mkdir($path);
        }

        $name = substr($file['tmp_name'], strrpos($file['tmp_name'], '\\') + 1);
        $name = Auth::encryptPassword(Auth::salt() . substr($name, 0, strrpos($name, '.'))) .
            '.' . substr($file['type'], strrpos($file['type'], '/') + 1);

        $data = file_get_contents($file['tmp_name']);
        Store::delete($file['tmp_name']);
        file_put_contents($path . $name, $data);

        return [
            'phat' => $path . $name,
            'url' => $url . $name
        ];

    }

    /**
     * @param string $path
     * @return bool
     */
    public static function delete(string $path): bool
    {
        if (is_file($path)) {
            unlink($path);
            return true;
        }
        return false;
    }

}