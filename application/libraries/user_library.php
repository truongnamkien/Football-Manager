<?php

class User_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();

        $this->type = 'user';
        $this->cache_key = 'user.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('user_model', 'street_model'));
        parent::$CI->load->library(array('street_library', 'team_library', 'auto_data'));
        parent::$CI->load->config('user', TRUE);
        parent::$CI->load->config('npc', TRUE);
    }

    public function get($id, $is_force = FALSE) {
        return parent::get($id, $is_force, array());
    }

    public function create($data) {
        $team = parent::$CI->team_library->create(array('team_name' => $data['team_name']));
        
        if ($team == NULL) {
            return NULL;
        }
        // Tạo cầu thủ cho team
        $level = round(parent::$CI->config->item('npc_max_per_area', 'npc') / 2, 0);
        parent::$CI->auto_data->auto_create_team_player($level, $team);
        
        $street = parent::$CI->street_library->create(array('area' => FALSE, 'street_type' => Street_Model::STREET_TYPE_PLAYER, 'team_id' => $team['team_id']));
        if ($street == NULL) {
            return NULL;
        }
        
        $data['street_id'] = $street['street_id'];
        unset($data['team_name']);
        $data['balance'] = parent::$CI->config->item('user_beginning_balance', 'user');

        return parent::create($data);
    }

    public function check_enough_balance($fee = 0) {
        $user = $this->get(parent::$CI->my_auth->get_user_id());
        return $user['balance'] >= $fee;
    }

    public function update_balance($fee = 0) {
        $user_id = parent::$CI->my_auth->get_user_id();
        $user = $this->get($user_id);
        $balance = $user['balance'];
        $balance -= $fee;
        return $this->update($user_id, array('balance' => $balance));
    }

}