<?php
// 定义根目录
define('ROOT_DIR', __DIR__ . '/');

// 加载程序
require ROOT_DIR . 'includes/Common.php';

// 连接数据库
$db = \Cube\Db::init([
    'type' => 'mysql',
    'host' => 'localhost',
    'database' => 'cube',
    'username' => 'root',
    'password' => 'root',
    'port' => 3306,
    'prefix' => '',
]);

// 清空表
$db->drop('users');
$db->drop('contents');
$db->drop('options');

// 创建用户表
$db->create('users', [
    'uid' => ['INT', 'UNSIGNED', 'NOT NULL', 'AUTO_INCREMENT', 'PRIMARY KEY'],
    'username' => ['VARCHAR(30)', 'NOT NULL'],
    'email' => ['VARCHAR(100)', 'NOT NULL'],
    'password' => ['VARCHAR(255)', 'NOT NULL'],
    'group' => ['VARCHAR(16)', 'NOT NULL'],
    'created' => ['INT', 'UNSIGNED', 'NOT NULL'],
    'token' => ['VARCHAR(30)', 'NOT NULL'],
]);

$db->insert('users', [
    'username' => 'admin',
    'email' => '226582@qq.com',
    'password' => '$2y$10$nFjKlIMzsd8xUxSwX70R4OLt.atdf4wykN.9Z.7gzasKr0rDIjnPy',
    'group' => 'administrator',
    'created' => time(),
]);

// 创建内容表
$db->create('contents', [
    'cid' => ['INT', 'UNSIGNED', 'NOT NULL', 'AUTO_INCREMENT', 'PRIMARY KEY'],
    'uid' => ['INT', 'UNSIGNED', 'NOT NULL'],
    'name' => ['VARCHAR(30)', 'NOT NULL'],
    'content' => ['LONGTEXT', 'NOT NULL'],
    'type' => ['VARCHAR(30)', 'NOT NULL'],
    'created' => ['INT', 'UNSIGNED', 'NOT NULL'],
    'parent' => ['INT', 'UNSIGNED', 'NOT NULL'],
]);

// 创建选项表
$db->create('options', [
    'name' => ['VARCHAR(30)', 'NOT NULL', 'PRIMARY KEY'],
    'value' => ['LONGTEXT', 'NOT NULL'],
]);

// 插入选项数据
$db->insert('options', [
    ['name' => 'language', 'value' => 'Chinese'],
    ['name' => 'plugin', 'value' => 'a:0:{}'],
]);

$configString = <<<EOT
<?php
// 调试模式
define('DEBUG', true);

// 数据库配置
define('DB', [
    'type' => 'mysql',
    'host' => 'localhost',
    'database' => 'cube',
    'username' => 'root',
    'password' => 'root',
    'port' => 3306,
    'prefix' => '',
]);\n
EOT;

// 写入配置文件
file_put_contents(ROOT_DIR . 'config.php', $configString);

// 返回
\Cube\Response::instance()->goBack();
