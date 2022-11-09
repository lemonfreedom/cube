<?php
// 定义根目录
define('ROOT_DIR', dirname(__DIR__, 2) . '/');

// 加载配置文件
if (!@include ROOT_DIR . 'config.php') {
    file_exists(ROOT_DIR . 'install.php') ? header('Location: /install.php') : exit('Missing Config File');
}

// 加载程序
require ROOT_DIR . 'includes/Common.php';

// 初始化
\Cube\Common::init();

$request = \Cube\Request::instance();
$option = \Widgets\Option::alloc();
$user = \Widgets\User::alloc();
