<?php

namespace Cube;

use Helpers\Medoo;

class Db
{
    /**
     * @var Medoo
     */
    private static $db;

    /**
     * @param array $option 数据库选项
     * @return Medoo
     */
    public static function init($option)
    {
        return self::$db = new Medoo($option);
    }

    /**
     * @return Medoo
     */
    public static function get()
    {
        return self::$db;
    }
}
