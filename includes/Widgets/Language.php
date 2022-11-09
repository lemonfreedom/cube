<?php

namespace Widgets;

use Cube\Widget;

class Language extends Widget
{
    /**
     * 获取语言列表
     *
     * @return array
     */
    public function getLanguages()
    {
        User::alloc()->pass('administrator');

        $dirs = glob(ROOT_DIR . 'content/languages/*');

        $result = [['name' => '简体中文', 'value' => 'Chinese']];

        foreach ($dirs as $dir) {
            $info = [];

            [$info['value']] = explode('.', basename($dir));

            $class = '\\Languages\\' . $info['value'];
            if (class_exists($class)) {
                $info['name'] = $class::$name;

                $result[] = $info;
            }
        }

        return $result;
    }
}
