<?php

namespace Engine\Core\Template;


use App\Model\MenuItem\MenuItemRepository;
use Engine\DI\DI;

class Menu
{
    protected static DI $di;
    protected static MenuItemRepository $menuRepository;

    public function __construct($di)
    {
        self::$di = $di;
        self::$menuRepository = new MenuItemRepository(self::$di);
    }

    public static function show()
    {


    }

    public static function getItems(): array
    {
        return self::$menuRepository->getAllItems();
    }

}