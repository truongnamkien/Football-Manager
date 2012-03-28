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

}
