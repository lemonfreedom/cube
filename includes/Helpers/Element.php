<?php

namespace Helpers;

use Cube\Request;

class Element
{
    /**
     * 创建一个 html 元素
     *
     * @param string $name 标签名
     * @param array $attr 标签属性
     * @param bool|string|array $slot 插槽
     * @return string
     */
    public static function create($name, $attrs = [], $slot = false, $has = true)
    {
        if (!$has) {
            return '';
        }

        $attr = '';
        foreach ($attrs as $key => $value) {
            $value = is_array($value) ? implode(' ', $value) : $value;
            $attr .= is_bool($value) ? ($value ? " {$key}" : '') : " {$key}=\"{$value}\"";
        }

        if (is_array($slot)) {
            $content = '';

            if (is_array($slot[0])) {
                foreach ($slot as $value) {
                    $content .= self::create(...$value);
                }
            } else {
                $content .= self::create(...$slot);
            }
        } else {
            $content = $slot;
        }

        return $content === false ? "<{$name}{$attr} />" : "<{$name}{$attr}>{$content}</{$name}>";
    }

    /**
     * 创建一个 select 元素
     *
     * @param string $name name 属性
     * @param string $value value 属性
     * @param string $options 选项列表
     * @param string $attr 标签属性
     * @return string
     */
    public static function select($name, $value = '', $options = [], $attr = [])
    {
        $option = '';
        foreach ($options as $item) {
            $option .= self::create('option', ['value' => $item['value'], 'selected' => $item['value'] === $value], $item['name']);
        }

        return self::create('select', array_merge([
            'class' => 'select',
            'name' => $name,
            'id' => $name,
            'value' => $value,
        ], $attr), $option);
    }

    /**
     * 创建 checks 元素
     *
     * @param string $name name 属性
     * @param string $value value 属性
     * @param string $options 选项
     * @return string
     */
    public static function checks($name, $value = '', $options = [])
    {
        $option = '';

        foreach ($options as $item) {
            $option .= self::create('div', ['class' => 'form-check'], [
                ['input', [
                    'class' => 'form-check-input',
                    'name' => $name . '[]',
                    'id' => $name . $item['value'],
                    'type' => 'checkbox',
                    'value' => $item['value'],
                    'checked' => $item['value'] === $value
                ]],
                ['label', ['class' => 'form-check-label', 'for' => $name . $item['value']], $item['name']],
            ]);
        }

        return $option;
    }

    /**
     * 创建 radios 元素
     *
     * @param string $name name 属性
     * @param string $value value 属性
     * @param string $options 选项
     * @return string
     */
    public static function radios($name, $value = '', $options = [])
    {
        $option = '';

        foreach ($options as $item) {
            $option .= self::create('div', ['class' => 'form-check'], [
                ['input', [
                    'class' => 'form-check-input',
                    'name' => $name,
                    'id' => $name . $item['value'],
                    'type' => 'radio',
                    'value' => $item['value'],
                    'checked' => $item['value'] === $value
                ]],
                ['label', ['class' => 'form-check-label', 'for' => $name . $item['value']], $item['name']],
            ]);
        }

        return $option;
    }

    /**
     * 创建一个分页组件
     *
     * @param string $name name 属性
     * @param string $value value 属性
     * @param string $options 选项
     * @return string
     */
    public static function pagination($current, $total)
    {
        if ($current > $total) {
            return '';
        }

        $request = Request::instance();

        return self::create('ul', ['class' => 'pagination'], [
            ['li', ['class' => 'page-item'], ['a', ['class' => 'page-link', 'href' => $request->makeUrl('page=1')], 1], $current - 1 > 1],
            ['li', ['class' => 'page-item'], ['a', ['class' => 'page-link', 'href' => $request->makeUrl('page=2')], 2], $current - 1 > 2],
            ['li', ['class' => ['page-item', 'disabled']], ['a', ['class' => 'page-link', 'href' => 'javascript:void(0)'], '...'], $current - 1 > 3],
            ['li', ['class' => 'page-item'], ['a', ['class' => 'page-link', 'href' => $request->makeUrl('page=' . ($current - 1))], $current - 1], $current - 1 > 0],
            ['li', ['class' => ['page-item', 'active']], ['a', ['class' => 'page-link', 'href' => $request->makeUrl('page=' . $current)], $current]],
            ['li', ['class' => 'page-item'], ['a', ['class' => 'page-link', 'href' => $request->makeUrl('page=' . ($current + 1))], $current + 1], $current + 1 <= $total],
            ['li', ['class' => ['page-item', 'disabled']], ['a', ['class' => 'page-link', 'href' => 'javascript:void(0)'], '...'], $total - $current > 3],
            ['li', ['class' => 'page-item'], ['a', ['class' => 'page-link', 'href' => $request->makeUrl('page=' . ($total - 1))], $total - 1], $total - 1 > $current + 1],
            ['li', ['class' => 'page-item'], ['a', ['class' => 'page-link', 'href' => $request->makeUrl('page=' . $total)], $total], $total > $current + 1],
        ]);
    }
}
