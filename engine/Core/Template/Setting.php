<?php

namespace Engine\Core\Template;

use Admin\Model\Setting\SettingRepository;
use Engine\DI\DI;

class Setting
{
    protected static DI $di;
    protected static SettingRepository $settingRepository;

    /**
     * @param DI $di
     */
    public function __construct(DI $di)
    {
        self::$di=$di;
        self::$settingRepository= new SettingRepository(self::$di);
    }


    /**
     * @param $keyField
     * @return string|null
     */
    public static function get($keyField):string|null
    {
        $result=self::$settingRepository->getSettingValue($keyField);
        return $result?->value;
    }
}