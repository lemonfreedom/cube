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
     * @param string $text
     * @return string
     */
    public static function translate($text)
    {
        return self::$messages !== null ? (array_column(self::$messages, 'value', 'id')[$text] ?? $text) : $text;
    }
}
