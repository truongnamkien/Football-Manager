<?php

require_once(APPPATH . 'libraries/abstract_library.php');

class Building_Type_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();
        $this->type = 'building_type';
        $this->cache_key = 'building_type.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('building_type_model'));
    }

    /**
     * Get the information of building by position
     * @param type $cell
     * @return type 
     */
    public function get_by_cell($cell) {
        $building_types = parent::$CI->building_type_model->get_where(array('street_cell' => $cell));
        if ($building_types['return_code'] == API_SUCCESS && !empty($building_types['data'])) {
            return $building_types['data'];
        }
        return FALSE;
    }

}
