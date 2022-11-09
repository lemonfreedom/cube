<?php

namespace Cube;

class I18n
{
    /**
     * @var null|array
     */
    private static $messages = null;

    /**
     * 初始化
     *
     * @param string $locale 语言
     * @return void
     */
    public static function init($locale)
    {
        if (self::$messages === null && $locale !== 'Chinese') {
            $class = '\\Languages\\' . $locale;

            if (class_exists($class)) {
                self::$messages = $class::$messages;
            }
        }
    }

    /**
     * 翻译
     *
     * @param string $string
     * @return string
     */
    public static function translate($string)
    {
        return self::$messages !== null ? (array_column(self::$messages, 'value', 'id')[$string] ?? $string) : $string;
    }
}
