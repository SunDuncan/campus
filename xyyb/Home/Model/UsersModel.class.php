<?php
/**
 * Created by PhpStorm.
 * User: Duncan
 * Date: 2018/1/19
 * Time: 13:41
 */
namespace Home\Model;
use Think\Model;
class UsersModel extends Model {

    protected $_map=array(
        'beizhu'=>'desc',
        'sex' =>'gender'
    );



//这里的话，尚未对电话进行验证规则
    protected $_validate =array(
        array('email','email','请输入正确的邮箱',1,'',1),
        array('email','require','必须输入邮箱',1,'',1),
        array('email','','已经存在相同的邮箱',1,'unique',1),
        array('username','',"用户名已经存在",1,'unique','',1),
        array('username','require',"必须输入用户名",1,'',1),
        array('nickname','require','必须输入用户的昵称',1,'',1),
        array('password','require','必须输入密码',1,'',1),
        array('password','3,100','密码的长度不正确',1,'length',1),
        array('phoneNumber','require','必须输入电话长度',1,'',1),
        array('phoneNumber','5,13','电话的长度不正确',1,'length',1),
        array('phoneNumber','','已经存在电话',1,'unique',1),
        array('checkPassword','require','必须输入验证密码',1,'',1),
        array('checkPassword','password','输入的验证密码不正确',1,'confirm',1),
        array('uploadfile','require','必须上传文件',1,'',1),
        array('desc','require','必须输入个性签名',1,'',1)
    );


    public function __construct($name = '', $tablePrefix = '', $connection = '')
    {
        parent::__construct($name, $tablePrefix, $connection);
    }

    //获取全部的用户
    public function getUsers($data=''){
        if (empty($data)) {
            return $this->order('id')->select();
        }
        else {
            $map=$data;
            return $this->where($map)->select();
        }

    }

 //获取表格之中记录的数目
    public function countUsers($data='')
    {
        if (empty($data)){
            return $this->count();
        }
        else {
            $map=$data;
            return $this->where($map)->count();

        }

    }
    //获得用户的id password key
    public function getInfo($data)
    {
        $res= $this->where($data)->field(array('id','key','password'))->select();
        return $res;
    }


}
