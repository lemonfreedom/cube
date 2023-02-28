<?php

namespace Cube;

class Response
{
    /**
     * @var Response
     */
    private static $instance;


    /**
     * @var Request
     */
    private $request;

    /**
     * @var array
     */
    private $httpCode = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    ];

    /**
     * @var int
     */
    private $status = 200;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $cookies = [];

    /**
     * @var array
     */
    private $responders = [];

    private function __construct()
    {
        $this->request = Request::instance();
    }

    /**
     * 设置 HTTP 状态
     *
     * @param int $code
     * @return $this
     */
    public function setStatus($code)
    {
        $this->status = $code;

        return $this;
    }

    /**
     * 设置响应头
     *
     * @param string $name 名称
     * @param string $value 对应值
     * @return $this
     */
    public function setHeader($name, $value)
    {
        $name = str_replace(' ', '-', ucwords(str_replace('-', ' ', $name)));
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * 设置响应类型
     *
     * @param string $contentType 内容类型
     * @return $this
     */
    public function setContentType($contentType = 'text/html')
    {
        $this->setHeader('Content-Type', $contentType);

        return $this;
    }

    /**
     * 设置 cookie
     *
     * @param string $name
     * @param string $value
     * @param int $expiresOrOptions
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     * @return $this
     */
    public function setCookie(
        $name,
        $value,
        $expiresOrOptions,
        $path,
        $domain,
        $secure,
        $httponly
    ) {
        $this->cookies[] = [$name, rawurlencode($value), $expiresOrOptions, $path, $domain, $secure, $httponly];

        return $this;
    }

    /**
     * 清除所有信息
     *
     * @return void
     */
    public function clean()
    {
        $this->status = 200;
        $this->headers = [];
        $this->cookies = [];
        $this->responders = [];
    }

    /**
     * 发送头信息
     *
     * @return void
     */
    public function sendHeaders()
    {
        foreach (headers_list() as $header) {
            $sentHeaders[] = strtolower(trim(explode(':', $header)[0]));
        }

        header('HTTP/1.1 ' . $this->status . ' ' . $this->httpCode[$this->status], true, $this->status);

        // set header
        foreach ($this->headers as $name => $value) {
            if (!in_array(strtolower($name), $sentHeaders)) {
                header($name . ': ' . $value);
            }
        }

        // set cookie
        foreach ($this->cookies as $cookie) {
            [$name, $value, $expiresOrOptions, $path, $domain, $secure, $httponly] = $cookie;
            setrawcookie($name, $value, $expiresOrOptions, $path, $domain, $secure, $httponly);
        }
    }

    /**
     * @param callable $responder
     * @return $this
     */
    public function addResponder($responder)
    {
        $this->responders[] = $responder;

        return $this;
    }

    /**
     * 响应
     *
     * @return void
     */
    public function respond()
    {
        foreach ($this->responders as $responder) {
            call_user_func($responder, $this);
        }

        exit;
    }

    /**
     * 返回 json
     *
     * @param array $data
     * @return void
     */
    public function json($data)
    {
        $this->setContentType('application/json')
            ->addResponder(function () use ($data) {
                echo json_encode($data);
            })
            ->respond();
    }

    /**
     * 重定向
     *
     * @param string $location 重定向路径
     * @param bool $isPermanently 是否为永久重定向
     * @return void
     */
    public function redirect($location, $isPermanently = false)
    {
        $this->setStatus($isPermanently ? 301 : 302)
            ->setHeader('Location', $location)
            ->respond();
    }

    /**
     * 返回来路
     *
     * @param bool $default 默认来路
     * @param bool $query query 参数跳转
     * @return void
     */
    public function goBack($default = '/', $query = false)
    {
        $referer = $this->request->getReferer();
        if ($referer !== null) {
            if ($query) {
                parse_str(parse_url($referer)['query'] ?? '', $args);
                $referer = $args['referer'] ?? $default;
            }
        } else {
            $referer = $default;
        }

        $this->redirect($referer);
    }

    /**
     * @return Response
     */
    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
