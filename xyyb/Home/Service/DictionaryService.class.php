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
            $dictionary_data = $this->dictionary_model->getDictionaries();
            $tempData = [];
            foreach ($dictionary_data as $value) {
                    $tempData[$value['id']] = $value['code'] . "-->" . $value['value'];
            }
            $this->dictionary_config = $tempData;
        }

        public function formatDictionary($data) {
            foreach ($data as $key => $value) {
                $data[$key]['parent_info'] = $this->dictionary_config[$value['parent']];
            }
            return $data;
        }
    }