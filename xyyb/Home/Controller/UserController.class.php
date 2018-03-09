<?php
/**
 * Created by PhpStorm.
 * User: Duncan
 * Date: 2018/1/19
 * Time: 13:26
 * Update_time: 
 */
namespace Home\Controller;
use Home\Model\UsersModel;
use Home\Service\UserService;
use \Think\Upload;

class UserController extends BackendController {

    protected  $userService=null;

    public function __construct()
    {
        parent::__construct();
        $this->userService=new UserService();
        $this->checkTk();
    }
    public function  addUser() {
       $this->display();
    }

    public function postUser() {

    }

    public function showList() {
        $end_min_date = '#F{$dp.$D(' . '\\' . '\'logmin' . '\\' . '\'' . ')}';
        $start_max_date = '#F{$dp.$D(' . '\\' . '\'logmax' . '\\' . '\')||' . '\\' . '\'%y-%M-%d' . '\\' . '\'}';
        $data = I('get.') ? I("get.") : [];
        $rn=$this->userService->getResult($data);
        $this->assign('list', $rn['data']);
        $this->assign('count', $rn['count']);
        $this->assign('START_MAX_DATE', $start_max_date);
        $this->assign('END_MIN_DATE', $end_min_date);
        $this->display();

    }

    public function insertUser()
    {


        //首先的话，肯定就是查看是否有相同的用户名;
        $data = I('post.');
        $user=D('Users');
        if (! $user->create($_POST,1)){
            $rn['flag']=false;
            $rn['information']=$user->getError();
            $this->ajaxReturn($rn);
        }
        else {
            $upload = new Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = './uploads/'; // 设置附件上传根目录
            $upload->subName = array('date','YmdHis');
            $upload->savePath = '';
            $upload->saveName =array('uniqid','');

            // 上传文件
            $info = $upload->upload();
            if (!$info) {// 上传错误提示错误信息
                $rn['flag']=false;
                $rn['information']=$upload->getError();
                $this->ajaxReturn($rn);
            } else {// 上传成功
                $img_url = './uploads/' . '' . $info['files']['savepath'] . $info['files']['savename'];
                $createTime = date('Y-m-d H:i:s', NOW_TIME);
                $key = $this->userService->produceKey();
                $user->key=$key;
                $user->avatar=$img_url;
                $user->createTime=$createTime;
                $user->password=$this->userService->cryptPassword($user->password,$key);
                $ds=$user->add();
                $dc=array();
               if ($ds) {
                   $rn['flag']=true;
                   $rn['information']="用户添加成功";
                   $this->ajaxReturn($rn);
               } else {
                   $rn['flag']=false;
                   $rn['imformation']="用户添加失败";
                   $this->ajaxReturn($rn);
               }
            }
        }
    }
    public function deleteUser()
    {
        $data['id']=I('post.id');
        $data['id']=(int)json_decode($data['id']);
        $res=$this->userService->deleteUser($data);
        if ($res) {
            echo json_encode('yes');
        }
        else {
            echo  json_encode(false);
        }
    }

    public function editUser()
    {
        $data['id']=I('get.id');
        $res=$this->userService->getUserById($data);
        if (!$res) {
            $this->error('出错了');
        }
        else {
            $bir=explode(' ',$res['birthday']);
            $res['birthday']=$bir[0];
            $this->assign('user',$res);
            $this->display();
        }

    }
    /*
     * 这个是用来改变用户的信息的
     */
    public function changeUser()
    {

        $data=I('post.');

        //$flag=$this->userService->checkToken($data);


            //首先就是处理文件的上传
            $da['id']=$data['id'];
            $res=$this->userService->getUserById($da);
            if (!$res) {
                $rn['flag']=false;
                $rn['information']='sorry，请关闭窗口重新提交';
                $this->ajaxReturn($rn);
            }
            else {
                //进行观看用户名是否已经被修改了

                //获取用户存储的文件夹的名字
                $dn=$this->userService->firstDel($data,$res);

            }

             if (empty($data['uploadfile'])) {
                //空的文件的话，数据处理比对
                 $data['avatar']=$res['avatar'];

                 $data=$this->userService->delUpdate($data,$res);
                 $this->userService->updateUser($data);

                 $rn['flag']=true;
                 $rn['information']='用户信息修改成功';
                 $this->ajaxReturn($rn);
              }
             else {
                     //开始进行上传文件的验证
                     $upload = new \Think\Upload();// 实例化上传类
                     $upload->maxSize = 3145728;// 设置附件上传大小
                     $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                     $upload->rootPath = './uploads/'; // 设置附件上传根目录
                     $upload->subName = $dn;
                     $upload->savePath = '';
                     $upload->saveName =array('uniqid','');//

                     // 上传文件
                     $info = $upload->upload();
                     if (! $info) {
                         $rn['flag']=false;
                         $rn['information']=$upload->getError();
                         $this->ajaxReturn($rn);
                     }
                     else {
                         $data=$this->userService->delUpdate($data,$res);
                         unlink($res['avatar']);
                         //$ig='./uploads/'.$info['files']['savepath'].$info['files']['savename'];
                         //$bg='./uploads/'.$info['files']['savepath'].$data['username'].'.'.$info['files']['ext'];
                         //rename($ig,$bg);
                         $data['avatar']='./uploads/'.$info['files']['savepath'].$info['files']['savename'];;

                         $this->userService->updateUser($data);
                         $rn['flag']=true;
                         $rn['information']='用户修改成功';
                         $this->ajaxReturn($rn);

                     }


      }


    }

    public function deleteMany(){

       $da=I('post.inform');
       $da=(array)json_decode($da);
       if (empty($da)) {
           echo json_encode(false);
       }
       else {
           $data=array();
           foreach ($da as $key => $value){
               $data[]=$value;
           }

           $bs['id']=array('in',$data);
           $flag=$this->userService->deleteMany($bs);
           if($flag){
               echo  json_encode(true);
           }
           else {
               echo json_encode(false);
           }
       }

    }





    /*
     * 展示用户上传的图片的方法
     */
   public function  showUserPicture()
   {
         $data['id']=I('get.id');
         $res=$this->userService->getUserById($data);
         if (!$res ) {
             $this->error('出错了');
         }
         else {
             $res['avatar']='http://localhost/campus/xyyb/'.$res['avatar'];
             $this->assign('user',$res['avatar']);
             $this->display();
         }

  }



}