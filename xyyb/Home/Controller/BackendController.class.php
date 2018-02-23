<?php
/**
 * Created by PhpStorm.
 * User: Duncan
 * Date: 2018/1/19
 * Time: 13:23
 */

namespace Home\Controller;

use Think\Controller;

class BackendController extends Controller
{
    /**
     * 封装一个成功json的返回请求
     */
    /**
     * @param string $data
     * @param string $msg
     * @param int $code
     */
    public function ajaxSuccess($data = '', $msg = '操作成功', $code = 200)
    {
        $return = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        $this->ajaxReturn($return);
    }

    /**
     *  封装一个的错误的请求
     */
    /**
     * @param string $data
     * @param string $msg
     * @param string $code
     */
    public function ajaxError($data = '', $msg = '', $code = '')
    {
        $return = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        $this->ajaxReturn($return);
    }
}
