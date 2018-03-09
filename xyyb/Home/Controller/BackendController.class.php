<?php
/**
 * Created by PhpStorm.
 * User: Duncan
 * Date: 2018/1/19
 * Time: 13:23
 */

namespace Home\Controller;
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;
use \Firebase\JWT\BeforeValidException;
use \Firebase\JWT\SignatureInvalidException;
use Think\Controller;
use Think\Exception;

//use Home\Controller\IndexController;
class BackendController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }





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
    /*
     * 检查token的函数
     */
    public function checkTk()
    {
        if (empty($_SESSION['token'])) {
            $this->redirect('Home/Index/login');
        }
        else {
            import('Vendor.phpjwt.src.JWT','','.php');
            import('Vendor.phpjwt.src.BeforeValidException','','.php');
            import('Vendor.phpjwt.src.ExpiredException','','.php');
            import('Vendor.phpjwt.src.SignatureInvalidException','','.php');
            $v=new JWT();
            try{
                $jwt=$v::decode($_SESSION['token'],C('JWT_KEY'),array(C('JWT_ALG')));
                if ($jwt) {
                    return true;
                }
                else {
                    $this->redirect('Home/Index/login');
                }
            }
            catch(BeforeValidException $e){
                unset($_SESSION['token']);
                $this->redirect('Home/Index/login');
            }
            catch(ExpiredException $e){
                unset($_SESSION['token']);
                $this->redirect('Home/Index/login');
            }
            catch(SignatureInvalidException $e){
                unset($_SESSION['token']);
                $this->redirect('Home/Index/login');
            }
            catch(\UnexpectedValueException $e){
                unset($_SESSION['token']);
                $this->redirect('Home/Index/login');
            }


        }

    }


}
