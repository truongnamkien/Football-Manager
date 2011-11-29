<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Street extends MY_Inner_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('user_library', 'street_library'));
        $this->load->language('building');
    }

    public function index() {
        $user_id = $this->my_auth->get_user_id();
        $user = $this->user_library->get($user_id);
        $street = $this->street_library->get($user['street_id']);

        $data['buildings'] = $street['buildings'];
        $data['street'] = $street;
        $data['balance'] = $user['balance'];
        $data['current_time'] = now();

        $data['cooldowns'] = array();
        if (isset($street['cooldowns']['buildings'])) {
            foreach ($street['cooldowns']['buildings'] as $cd) {
                $data['cooldowns'][$cd['cooldown_id']] = $cd;
            }
        }

        $this->load->view('street_building_view', $data);
    }

}