<?php

namespace Engine\Core\Customize;

use Engine\DI\DI;

class Customize
{
    protected Config $config;
    private static ?Customize $instance = null;

    /**
     * Customize constructor.
     */
    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    protected function __clone()
    {
    }

    /**
     * @return Customize|null
     */
    static public function instance(): ?Customize
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return array|null
     */
    public function getAdminMenuItems(): ?array
    {
        return $this->getConfig()->get('dashboardMenu');
    }

    /**
     * @return array|null
     */
    public function getAdminSettingItems(): ?array
    {
        return $this->getConfig()->get('settingMenu');
    }
}