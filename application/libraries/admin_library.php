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

    /**
     * Get admin by username
     * @param type $username
     * @return type 
     */
    public function get_by_username($username) {
        $admin = $this->user_model->get_where(array('username' => $username));
        if ($admin['return_code'] == API_SUCCESS && !empty($admin['data'])) {
            return $admin['data'];
        }
        return FALSE;
    }

}