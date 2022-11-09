<?php

namespace Cube;

use Helpers\Cookie;

class Notice
{
    /**
     * 设置通知
     *
     * @param string $message 通知信息
     * @param string $type 通知类型
     */
    public static function set($message, $type = 'info')
    {
        Cookie::set('notice', json_encode(['type' => $type, 'message' => $message]), time() + 10);
    }
}
