<?php

namespace Cube;

class Fragment
{
    public function __call($name, $arguments)
    {
    }
}

class Widget
{
    /**
     * 组件对象池
     *
     * @var array
     */
    private static $pool = [];

    /**
     * @var Request
     */
    public $request;

    /**
     * @var array
     */
    private $params;

    public function __construct()
    {
        $this->request = Request::instance();
        $this->response = Response::instance();
        $this->db = Db::get();
    }

    /**
     * 分配组件
     *
     * @param array $params 参数
     * @param null|string $alias 别名
     * @return object
     */
    public static function alloc($params = [], $alias = null)
    {
        $alias = $alias === null ? static::class : static::class . '@' . $alias;

        if (!isset(self::$pool[$alias])) {
            $class = static::class;
            $widget = new $class();

            $widget->params = $params;
            $widget->init();

            self::$pool[$alias] = $widget;
        }

        return self::$pool[$alias];
    }

    /**
     * 获取参数
     *
     * @param null|int $index 参数索引
     * @param mixed $defaultValue 默认值
     * @return mixed
     */
    public function params($index = null, $defaultValue = null)
    {
        if ($index === null) {
            return $this->params;
        } else {
            return $this->params[$index] ?? $defaultValue;
        }
    }

    /**
     * 行动绑定
     *
     * @param bool $condition
     * @return $this
     */
    public function on($condition)
    {
        if ($condition) {
            return $this;
        } else {
            return new Fragment();
        }
    }

    public function init()
    {
    }
}
