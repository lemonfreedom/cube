<?php

namespace Helpers;

class Renderer
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $callbacks = [];

    /**
     * 设置数据
     *
     * @param array $values 数据
     * @return $this
     */
    public function setValue($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * 设置多项数据
     *
     * @param array $values 数据
     * @return $this
     */
    public function setValues($values)
    {
        $this->data = array_merge($this->data, $values);

        return $this;
    }

    /**
     * 获取数据
     *
     * @return array
     */
    public function getValues()
    {
        return $this->data;
    }

    /**
     * 设置模版
     *
     * @param $callback 模板回调函数
     * @return void
     */
    public function setTemplate($callback)
    {
        $this->callbacks[] = $callback;
    }

    /**
     * 渲染模板
     *
     * @param null|array  $data 渲染数据
     * @return void
     */
    public function render($data = null)
    {
        foreach ($this->callbacks as $callback) {
            call_user_func($callback, null === $data ? $this->data : $data);
        }
    }
}
