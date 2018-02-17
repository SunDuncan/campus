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
    public function setDictionary($data = []){
        if (empty($data)) {
            return false;
        }

        $data['createTime'] = date('Y-m-j',time());
        return $this->add($data);
    }

    public function getDictionaries($data = []) {
        if (empty($data)) {
            return $this->order("createTime desc")->select();
        } else {
            $map = $data;
            return $this->where($map)->order("createTime desc")->select();
        }
    }

    public function getDictionary($id = null) {
        if (empty($id)) {
            return false;
        }

        $map['id'] = $id;
        return  $this->where($map)->find();
    }

    public function countDictionary($data = []) {
        if (empty($data)) {
            return $this->count();
        } else {
            $map = $data;
            return $this->where($map)->count();
        }
    }

    public function getDictionaryOriginIds($id = null) {
        if (empty($id)) {
            return ;
        }

        $map['id'] = $id;
        return $this->where($map)->getField('origin_ids');
    }

    public function getDictionaryOriginCodes($id = null ) {
        if (empty($id)) {
            return ;
        }

        $map['id'] = $id;
        return $this->where($map)->getField('origin_codes');
    }

    public function getDictionaryCode($id = null) {
        if (empty($id)) {
            return ;
        }

        $map['id'] = $id;
        return $this->where($map)->getField('code');
    }

}