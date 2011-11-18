<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Street extends MY_Inner_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('street_building_model', 'building_type_model'));
        $this->load->library('user_library');
        $this->load->language('building');
    }

    public function index() {
        $user_id = $this->my_auth->get_user_id();
        User_Library::get($user_id);
        $user_info = User_Library::execute();
        $street_info = $user_info['street'];
        $buildings = $street_info['building_types'];

        $data['buildings'] = $buildings;
        $data['street'] = $street_info;
        $data['balance'] = $user_info['balance'];
        $data['current_time'] = now();
        
        $data['cooldowns'] = array();
        foreach ($street_info['cooldowns']['buildings'] as $cd) {
            if ($cd['end_time'] != NULL && $cd['end_time'] > $data['current_time']) {
                $data['cooldowns'][$cd['cooldown_id']] = $cd;
            }
        }
        
        $this->load->view('street_building_view', $data);
    }

}