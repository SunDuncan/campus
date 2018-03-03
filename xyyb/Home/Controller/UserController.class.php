<?php
/**
 * Created by PhpStorm.
 * User: Duncan
 * Date: 2018/1/19
 * Time: 13:26
 */
namespace Home\Controller;
use Home\Model\UsersModel;
use Home\Service\UserService;
class UserController extends BackendController {

    protected  $userService=null;

    public function __construct()
    {
        parent::__construct();
        $this->userService=new UserService();
    }
    public function  addUser() {
       $this->display();
    }

    public function postUser() {

    }

    public function showList() {

         $this->display();
    }

    public function insertUser()
    {

        //首先查看的token是否符合
        if (!$this->userService->checkToken($_POST)) {
            $this->error('重复提交了， ');
        }


        //首先的话，肯定就是查看是否有相同的用户名;
        $data = I('post.');


        $isHaveUser = $this->userService->checkUser($data);

        if ($isHaveUser) {
            //表示用户的昵称不重复
            //接下来的话，就是准备验证上传的图片了
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = './Uploads/'; // 设置附件上传根目录
            $upload->subName = I('post.username') . '';
            $upload->savePath = '';
            $upload->saveName = I('post.username') . '';
            // 上传文件
            $info = $upload->upload();
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            } else {// 上传成功

                $img_url = './uploads/' . '' . $info['files']['savepath'] . $info['files']['savename'];
                $createTime = date('Y-m-d H:i:s', NOW_TIME);
                $key = $this->userService->produceKey();
                $data['key'] = $key;
                $data['gender'] = (int)$data['sex'];
                $data['avatar'] = $img_url;
                $data['birthday'] = $data['birthday'] . " 00:00:00";
                unset($data['sex']);
                $data['desc'] = $data['beizhu'];
                $data['password'] = $this->userService->cryptPassword($data['password'], $key);
                $data['createTime'] = $createTime;
                if ($this->userService->addUser($data)) {
                    $this->success('添加用户成功');
                } else {
                    $this->error('添加失败');
                }

            }

        } else {
            $this->error('用户名已经存在,请刷新页面后再次输入');
        }

    }

    public function fenyesearch()
    {


        $res = $_POST['aoData'];
        $iDisplayStart = 0; // 起始索引
        $iDisplayLength = 0;//分页长度
        $iSortCol_0 = 0;// order by 哪一列
        $sSortDir_0 = "asc";
        $sSearch = ''; // 搜索的内容，可结合mysql中的like关键字实现搜索功能

        $jsonarray= json_decode($res) ;
        foreach($jsonarray as $value){
            if($value->name=="sEcho"){
                $sEcho=$value->value;
            }
            if($value->name=="iDisplayStart"){
                $iDisplayStart=$value->value;
            }
            if($value->name=="iDisplayLength"){
                $iDisplayLength=$value->value;
            }
            if ($value -> name  == "iSortCol_0") {
                $iSortCol_0 = $value -> value;
            }

            if ($value -> name  == "sSortDir_0") {
                $sSortDir_0 = $value -> value;
            }

            if ($value-> name  == "sSearch") {
                $sSearch = $value -> value;
            }
        }
        $data = array();
        $Array = Array();
        if(!empty($sSearch)) {
            $da['username']=$sSearch;

            $res=$this->userService->searchUser($da);

            if ($res ) {
                $count=count($res);
                foreach($res as $key => $value) {
                    $data = array('<input name="" type="checkbox" value="">',$value["id"],$value['username'],$value['nickname'],$value['phonenumber'],$value['email'],$value['createtime'],'<span class="label label-success radius">已发布</span>','<a style="text-decoration:none" onClick="picture_stop(this,\'10001\')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a> <a style="text-decoration:none" class="ml-5" onClick="user_edit(\'字典编辑\',\'http://localhost/campus/xyyb/index.php/Home/User/editUser\',\''.$value['id'].'\')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="picture_del(this,\''.$value['id'].'\')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                                 ');
                    Array_push($Array,$data);
                }
                $json_data = array ('sEcho'=>$sEcho,'iTotalRecords'=>$count,'iTotalDisplayRecords'=>$count,'aaData'=>$Array);  //按照datatable的当前页和每页长度返回json数据
                $obj=json_encode($json_data);
                echo $obj;
            }
            else {
                $json_data = array('sEcho' => $sEcho, 'iTotalRecords' => 0, 'iTotalDisplayRecords' => 0, 'aaData' =>array());  //按照datatable的当前页和每页长度返回json数据
                $obj = json_encode($json_data);
                echo $obj;
            }

        }
        else {

            $result = $this->userService->getInformation();
            $count = $result['count'];
            $res = $result['result'];
            foreach ($res as $key => $value) {
                //这里有我不会写的,.号''这个
                $data = array('<input name="" type="checkbox" value="">', $value["id"], $value['username'], $value['nickname'], $value['phonenumber'], $value['email'], $value['createtime'], '<span class="label label-success radius">已发布</span>', '<a style="text-decoration:none" onClick="picture_stop(this,\'10001\')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a> <a style="text-decoration:none" class="ml-5" onClick="user_edit(\'用户编辑\',\'http://localhost/campus/xyyb/index.php/Home/User/editUser\',\''.$value['id'].'\')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="picture_del(this,\''.$value['id'].'\')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
          ');
                Array_push($Array, $data);

            }

            $json_data = array('sEcho' => $sEcho, 'sSearch' => $sSearch, 'iTotalRecords' => $count, 'iTotalDisplayRecords' => $count, 'aaData' => array_slice($Array, $iDisplayStart, $iDisplayLength));  //按照datatable的当前页和每页长度返回json数据
            $obj = json_encode($json_data);
            echo $obj;
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
        $flag=$this->userService->checkToken($data);

        if(!$flag) {
              $rn['flag']=false;
              $rn['information']='出错了，请关闭窗口重新提交';
              $this->ajaxReturn($rn);
        }
        else {
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
                //修改用户名的话，就是已经对文件夹名字进行修改了。没有的话，就是照旧
                $data=$this->userService->firstDel($data,$res);
            }

             if (empty($data['uploadfile'])) {
                //空的文件的话，数据处理比对
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
                     $upload->rootPath = './Uploads/'; // 设置附件上传根目录
                     $upload->subName = I('post.username') . '';
                     $upload->savePath = '';
                     $upload->saveName =   'xx';
                     // 上传文件
                     $info = $upload->upload();
                     if (! $info) {
                         $rn['flag']=false;
                         $rn['information']=$upload->getError();
                         $this->ajaxReturn($rn);
                     }
                     else {
                         $data=$this->userService->delUpdate($data,$res);
                         unlink($data['avatar']);
                         $ig='./uploads/'.$info['files']['savepath'].$info['files']['savename'];
                         $bg='./uploads/'.$info['files']['savepath'].$data['username'].'.'.$info['files']['ext'];
                         rename($ig,$bg);
                         $data['avatar']=$bg;
                         $this->userService->updateUser($data);
                         $rn['flag']=true;
                         $rn['information']='用户修改成功';
                         $this->ajaxReturn($rn);

                     }


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