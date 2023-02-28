<?php
// 检查 PHP 版本
$minPhpVersion = 7.4;
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    exit(sprintf(
        'Your PHP version must be %s or higher to run Cube. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    ));
}
unset($minPhpVersion);

// 定义根目录
define('ROOT_DIR', __DIR__ . '/');

// 安装检测
if (!@include ROOT_DIR . 'config.php') {
    file_exists(ROOT_DIR . 'install.php') ? header('Location: /install.php') : exit('Missing Config File');
}

// 初始化
\Cube\Common::initialize();

// 请求分发
\Cube\Router::dispatch();
