<?php
/**
 * Created by PhpStorm.
 * User: Duncan
 * Date: 2018/1/19
 * Time: 13:24
 * Last_Modified_Time: 2018/1/24 10:52
 */
namespace Home\Controller;
use Home\Model\DictionaryModel;
class DictionaryController extends BackendController {

    protected $dictionaryModel;
    public function __construct()
    {
        parent::__construct();
        $this->dictionaryModel = new DictionaryModel();
    }

    public function addDictionary() {
            $get = I('get.');
            $id = $get['id'] ? $get['id'] : 0;
            $pId = $get['pId'];
            $name = $get['name'] ? $get['name'] : "最高层";
            $level = $get['level'];
            $this->assign('level', $level + 1);
            $this->assign('id', $id);
            $this->assign('pId', $pId);
            $this->assign('name', $name);
            $this->display();
    }

    public function index() {
        $this->display();
    }

    public function showList() {
        $end_min_date = '#F{$dp.$D(' . '\\' . '\'logmin' . '\\' . '\'' . ')}';
        $start_max_date = '#F{$dp.$D(' . '\\' . '\'logmax' . '\\' . '\')||' . '\\' . '\'%y-%M-%d' . '\\' . '\'}';
        $this->assign('START_MAX_DATE', $start_max_date);
        $this->assign('END_MIN_DATE', $end_min_date);
        $this->display();
    }

    public function listIndex() {
        $this->display();
    }

    public function post() {
        $post = I('post.');
        $data = [];
        $data['parent'] = $post['p_id'];
        $data['category'] = $post['d_name'];
        $data['code'] = $post['d_code'];
        $data['value'] = $post['d_value'];
        $data['level'] = $post['d_level'];
        $this->setDictionary($data);
    }

    public function setDictionary($data) {
        $res = $this->dictionaryModel->setDictionary($data);
        if (!$res) {
            $this->error("添加失败");
        } else {
            $this->success("添加成功");
        }
    }
    
    public function getDictionaries() {
        $data = $this->dictionaryModel->getDictionaries();
        var_dump($data);
    }
}