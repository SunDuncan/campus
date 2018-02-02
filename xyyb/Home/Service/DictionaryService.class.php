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
    class DictionaryService
    {
        protected $dictionary_model = null;
        protected $dictionary_config = null;
        public function __construct()
        {
            $this->dictionary_model = new DictionaryModel();
        }

        public function formatDictionary($data) {
            $data = $this->dictionary_model->getDictionaries($data);
            $count = $this->dictionary_model->countDictionary($data);
            $this->dictionary_config = $this->getDictionConfig();
            $return['count'] = $count;
            foreach ($data as $key => $value) {
                $data[$key]['parent_info'] = $this->dictionary_config[$value['parent']];
            }
            $return['data'] = $data;
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
         */
        public function setDictionary($data) {
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

        public function getDictionaryOriginIds($id) {
            return $this->dictionary_model->getDictionaryOriginIds($id);
        }

        public function getDictionaryOriginCodes($id) {
            return $this->dictionary_model->getDictionaryOriginCodes($id);
        }

        public function getDictionaryCode($id) {
            return $this->dictionary_model->getDictionaryCode($id);
        }
    }