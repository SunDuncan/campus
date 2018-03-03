<?php
namespace Home\Controller;

class IndexController extends BackendController {
    public function index(){
        $this->display();
    }

    public function welcome() {
        $this->display();
    }
}