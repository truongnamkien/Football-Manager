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
        parent::$CI->load->config('user', TRUE);
    }

    public function get($id, $is_force = FALSE) {
        return parent::get($id, $is_force, array());
    }

    public function create($data) {
        $street = parent::$CI->street_library->create(FALSE, Street_Model::STREET_TYPE_PLAYER);
        $data['street_id'] = $street['street_id'];
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