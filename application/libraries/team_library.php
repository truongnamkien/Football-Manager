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
        parent::$CI->load->model(array('team_model', 'player_model'));
        parent::$CI->load->language('team');
    }

    public function get($team_id, $is_force = FALSE) {
        return parent::get($team_id, $is_force, array());
    }

    public function create($data = array()) {
        if (empty($data)) {
            $data['team_name'] = lang('team_team');
        }
        $team = parent::create($data);
        return parent::update($team['team_id'], array('team_name' => $team['team_name'] . ' ' . $team['team_id']));
    }
    
    public function remove($id) {
        parent::remove($id);
        
        // Xóa team phải xóa hết player
        parent::$CI->player_model->delete_where(array('team_id' => $team_id));
    }

}