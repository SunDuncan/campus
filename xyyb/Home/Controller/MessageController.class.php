<?php
/**
 * Created by PhpStorm.
 * User: Duncan
 * Date: 2018/1/19
 * Time: 13:26
 */

namespace Home\Controller;
use Home\Service\MessageService;
class MessageController extends BackendController {
    protected $message_service = null;
    public function __construct()
    {
        parent::__construct();
        $this->message_service = new MessageService();
    }

    public function showList() {
        $data = $this->message_service->getMessages();
        $this->assign("list_data", $data);
        $this->display();
    }

    public function delMessages() {
        $ids = $_POST['ids'];
    }
}