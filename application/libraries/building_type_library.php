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

    public function get($id, $is_force = FALSE) {
        return parent::get($id, $is_force, array());
    }
}
