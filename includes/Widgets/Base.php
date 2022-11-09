<?php

namespace Widgets;

use Cube\Widget;

class Base extends Widget
{
    /**
     * 加载主题文件
     *
     * @return void
     */
    public function need($file)
    {
        require ROOT_DIR . 'content/themes/default/' . $file . '.php';
    }
}
