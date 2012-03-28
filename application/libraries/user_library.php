<?php

require_once(APPPATH . 'libraries/abstract_library.php');

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

    /**
     * Create user
     * @param type $data
     * @return type 
     */
    public function create($data) {
        $team = parent::$CI->team_library->create(array('team_name' => $data['team_name']));

        if (empty($team)) {
            return FALSE;
        }
        // Tạo cầu thủ cho team
        $level = round(parent::$CI->config->item('npc_max_per_area', 'npc') / 2, 0);
        parent::$CI->auto_data->auto_create_team_player($level, $team);

        $street = parent::$CI->street_library->create(array('area' => FALSE, 'street_type' => Street_Model::STREET_TYPE_PLAYER, 'team_id' => $team['team_id']));
        if (empty($street)) {
            return FALSE;
        }

        $data['street_id'] = $street['street_id'];
        unset($data['team_name']);
        $data['balance'] = parent::$CI->config->item('user_beginning_balance', 'user');

        return parent::create($data);
    }

    /**
     * Check as if user has enough money
     * @param type $fee
     * @return type
     */
    public function check_enough_balance($fee = 0) {
        $user = $this->get(parent::$CI->my_auth->get_user_id());
        return $user['balance'] >= $fee;
    }

    /**
     * Update money of user
     * @param type $fee
     * @return type 
     */
    public function update_balance($fee = 0) {
        $user_id = parent::$CI->my_auth->get_user_id();
        $user = $this->get($user_id);
        $balance = $user['balance'];
        $balance -= $fee;
        return $this->update($user_id, array('balance' => $balance));
    }

    /**
     * Get user with email
     * @param type $email
     * @return type 
     */
    public function get_user_by_email($email) {
        $user = $this->user_model->get_where(array('email' => $email));
        if ($user['return_code'] == API_SUCCESS && !empty($user['data'])) {
            return $user['data'];
        }
        return FALSE;
    }

}