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
use Home\Service\DictionaryService;
class DictionaryController extends BackendController {

    protected $dictionaryService;
    protected $dictionaryModel;
    public function __construct()
    {
        parent::__construct();
        $this->dictionaryModel = new DictionaryModel();
        $this->dictionaryService = new DictionaryService();
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

    /**
     * 同步到实际的数据
     */
    public function index() {
        $list_data = $this->dictionaryService->formatDictionary();
        $this->assign("list_data", $list_data['data']);
        $this->display();
    }

    public function showList() {
        $end_min_date = '#F{$dp.$D(' . '\\' . '\'logmin' . '\\' . '\'' . ')}';
        $start_max_date = '#F{$dp.$D(' . '\\' . '\'logmax' . '\\' . '\')||' . '\\' . '\'%y-%M-%d' . '\\' . '\'}';
        $data = I('get.') ? I("get.") : [];
        $list_data = $this->getDictionaries($data);
        $this->assign('list', $list_data['data']);
        $this->assign('count', $list_data['count']);
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
    
    public function getDictionaries($data) {
        $dictionaries = $this->dictionaryService->formatDictionary($data);
        return $dictionaries;
    }

    public function delDictionaries() {
        $post = I('post.');
        var_dump($post);
    }

    public function delDictionary() {

    }
}