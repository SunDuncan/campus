<?php
    /**
     * author: duncan
     * create_time: 2018-1-25 11:11
     * last_modified_by: duncan
     * last_modified_time: 2018-1-25 11:12
     * function: 字典表的数据处理部分
     **/
    namespace Home\Service;
    use Home\Model\DictionaryModel;
    class DictionaryService extends BaseService
    {
        protected $dictionary_model = null;
        protected $dictionary_config = null;
        public function __construct()
        {
            $this->dictionary_model = new DictionaryModel();
        }


        public function formatDictionary($data = []) {
            //获取全部数据
            $dat = $this->dictionary_model->getDictionaries($data);
            //返回符合条件的记录数目
            $count = $this->dictionary_model->countDictionary($data);
            $this->dictionary_config = $this->getDictionConfig();
            $return['count'] = $count;
            foreach ($dat as $key => $value) {
                $dat[$key]['parent_info'] = $this->dictionary_config[$value['parent']];
            }
            $return['data'] = $dat;
            return $return;
        }

        public function formatTreeDictionary($data = []) {
            $dat = $this->dictionary_model->getTreeDictionaries($data);
            $count = $this->dictionary_model->countDictionary($data);
            $this->dictionary_config = $this->getDictionConfig();
            $return['count'] = $count;
            foreach ($dat as $key => $value) {
                $dat[$key]['parent_info'] = $this->dictionary_config[$value['parent']];
            }
            $return['data'] = $dat;
            return $return;
        }

        /**
         * 按等级分类
         */
        public function levelCategories() {
            $data = $this->dictionary_model->getDictionaries();
            $return = [];
            foreach ($data as &$vo) {
                if (empty($return[$vo['level']])) {
                    $return[$vo['level']] = [];
                }
                array_push($return[$vo['level']], $vo);
            }
            return $return;
        }

        /**
         * 获取字典表的config
         */
        public function getDictionConfig() {
            $dictionary_data = $this->dictionary_model->getDictionaries();
            $tempData = [];
            foreach ($dictionary_data as $value) {
                $tempData[$value['id']] = $value['code'] . "-->" . $value['value'];
            }
            return $tempData;
        }

        /**
         * 数据的封装检验
         * 添加数据
         */
        /**
         * @param $data
         * @return bool|mixed
         */
        public function setDictionary($data = []) {
            if (!$data['p_id']){
                $insertData['level'] = 1;
            } else {
                $insertData['level'] = $data['d_level'] + 1;
            }
            $insertData['parent'] = $data['p_id'];
            if (!$data['p_id']){
                $insertData['origin_ids'] = 0;
            } else {
                $origin_ids = $this->getDictionaryOriginIds($data['p_id']);
                if (!$origin_ids) {
                    $insertData['origin_ids'] = $data['p_id'];
                } else {
                    $insertData['origin_ids'] = $origin_ids . "-->" . $data['p_id'];
                }
            }

            if (!$data['p_id']){
                $insertData['origin_codes'] = "top";
            } else {
                $origin_codes = $this->getDictionaryOriginCodes($data['p_id']);
                if (!$origin_ids) {
                    $insertData['origin_codes'] = $this->getDictionaryCode($data['p_id']);
                } else {
                    $insertData['origin_codes'] = $origin_codes . "-->" . $this->getDictionaryCode($data['p_id']);
                }
            }
            $insertData['code'] = $data['d_code'];
            $insertData['value'] = $data['d_value'];
            $insertData['category'] = "后台添加";
            return $this->dictionary_model->setDictionary($insertData);
        }

        public function getDictionaryOriginIds($id = null) {
            return $this->dictionary_model->getDictionaryOriginIds($id);
        }

        public function getDictionaryOriginCodes($id = null) {
            return $this->dictionary_model->getDictionaryOriginCodes($id);
        }

        public function getDictionaryCode($id = null) {
            return $this->dictionary_model->getDictionaryCode($id);
        }

        /**
         * @param $ids
         * @return mixed|void
         *
         * 批量删除
         */
        public function delDictionaries($ids) {
            if (empty($ids)) {
                return ;
            }

            $array_id = explode("," , $ids);
            M()->startTrans();
            $res = 0;
            foreach ($array_id as &$id) {
                $res = $this->dictionary_model->delDictionary($id);
                if(!$res) {
                    M()->rollback();
                    return ;
                }
            }
            M()->commit();
            return $res;
        }

        /**
         * 单个删除
         */
        /**
         * @param $id
         * @return bool|void
         */
        public function delDictionary($id) {
            if (empty($id)) {
                return ;
            }

            $res = $this->dictionary_model->delDictionary($id);
            if (!$res) {
                return ;
            }
            return $res;
        }

        public function getDictionary($id = '') {
            if (empty($id)) {
                return ;
            }

            $res = $this->dictionary_model->getDictionary($id);
            if ($res['parent'] == 0) {
                $res['p_name'] = "最高层";
            } else {
                $res['p_name'] = $this->dictionary_model->getDictionary($res['parent'])['value'];
            }
            return $res;
        }

        /**
         * @param array $data
         * @return bool|void
         */
        public function saveDictionary($data=[]) {
            if (empty($data)) {
                return ;
            }

            $save_data['parent'] = $data['p_id'];
            $save_data['code'] = $data['d_code'];
            $save_data['value'] = $data['d_value'];
            $save_data['id'] = $data['id'];
            $res = $this->dictionary_model->saveDictionary($save_data);
            return $res;
        }
    }