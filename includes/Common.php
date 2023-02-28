<?php

namespace {
    // 自动加载
    spl_autoload_register(function ($class) {
        $alias = [
            'Content' => 'content',
            'Themes' => 'content/themes',
            'Plugins' => 'content/plugins',
            'Languages' => 'content/languages',
            'Cube' => 'includes',
            'Helpers' => 'includes/Helpers',
            'Widgets' => 'includes/Widgets',
        ];
        $class = explode('\\', $class);

        $class[0] = $alias[$class[0]] ?? $class[0];

        $file = ROOT_DIR . implode('/', $class) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    });

    // 加载公共函数
    require ROOT_DIR . 'includes/functions.php';

    // 内容渲染
    ob_start(function ($content) {
        \Cube\Response::instance()->sendHeaders();
        return $content;
    });
}

namespace Cube {
    class Common
    {
        public static function initialize()
        {
            // 异常处理
            if (!DEBUG) {
                set_exception_handler(function ($e) {
                    \Cube\Response::instance()->clean();
                    ob_end_clean();

                    ob_start(function ($content) {
                        \Cube\Response::instance()->sendHeaders();
                        return $content;
                    });

                    $message = $e->getMessage();
                    $code = $e->getCode() === 0 ? 500 : $e->getCode();
                    \Cube\Response::instance()->setStatus($code);

                    include ROOT_DIR . 'admin/error.php';
                });
            }

            // 数据库初始化
            \Cube\Db::init(DB);

            // 获取选项
            $option = \Widgets\Option::alloc();

            // 语言初始化
            \Cube\I18n::init($option->get('language', ''));

            // 插件初始化
            \Cube\Plugin::init($option->get('plugin', []));
        }
    }
}
