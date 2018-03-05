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

    public function setDictionary() {
        $data = I('post.');
        $res = $this->dictionaryService->setDictionary($data);
        if (!$res) {
            $this->error("添加失败");
        } else {
            $this->success("添加成功");
        }
    }
    /**************************************************************/
    /**
     * 同步到实际的数据
     */
    public function index() {
        $list_data = $this->dictionaryService->formatTreeDictionary();
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
        $id = I('get.id');
        $list_data = $this->dictionaryService->formatTreeDictionary();
        $this->assign("list_data", $list_data['data']);
        $this->assign("id", $id);
        $this->display();
    }


    /**
     * @param $data
     * @return mixed
     */
    //返回数据
    public function getDictionaries($data = []) {
        $dictionaries = $this->dictionaryService->formatDictionary($data);
        return $dictionaries;
    }

    /**************************************************************/
    /**
     * 逻辑删除
     */
    public function delDictionaries() {
        $post = I('post.');
        $ids  = $post['ids'];
        $res = $this->dictionaryService->delDictionaries($ids);
        if (!$res) {
            $this->ajaxError('失败', '字典批量删除失败', 400);
        } else {
            $this->ajaxSuccess($res);
        }
    }

    public function delDictionary() {
        $post = I('post.');
        $id = $post['id'];
        $res = $this->dictionaryService->delDictionary($id);
        if (!$res) {
            $this->ajaxError('失败', '字典删除失败', 400);
        } else {
            $this->ajaxSuccess($res);
        }
    }
    /************************************************************/

    public function editDictionary() {
        $id = I('get.id');
        $data = $this->dictionaryService->getDictionary($id);
        $this->assign("list_data", $data);
        $this->display();
    }

    public function saveDictionary() {
        $data = I('post.');
        $res = $this->dictionaryService->saveDictionary($data);
        if (!$res) {
            $this->error("修改失败");
        } else {
            $this->success("修改成功");
        }
    }
}