<?php
require_once(APPPATH . 'libraries/abstract_library.php');

class Admin_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();
        $this->type = 'admin';
        $this->cache_key = 'admin.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );

        parent::$CI->load->model(array('admin_model'));
    }

}