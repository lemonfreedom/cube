<?php

namespace Plugins\HelloWorld;

class Main
{
    /**
     * 插件信息
     *
     * @return array
     */
    public static function info()
    {
        return [
            'url' => '',
            'description' => '这是描述信息',
            'version' => '1.0',
            'author' => 'Noah Zhang',
            'author_url' => '',
        ];
    }

    /**
     * 激活插件
     *
     * @return void
     */
    public static function activation()
    {
        \Cube\Plugin::factory('admin/modules/footer.php')->test = __CLASS__ . '::test';
        \Cube\Plugin::factory('admin/modules/footer1.php')->test = __CLASS__ . '::test';
        \Cube\Plugin::factory('admin/modules/footer.php')->test = __CLASS__ . '::test';
        \Cube\Plugin::factory('admin/modules/footer.php')->test = __CLASS__ . '::test';
    }

    /**
     * 禁用插件
     *
     * @return void
     */
    public static function deactivation()
    {
    }

    /**
     * 插件设置
     *
     * @return void
     */
    public static function setting($renderer)
    {
        $renderer->setValue('val1', '1');
    }

    /**
     * 插件方法
     *
     * @return void
     */
    public static function test()
    {
        echo 'HelloWorld!';
    }
}
