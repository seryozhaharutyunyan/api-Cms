<?php

namespace Engine\Core\Customize;

class Config
{
    protected array $config = [
        'dashboardMenu' => [
            'home' => [
                'classIcon' => 'icon-speedometer icons',
                'urlPath'   => '/admin/',
                'title'     => 'Home'
            ],
            'resource' => [
                'classIcon' => 'folder outline icon',
                'urlPath'   => '#',
                'title'     => 'Resources',
                'parents'   => []
            ],
            'plugins' => [
                'classIcon' => 'icon-wrench icons',
                'urlPath'   => '/backend/plugins/',
                'title'     => 'Plugins'
            ],
            'settings' => [
                'classIcon' => 'icon-equalizer icons',
                'urlPath'   => '/backend/settings/general/',
                'title'     => 'Settings'
            ]
        ],
        'settingMenu' => [
            'general' => [
                'urlPath'   => '/backend/settings/general/',
                'title'     => 'General'
            ],
            'themes' => [
                'urlPath'   => '/backend/settings/appearance/themes/',
                'title'     => 'Themes'
            ],
            'menus' => [
                'urlPath'   => '/backend/settings/appearance/menus/',
                'title'     => 'Menus'
            ],
            'custom_fields' => [
                'urlPath'   => '/backend/settings/custom_fields/',
                'title'     => 'Custom Fields'
            ]
        ]
    ];

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->config[$key]);
    }

    /**
     * @param string $key
     * @return array|null
     */
    public function get(string $key): array|null
    {
        return $this->has($key) ? $this->config[$key] : null;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, mixed $value): void
    {
        $this->config[$key] = $value;
    }
}