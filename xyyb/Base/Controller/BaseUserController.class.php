<?php
/**
 * author: duncan
 * time: 2018.3.6 15:29
 * last_modified_by:
 * last_modified_time:
 * function: 用户基础类
 */
namespace Base\Controller;
use Think\Controller;
class BaseUserController extends Controller{
    protected $uid = null;
    protected $token = null;
    protected $access_token = null;
    public function __construct()
    {
        /**
         * 去查找用户的登陆情况，设置全局的uid
         */
        parent::__construct();
    }
    /**
     * 登录
     */

    public function login() {
        $this->display();
    }
    /**
     * 校验
     */
}