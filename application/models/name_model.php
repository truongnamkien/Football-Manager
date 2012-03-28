<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class Name_Model extends Abstract_Model {
    const CATEGORY_FIRST_NAME = 'Tên';
    const CATEGORY_LAST_NAME = 'Họ';
    const CATEGORY_MIDDLE_NAME = 'Tên lót';

    public function __construct() {
        parent::__construct();
        $this->type = 'name';
        $this->database = 'name';
    }
    
    /**
     * Get the list of name objects of a category
     * @param type $category
     * @param type $name
     * @return type 
     */
    public function get_name($category, $name = '') {
        $filter = array('category' => $category);
        if (!empty($name)) {
            $filter['name'] = $name;
        }
        return $this->get_where($filter);
    }

    protected function check_existed($data) {
        $name = $this->get_name($data['category'], $data['name']);
        if ($name['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }
}