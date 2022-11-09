<?php

namespace Cube;

class Router
{
    /**
     * @var array
     */
    private static $map = [
        'index' => ['widget' => '\\Widgets\\Index', 'action' => 'render'],
        'user' => ['widget' => '\\Widgets\\User'],
        'file' => ['widget' => '\\Widgets\\File'],
        'option' => ['widget' => '\\Widgets\\Option'],
        'plugin' => ['widget' => '\\Widgets\\Plugin'],
    ];

    /**
     * @return void
     */
    public static function dispatch()
    {
        $fragments = explode('/', Request::instance()->getPathinfo());
        $mapKey = array_shift($fragments);
        $mapKey = $mapKey !== '' ? $mapKey : 'index';
        $option = self::$map[$mapKey] ?? null;
        if ($option !== null) {
            $action = $option['action'] ?? 'action';
            $option['widget']::alloc($fragments, 'dispatch')->$action();
        } else {
            echo '404';
        }
    }
}
