<?php

namespace Languages;

class English
{
    /**
     * 语言名称
     *
     * @var string
     */
    public static $name = '英语';

    /**
     * 翻译信息
     *
     * @var array
     */
    public static $messages = [
        ['id' => '登录', 'value' => 'Login'],
        ['id' => '用户名或邮箱', 'value' => 'Username or email'],
        ['id' => '密码', 'value' => 'Password'],
        ['id' => '返回首页', 'value' => 'Return homepage'],
        ['id' => '用户注册', 'value' => 'User registration'],

        ['id' => '设置', 'value' => 'Setting'],
        ['id' => '基本', 'value' => 'Basic'],
        ['id' => '站点名称', 'value' => 'Site name'],
        ['id' => '站点的名称将显示在网页的标题处', 'value' => 'The name of the site will be displayed at the title of the web page'],
        ['id' => '站点描述', 'value' => 'Site description'],
        ['id' => '站点描述将显示在网页代码的头部', 'value' => 'The site description will be displayed in the header of the webpage code'],
        ['id' => '关键词', 'value' => 'Keyword'],
        ['id' => '是否允许注册', 'value' => 'Is registration allowed'],
        ['id' => '否', 'value' => 'No'],
        ['id' => '是', 'value' => 'Yes'],
        ['id' => '站点默认语言', 'value' => 'Site default language'],

        ['id' => '%s 秒前', 'value' => '%s seconds ago'],
        ['id' => '%s 分钟前', 'value' => '%s minutes ago'],
        ['id' => '保存成功', 'value' => 'Save success'],
    ];
}
