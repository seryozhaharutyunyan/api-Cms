<?php

namespace Engine\Core\Template;

use Engine\Core\Config\Config;
use Engine\DI\DI;
use http\Env;

class View
{
    protected Theme $theme;
    public DI $di;
    protected Setting $setting;
    protected Menu $menu;

    /**
     * construct view
     */
    public function __construct(DI $di)
    {
        $this->di = $di;
        $this->theme = new Theme();
        $this->setting = new Setting($this->di);
        $this->menu= new Menu($this->di);
    }

    /**
     * @param string $template
     * @param array $vars
     *
     * @return void
     */
    public function render(string $template, array $vars = []): void
    {
        if (file_exists($this->getThemePath(\ENV) . '/function.php')) {
            include_once $this->getThemePath(\ENV) . '/function.php';
        }

        $templatePath = $this->getTemplatePath($template, ENV);

        if (!is_file($templatePath)) {
            throw new \InvalidArgumentException(\sprintf('Template "%s" not found in "%s"', $template, $templatePath));
        }

        $vars['lang'] = $this->di->get('language');
        $this->theme->set_data($vars);
        \extract($vars);

        \ob_start();
        \ob_implicit_flush(0);

        try {
            require $templatePath;
        } catch (\Exception $e) {
            \ob_end_clean();
            throw $e;
        }

        echo \ob_get_clean();
    }


    /**
     * @param string $template
     * @param string $env
     *
     * @return string
     */
    private function getTemplatePath(string $template, string $env = ''): string
    {
        if($env==='App'){
            $theme=Setting::get('active_theme');

            if(empty($theme)){
                $theme=Config::item('default_theme');
            }

            return \ROOT_DIR . "/content/themes/$theme/$template.php";
        }

        return  path('view') . "/$template.php";
    }

    /**
     * @param string $env
     *
     * @return string
     */
    private function getThemePath(string $env = ''): string
    {
        return match ($env) {
            'App' => \ROOT_DIR . "/content/themes/default",
            default => path('view'),
        };
    }


}