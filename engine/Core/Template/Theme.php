<?php

namespace Engine\Core\Template;

use Engine\Core\Config\Config;

class Theme
{
    const RULES_NAME_FILE = [
        'header' => 'header-%s',
        'footer' => 'footer-%s',
        'sidebar' => 'sidebar-%s',
    ];
    const URL_THEME_MASK = '%s/content/themes/%s';

    protected string $url = '';
    protected array $data = [];
    protected Asset $asset;
    protected Theme $theme;

    public function __construct()
    {
        $this->theme = $this;
        $this->asset = new Asset();
    }

    /**
     * @return string
     */
    public static function getUrl(): string
    {
        $currentTheme = Config::item('defaultTheme');
        $baseUrl = Config::item('base_url');

        return sprintf(self::URL_THEME_MASK, $baseUrl, $currentTheme);
    }

    public static function title()
    {
        $nameSite = Setting::get('name_site');
        $description = Setting::get('description');

        echo "$nameSite|$description";
    }

    /**
     * @return array
     */
    public function get_data(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function set_data(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @param string $name
     *
     * @return void
     * @throws \Exception
     */
    public function header(string $name = ''): void
    {
        $name = (string)$name;
        $file = self::detectNameFile($name, __FUNCTION__);

        Component::load($file, $this->get_data());
    }

    /**
     * @param string $name
     *
     * @return void
     * @throws \Exception
     */
    public function footer(string $name = ''): void
    {
        $name = (string)$name;
        $file = self::detectNameFile($name, __FUNCTION__);

        Component::load($file, $this->get_data());
    }

    /**
     * @param string $name
     *
     * @return void
     * @throws \Exception
     */
    public function sidebar(string $name = ''): void
    {
        $name = (string)$name;
        $file = self::detectNameFile($name, __FUNCTION__);

        Component::load($file, $this->get_data());
    }

    /**
     * @param string $name
     * @param array $data
     *
     * @return void
     * @throws \Exception
     */
    public function block(string $name, array $data = []): void
    {
        $data = array_merge($this->get_data(), $data);
        $name = rtrim($name);

        if ($name !== '') {
            Component::load($name, $data);
        }

    }

    /**
     * @param string $name
     * @param string $function
     * @return string
     */
    private static function detectNameFile(string $name, string $function): string
    {
        return empty(trim($name)) ? $function : sprintf(self::RULES_NAME_FILE[$function], $name);
    }

    public static function getThemePath(): string
    {
        return match (ENV) {
            'App' => \ROOT_DIR . "/content/themes/default",
            default => path('view'),
        };
    }
}