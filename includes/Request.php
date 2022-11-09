<?php

namespace Cube;

class Request
{
    /**
     * @var Request
     */
    private static $instance;

    /**
     * url 前缀
     *
     * @var null|string
     */
    private $urlPrefix = null;

    /**
     * 资源地址
     *
     * @var null|string
     */
    private $requestUri = null;

    /**
     * 路径信息，已去除首尾分隔符
     *
     * @var string
     */
    private $pathinfo = null;

    /**
     * 设置路径信息
     *
     * @return string
     */
    public function getPathinfo()
    {
        if ($this->pathinfo === null) {
            $this->pathinfo = $this->getRequestUri();

            if ($pos = strpos($this->pathinfo, '?')) {
                $this->pathinfo = substr($this->pathinfo, 0, $pos);
            }

            if ($pos = strpos($this->pathinfo, '.php')) {
                $this->pathinfo = substr($this->pathinfo, $pos + 4);
            }

            $this->pathinfo = trim($this->pathinfo, '/');
        }

        return $this->pathinfo;
    }

    /**
     * 获取 get 参数
     *
     * @param null|string $name 参数名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get($name = null, $default = null)
    {
        if ($name === null) {
            return $_GET;
        } else {
            return $_GET[$name] ?? $default;
        }
    }

    /**
     * 获取 post 参数
     *
     * @param null|string $name 参数名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function post($name = null, $default = null)
    {
        if ($name === null) {
            return $_POST;
        } else {
            return $_POST[$name] ?? $default;
        }
    }

    /**
     * 获取环境变量
     *
     * @param string $name 获取环境变量名
     * @param null|string $default
     * @return null|string
     */
    public function getServer($name, $default = null)
    {
        return $_SERVER[$name] ?? $default;
    }

    /**
     * 获取头信息
     *
     * @param string $key
     * @param null|string $default
     * @return null|string
     */
    public function getHeader($key, $default = null)
    {
        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));

        return $this->getServer($key, $default);
    }

    /**
     * 获取客户端
     *
     * @param null|string $default
     * @return null|string
     */
    public function getReferer($default = null)
    {
        return $this->getHeader('Referer', $default);
    }

    /**
     * 判断是否为 https
     *
     * @return bool
     */
    public function isSecure()
    {
        return (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && (!strcasecmp('https', $_SERVER['HTTP_X_FORWARDED_PROTO'])))
            || (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && ($_SERVER['HTTP_X_FORWARDED_PORT'] === 443))
            || (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) !== 'off'))
            || (isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] === 443));
    }

    /**
     * 获取 url 前缀
     *
     * @return string
     */
    public function getUrlPrefix()
    {
        if ($this->urlPrefix === null) {
            $this->urlPrefix = ($this->isSecure() ? 'https' : 'http') . '://'
                . ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']);
        }

        return $this->urlPrefix;
    }

    /**
     * 获取资源地址
     *
     * @return string
     */
    public function getRequestUri()
    {
        if ($this->requestUri === null) {
            if (isset($_SERVER['REQUEST_URI'])) {
                $this->requestUri = $_SERVER['REQUEST_URI'];
            }
        }

        return $this->requestUri;
    }

    /**
     * 获取当前请求 url
     *
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->getUrlPrefix() . $this->getRequestUri();
    }

    /**
     * 构造 url
     *
     * @param string $parameter 参数
     * @return string
     */
    public function makeUrl($parameter = null)
    {
        $requestUrl = $this->getRequestUrl();
        $parts = parse_url($requestUrl);

        if (isset($parts['query'])) {
            parse_str($parts['query'], $currentArgs);
            parse_str($parameter, $args);

            $parts['query'] = http_build_query($parts['query'] = array_merge($currentArgs, $args));
        } else {
            $parts['query'] = $parameter;
        }

        return $this->buildUrl($parts);
    }

    /**
     * parse_url 方法重新组装 url
     *
     * @param string $parts
     * @return string
     */
    public function buildUrl($parts)
    {
        return (isset($parts['scheme']) ? $parts['scheme'] . '://' : null)
            . (isset($parts['user']) ? $parts['user']
                . (isset($parts['pass']) ? ':' . $parts['pass'] : null) . '@' : null)
            . ($parts['host'] ?? null)
            . (isset($parts['port']) ? ':' . $parts['port'] : null)
            . ($parts['path'] ?? null)
            . (isset($parts['query']) ? '?' . $parts['query'] : null)
            . (isset($parts['fragment']) ? '#' . $parts['fragment'] : null);
    }

    /**
     * @return Request
     */
    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
