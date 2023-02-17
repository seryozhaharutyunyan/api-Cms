<?php

namespace Engine\Core\Template;

class Component
{
    public static function load(string $name, array $data = []): void
    {
        $templateFile=\ROOT_DIR."/content/themes/default/$name.php";
        if(ENV=='Admin'){
            $templateFile=path('view')."/$name.php";
        }

        if(\is_file($templateFile)){
            \extract($data);
            require $templateFile;
        }else{
            throw new \Exception(\sprintf("View file %s does not exist", $templateFile));
        }
    }

}