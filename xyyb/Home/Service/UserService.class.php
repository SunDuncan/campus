<?php
/**
 * author: duncan
 * create_time: 2018-1-25 11:11
 * last_modified_by: duncan
 * last_modified_time: 2018-1-25 11:12
 * function: 字典表的数据处理部分
 **/
namespace Home\Service;
use Home\Model\UsersModel;
class UserService
{
   protected $userModel=null;
   public function __construct()
   {
       $this->userModel=new UsersModel();
   }

   /*
    * 检查是否有这个用户
    */
   public function checkUser($data)
   {


       $User=M('Users');


       $result=$User->where("username='%s'",array($data['username']))->find();

       if ($result) {
           return false;
       }
       else {
           return true;
       }


   }
   public function produceKey()
   {
       $set=array(
           '1','2','3','4','5','6','7','8','9',
           '0','a','b','c','d','e','f','g','h',
           'i','j','k','l','m','n','o','p','q',
           'r','s','t','u','v','w','x','y','z',
           'A','B','C','D','E','F','G','H','I',
           'J','K','L','M,','N','O','P','Q','R',
           'S','T','U','V','W','X','Y','Z','~',
           '@','#','%','*','(',')','{','}','[',']',
       );
       $key='';
       for($i=0;$i<80;$i++)
       {
           $key=$key.$set[rand(0,72)];
       }
       return $key;
   }

   public function cryptPassword($password,$key)
   {
       if (empty($key)|| empty($password)) {
           return false;
       }
       else {
           $pwd=md5($password);
           return crypt($pwd,$key);
       }

   }
   /*
    *
    */
  public function checkToken($data)
  {
      if ($this->userModel->autoCheckToken($data)) {
          return true;
      }
      else {
          return false;
      }
  }

  public function addUser($data)
  {
     $res=$this->userModel->add($data);
     return $res;
  }

  public function getInformation()
  {

      $count      = $this->userModel->count();// 查询满足要求的总记录数
      $res=$this->userModel->select();
      $list=array(
          'count'=>$count,
          'result'=>$res
      );
     return $list;
  }
  public function searchUser($data)
  {
      $condtion['username']=array("like","%".$data['username']."%");
      $res=$this->userModel->where($condtion)->select();
     if ($res) {
         return $res;
     }
     else {
         return false;
     }
  }

  public function searchByType($data){


      $da=array();
    if(empty($data)) {
        return false;
    }


      if ($data['type'] ==1) {
          $da['username']=array("like","%".$data['value']."%");

      }
      if ($data['type'] ==2) {
          $da['nickname']=array("like","%".$data['value']."%");

      }
      if ($data['type'] ==3) {
          $da['phoneNumber']=array("like","%".$data['value']."%");

      }
      if ($data['type'] ==4) {
          $da['email']=array("like","%".$data['value']."%");

      }
      $res=$this->userModel->where($da)->select();
      if ($res) {
          return $res;
      }
      else {
          return false;
      }

  }

  /*
   * 删除用户
   */
  public function deleteUser($data)
  {
      $img_url=$this->userModel->where($data)->getField('avatar');
      if(!$img_url) {
            return false;
      }
      $this->removePictureAndDir($img_url);
      $res=$this->userModel->where($data)->delete();
      return $res;
  }
  public function removePictureAndDir($filePath)
  {

      if (file_exists($filePath)) {
           unlink($filePath);
      }
      $dir=explode('/',$filePath);
      $dirPath='';
      for($i=0;$i<count($dir)-2;$i++)
      {
          $dirPath=$dirPath.$dir[$i].'/';
      }
      $dirPath=$dirPath.$dir[$i];
      if (is_dir($dirPath)) {
          rmdir($dirPath);
      }
  }
  public function getUserById($data)
  {
      $res=$this->userModel->where($data)->find();
      return $res;

  }
/*
 * 处理修改用户信息的函数。
 */

public function firstDel($data,$res)
{

    /*

    if($data['username'] !== $res['username'] ) {
        //重新命名文件夹的名
        rename('./uploads/'.$res['username'],'./uploads/'.$data['username']);
        //修改文件的路径
        $data['avatar']='';
        $temp=explode('/',$res['avatar']);
        $data['avatar']=$temp[0].'/'.$temp[1].'/'.$data['username'].'/'.$temp['3'];
    }
    else {
        $data['avatar']=$res['avatar'];
    }
    */
    $temp=explode('/',$res['avatar']);
    return $temp[2];
    //data['avatar']=$res['avatar'];
    //return $data;

}



  public function delUpdate($data,$res)
  {
      //最后保留的是$data 数据


      //验证密码和key
      $ba=$this->cryptPassword($data['password'],$res['key']);
      if ($ba === $res['password']) {
          $data['key']=$res['key'];
          $data['password']=$ba;
      }
      else {
          $key=$this->produceKey();
          $data['password']=$this->cryptPassword($data['password'],$key);
          $data['key']=$key;
      }
      $data['birthday']=$data['birthday'].' 00:00:00';
      return $data;

  }
  public function updateUser($data)
  {
      $res=$this->userModel->save($data);
      return $res;
  }

  public function deleteMany($data){
     $res=$this->userModel->where($data)->select();
     foreach ($res as $key){
         unlink($key['avatar']);
         $temp=explode('/',$key['avatar']);
         $dir=$temp[0].'/'.$temp[1].'/'.$temp[2];
         rmdir($dir);
     }
     return $this->userModel->where($data)->delete();
  }

  //新建立函数
    //获取分页的数据
    public function getResult($data='')
    {
        $rn['count']=$this->userModel->countUsers($data);
        $rn['data']=$this->userModel->getUsers($data);
        return $rn;
    }


}