<?php
/**
 * Created by PhpStorm.
 * User: Duncan
 * Date: 2018/1/19
 * Time: 13:26
 */
namespace Home\Controller;
class UserController extends BackendController {
    public function  addUser() {
        $this->display();
    }

    public function postUser() {

    }

    public function showList() {
        $this->display();
    }
}