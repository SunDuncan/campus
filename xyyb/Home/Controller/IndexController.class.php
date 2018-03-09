<?php
namespace Home\Controller;
use \Home\Service\UserService;
use \Think\Verify;
class IndexController extends BackendController {
    protected $token=null;
    protected $veriy=null;
    public function __construct(){
        parent::__construct();
        $config=array(
            'fontSize' => 28,
            'length'  =>4,
            'useNoise' =>    false,
            'bg'  => array(255,240,230),

        );
        $this->veriy=new Verify($config);
    }

    public function index(){
          $this->checkTk();
          $this->display();
    }

    public function welcome() {
        $this->display();
    }
    public function login(){
        $this->display('login');
    }

    /*
  * 产生token的函数
  */

    public function produceToken()
    {
        import('Vendor.phpjwt.src.JWT','','.php');
        $c=time();
        $v=new \Firebase\JWT\JWT();
        $key = C('JWT_KEY');
        $tk = array(
            "iss" => "admin",
            "aud" => "user",
            "iat" => $c,
            "exp" =>time()+60*60*2,
            "id"  => $this->uid,
        );
        $this->token=$v::encode($tk,$key,C('JWT_ALG'));
    }

    /*
     * 检查登录的函数
     */

    public function checkLogin()
    {

        $data=I('post.ob');
        $data=(array)json_decode($data);
        $ser=new UserService();
        $red=$this->veriy->check($data['checkCode'],'');
        if (!$red){
            $rn['flag']=false;
            $rn['type']=6;
            $rn['information']="输入的验证码不正确";
            $this->ajaxReturn($rn);
        }
       $rn=$ser->delLogin($data);
        if ($rn['flag']) {
            $this->produceToken();
            $_SESSION['token']=$this->token;
            $rn['location']=U('Home/Index/index');
            $this->ajaxReturn($rn);
        }
        else {
            $this->ajaxReturn($rn);
        }


    }


    /*
     * 产生验证码
     */

    public function produceCode()
    {

        $this->veriy->entry();

    }




}