<?php

namespace Widgets;

use Cube\Notice;
use Cube\Widget;

class Option extends Widget
{
    /**
     * @var array
     */
    private $options = [];

    /**
     * @return void
     */
    public function init()
    {
        $this->options = $this->db->select('options', ['name', 'value']);

        foreach ($this->options as $index => $option) {
            if (in_array($option['name'], ['plugin', 'theme'])) {
                $this->options[$index]['value'] = unserialize($this->options[$index]['value']);
            }
        }
    }

    /**
     * 获取选项
     *
     * @param null|string $name 选项名
     * @param null|string $defaultValue 默认值
     * @return mixed
     */
    public function get($name = null, $defaultValue = null)
    {
        if ($name === null) {
            return $this->options;
        } else {
            return array_values(array_filter($this->options, function ($option) use ($name) {
                return $option['name'] === $name;
            }))[0]['value'] ?? $defaultValue;
        }
    }

    /**
     * 设置选项
     *
     * @param string $name 选项名
     * @param string $value 选项值
     * @return void
     */
    public function set($name, $value)
    {
        $index = array_search($name, array_map(function ($option) {
            return $option['name'];
        }, $this->options));

        if ($index === false) {
            $this->db->insert('options', ['name' => $name, 'value' => $value]);
            $this->options[] = ['name' => $name, 'value' => $value];
        } else {
            if ($this->options[$index]['value'] !== $value) {
                $this->db->update('options', ['value' => $value], ['name' => $name]);
                $this->options[$index]['value'] = $value;
            }
        }
    }

    /**
     * 更新一般配置
     *
     * @return void
     */
    private function updateGeneral()
    {
        User::alloc()->pass('administrator');

        $data = $this->request->post();

        $this->set('language', $data['language']);

        Notice::set(_t('保存成功'), 'success');
        $this->response->goBack();
    }

    public function action()
    {
        $this->on($this->params(0) === 'update-general')->updateGeneral();
    }
}
