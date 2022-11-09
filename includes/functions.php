<?php

/**
 * 翻译
 *
 * @param string $string 待翻译字符串
 * @param array $args 翻译参数
 * @return string
 */
function _t($string, ...$args)
{
    if (empty($args)) {
        return \Cube\I18n::translate($string);
    } else {
        return vsprintf(\Cube\I18n::translate($string), $args);
    }
}

/**
 * 文件大小格式化
 *
 * @param int $size 文件大小
 * @param int $count 单位层级
 * @return string
 */
function format_size($size, $count = 0)
{
    if ($size > 1024) {
        return format_size($size / 1024, $count + 1);
    } else {
        $unitMap = ['B', 'KB', 'MB', 'GB', 'TB'];

        return sprintf('%u%s', $size, $unitMap[$count]);
    }
}

/**
 * 生成随机字符串
 *
 * @param int $length 字符串长度
 * @param bool $number 是否包含数字
 * @param bool $lowerCase 是否包含小写字母
 * @param bool $mixedCase 是否包含大写字母
 * @param bool $specialChars 是否包含特殊字符
 * @return string
 */
function rand_string($length,  $number = true, $lowerCase = true, $mixedCase = false, $specialChars = false)
{
    $chars = '';

    if ($number) {
        $chars .= '0123456789';
    }

    if ($lowerCase) {
        $chars .= 'abcdefghijklmnopqrstuvwxyz';
    }

    if ($mixedCase) {
        $chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }

    if ($specialChars) {
        $chars .= '.!@#$%^&*()';
    }

    $result = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $result .= $chars[mt_rand(0, $max)];
    }

    return $result;
}

/**
 * 时间格式化
 *
 * @param int $time Unix 时间戳
 * @param bool $friendly 是否友好显示
 * @return string
 */
function format_time($time, $friendly = false)
{
    if ($friendly) {
        $dTime = time() - $time;
        if ($dTime < 60) {
            return _t('%s 秒前', $dTime);
        } else if ($dTime < 3600) {
            return  _t('%s 分钟前', floor($dTime / 60));
        } else if ($dTime < 86400) {
            return _t('%s 小时前', floor($dTime / 3600));;
        } else {
            return date("Y-m-d H:i:s", $time);
        }
    } else {
        return date("Y-m-d H:i:s", $time);
    }
}

/**
 * 返回在配置文件中包含 index.php 的指定的站点基本 url
 *
 * @param string $uri 拼接的 uri 片段
 * @return string
 */
function site_url($uri = '')
{
    return \Cube\Request::instance()->getUrlPrefix() . '/index.php/' . $uri;
}

/**
 * 返回在配置文件中指定的站点基本 url
 *
 * @param string $uri 拼接的 uri 片段
 * @return string
 */
function base_url($uri = '')
{
    return \Cube\Request::instance()->getUrlPrefix() . '/' . $uri;
}
