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
    //暂时这里还看不出来什么意思
    public function getDictionaries($data = []) {
        if (empty($data)) {
            return $this->order("isActive desc,createTime desc")->select();
        } else {
            $map = $data;
            return $this->where($map)->order("isActive desc,createTime desc")->select();
        }
    }

    /**
     * @param array $data
     * @return mixed
     * 查询树结构
     */
    public function getTreeDictionaries($data = []) {
        return $this->where('isActive=1')->order("level")->select();
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

    /**
     * @param $ids
     * @return mixed|void
     * 不做物理删除，咱不用这个函数
     */
    public function delDictionaries($ids) {
        if (empty($ids)) {
            return ;
        }

        return $this->delete($ids);
    }

    public function delDictionary($id) {
        if (empty($id)) {
            return ;
        }

        $save_data['id'] = $id;
        $save_data['isActive'] = 0;
        return $this->save($save_data);
    }

    public function saveDictionary($data) {
        if (empty($data['id'])) {
            return ;
        }

        $data['createTime'] = date('Y-m-j',time());
        return $this->save($data);
    }


}