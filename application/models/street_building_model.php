<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class Street_Building_Model extends Abstract_Model {
    const MAX_LEVEL = 20;
    const LEVEL_PER_SECTION = 5;

    public function __construct() {
        parent::__construct();
        $this->type = 'street_building';
        $this->database = 'street_building';
        $this->load->model('building_type_model');
    }

    public function create($building_data) {
        $data = array(
            'street_id' => $building_data['street_id'],
            'building_type_id' => $building_data['building_type_id'],
            'level' => ($building_data['type'] == Building_Type_Model::BUILDING_TYPE_MANAGEMENT ? 1 : 0)
        );
        return parent::create($data);
    }

    protected function check_existed($data) {
        $street_building = $this->get_where(array('street_id' => $data['street_id'], 'building_type_id' => $data['building_type_id']));
        if ($street_building['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }

}
