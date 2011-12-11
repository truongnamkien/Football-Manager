<?php

class Team_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();

        $this->type = 'team';
        $this->cache_key = 'team.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('team_model'));
    }

    public function get($team_id, $is_force = FALSE) {
        return parent::get($team_id, $is_force, array());
    }

}