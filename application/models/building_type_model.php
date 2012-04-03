<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class Building_Type_Model extends Abstract_Model {
    const BUILDING_TYPE_MANAGEMENT = 'quản lý';
    const BUILDING_TYPE_STADIUM_CONTAINER = 'sức chứa';
    const BUILDING_TYPE_TRANSPORT = 'giao thông';
    const BUILDING_TYPE_SUPPORT = 'hỗ trợ';
    const BUILDING_TYPE_RECOVERY = 'phục hồi';
    const BUILDING_TYPE_SERVICE = 'dịch vụ';
    const BUILDING_TYPE_RESEARCH = 'nghiên cứu';
    const BUILDING_TYPE_TRANSFER = 'chuyển nhượng';

    public function __construct() {
        parent::__construct();
        $this->type = 'building_type';
        $this->database = 'building_type';
    }

    protected function check_existed($data) {
        return $this->_ret(API_SUCCESS, FALSE);
    }

}
