<?php
/**
 * Created by PhpStorm.
 * User: Duncan
 * Date: 2018/1/19
 * Time: 13:24
 */
namespace Home\Controller;
class DictionaryController extends BackendController {

    public function addDictionary() {
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
}