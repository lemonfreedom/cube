<?php

namespace Widgets;

use Exception;
use Cube\Notice;
use Cube\Widget;
use Helpers\Cookie;
use Helpers\Validator;

class User extends Widget
{
    /**
     * 用户组
     *
     * @var array
     */
    public $groups = [
        // 管理员
        'administrator' => 0,
        // 编辑
        'editor' => 1,
        // 贡献者
        'contributor' => 2,
        // 关注者
        'subscriber' => 3,
        // 访问者
        'visitor' => 4,
    ];

    /**
     * @var null|bool
     */
    private $hasLogin = null;

    /**
     * @var null|array
     */
    private $loginUserinfo = null;

    /**
     * 是否登陆
     *
     * @return bool
     */
    public function hasLogin()
    {
        if ($this->hasLogin === null) {
            $uid = Cookie::get('uid', '');
            $tokenHash = Cookie::get('token', '');

            $result = $this->db->get('users', ['uid', 'token'], ['uid' => $uid]);

            if ($result !== null) {
                [$tokenTime, $token] = explode('@', $result['token']);
                // 验证 token 是否正确
                if ($tokenHash === md5($token)) {
                    // 验证 token 时效期
                    $duration = time() - $tokenTime;
                    $this->hasLogin = $duration <= 3600;

                    // 如果小于 20 分钟过期，自动续票
                    if ($duration > 2400 && $duration <= 3600) {
                        $token = rand_string(19);

                        $this->db->update('users', ['token' => time() . '@' . $token], ['uid' => $result['uid']]);

                        Cookie::set('token', md5($token));
                    }
                } else {
                    $this->hasLogin = false;
                }
            } else {
                $this->hasLogin = false;
            }
        }

        return $this->hasLogin;
    }

    /**
     * 判断用户权限
     *
     * @param string $group 用户组
     * @param string $return 返回模式
     * @return boolean
     */
    public function pass($group, $return = false)
    {
        if ($this->hasLogin()) {
            if (!array_key_exists($group, $this->groups) || !($this->groups[$this->group] <= $this->groups[$group])) {
                if ($return) {
                    return false;
                } else {
                    throw new Exception('禁止访问', 403);
                }
            }
        } else {
            if ($return) {
                return false;
            } else {
                $this->response->redirect('/admin/login.php');
            }
        }

        if ($return) {
            return true;
        }
    }

    /**
     * 获取登陆用户信息
     *
     * @return array
     */
    public function getLoginUserinfo()
    {
        if ($this->loginUserinfo === null) {
            $this->loginUserinfo = $this->db->get('users', ['uid', 'username', 'email', 'group', 'created'], ['uid' => Cookie::get('uid', '')]);
        }

        return $this->loginUserinfo;
    }

    /**
     * 用户登录
     *
     * @return void
     */
    private function login()
    {
        $data = $this->request->post();
        $v = new Validator($data, [
            'account' => [['type' => 'required', 'message' => '用户名或邮箱不能为空']],
            'password' => [['type' => 'required', 'message' => '密码不能为空']],
        ]);
        if (!$v->run()) {
            Notice::set(array_map(function ($value) {
                return $value['message'];
            }, $v->result), 'warning');
            $this->response->goBack();
        }

        $result = $this->db->get('users', ['uid', 'password'], [
            'OR' => [
                'username' => $data['account'],
                'email' => $data['account'],
            ],
        ]);

        if (empty($result)) {
            Notice::set('用户不存在', 'warning');
            $this->response->goBack();
        }

        if (password_verify($data['password'], $result['password'])) {
            $token = rand_string(19);

            $this->db->update('users', ['token' => time() . '@' . $token], ['uid' => $result['uid']]);
            Cookie::set('uid', $result['uid']);
            Cookie::set('token', md5($token));

            $this->response->goBack('/admin', true);
        } else {
            Notice::set('密码错误', 'warning');
            $this->response->goBack();
        }
    }

    /**
     * 用户注册
     *
     * @return void
     */
    private function register()
    {
        $data = $this->request->post();

        $v = new Validator($data, [
            'username' => [
                ['type' => 'required', 'message' => '用户名不能为空'],
                [
                    'type' => 'custom',
                    'validator' => function ($rule, $value, $callback) {
                        if ($this->db->has('users', ['username' => $value])) {
                            $callback('用户名已存在');
                        }
                    }
                ],
            ],
            'email' => [
                ['type' => 'required', 'message' => '邮箱不能为空'],
                ['type' => 'email', 'message' => '邮箱格式不正确'],
                [
                    'type' => 'custom',
                    'validator' => function ($rule, $value, $callback) {
                        if ($this->db->has('users', ['email' => $value])) {
                            $callback('邮箱已存在');
                        }
                    }
                ],
            ],
            'password' => [['type' => 'required', 'message' => '密码不能为空']],
        ]);
        if (!$v->run()) {
            Notice::set($v->result[0]['message'], 'warning');
            $this->response->goBack();
        }

        $result = $this->db->insert('users', [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'group' => 'subscriber',
            'created' => time(),
        ]);

        if (!empty($result) && $result->rowCount() > 0) {
            Notice::set('注册成功', 'success');
            $this->response->redirect('/admin/login.php');
        } else {
            Notice::set('注册失败', 'danger');
            $this->response->goBack();
        }
    }

    /**
     * 退出登录
     *
     * @return void
     */
    private function logout()
    {
        $this->hasLogin = null;

        $this->db->update('users', ['token' => ''], ['uid' => Cookie::get('uid', '')]);

        Cookie::delete('uid');
        Cookie::delete('token');

        $this->response->redirect('/admin/login.php');
    }

    public function action()
    {
        $this->on($this->params(0) === 'login')->login();
        $this->on($this->params(0) === 'register')->register();
        $this->on($this->params(0) === 'logout')->logout();
    }

    public function __get($name)
    {
        $loginUserinfo = $this->getLoginUserinfo();

        return $loginUserinfo[$name] ?? '';
    }
}
