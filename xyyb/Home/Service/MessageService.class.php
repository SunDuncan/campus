<?php
/**
 * author: duncan
 * create_time: 2018-3-3 15:59
 * last_modified_by: duncan
 * last_modified_time: 2018-3-3 15:59
 * function: 消息的数据处理部分
 **/
namespace Home\Service;
use Home\Model\MessageModel;
class MessageService extends  BaseService {
    protected $message_model = null;
    public function __construct()
    {
        $this->message_model = new MessageModel();
    }

    /**
     * 查询获取消息
     */
    public function  getMessages($data = []) {
        /**
         * 筛选条件
         */
        return $this->message_model->getMessages($data);
    }
}