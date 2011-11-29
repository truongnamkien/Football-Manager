<?php

class NPC_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();

        $this->type = 'npc';
        $this->cache_key = 'npc.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('npc_model'));
    }

    public function get($id, $is_force = FALSE) {
        return parent::get($id, $is_force, array());
    }
}
