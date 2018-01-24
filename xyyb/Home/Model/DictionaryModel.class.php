<?php
/**
 * Created by PhpStorm.
 * User: Duncan
 * Date: 2018/1/19
 * Time: 13:36
 */
namespace Home\Model;
use Think\Model;
class DictionaryModel extends Model {
    public function setDictionary($data){
        if (empty($data)) {
            return false;
        }

        $data['createTime'] = date('Y-m-j',time());
        return $this->add($data);
    }

    public function getDictionaries($data) {
        if (empty($data)) {
            return $this->select();
        } else {
            $map = $data;
            return $this->where($map)->select();
        }
    }

    public function getDictionary($id) {
        if (empty($id)) {
            return false;
        }

        $map['id'] = $id;
        return  $this->where($map)->find();
    }


}