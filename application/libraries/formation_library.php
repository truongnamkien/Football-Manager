<?php

require_once(APPPATH . 'libraries/abstract_library.php');

class Formation_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();
        $this->type = 'formation';
        $this->cache_key = 'formation.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('formation_model'));
        parent::$CI->load->config('formation', TRUE);
        parent::$CI->load->language(array('formation'));
    }

    /**
     * Get the formation with name
     * @param type $name
     * @return type 
     * 
     */
    public function get_formation_by_name($name) {
        $formation = $this->user_model->get_where(array('name' => $name));
        if ($formation['return_code'] == API_SUCCESS && !empty($formation['data'])) {
            return $formation['data'];
        }
        return FALSE;
    }

}
