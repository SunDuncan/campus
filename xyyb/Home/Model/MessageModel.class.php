<?php
/**
 * Created by PhpStorm.
 * User: Duncan
 * Date: 2018/1/19
 * Time: 13:37
 */
namespace Home\Model;
use Think\Model;
class MessageModel extends Model {
    public function getMessages($data = []) {
        if (empty($data)) {
            return $this->select();
        } else {
            return $this->where($data)->select();
        }
    }
}