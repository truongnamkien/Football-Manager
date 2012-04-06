<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Inner_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->language('user');
        $this->load->library(array('user_library', 'street_library', 'cooldown_library', 'team_library'));
        $this->load->model(array('cooldown_model'));
    }

    public function _user_info() {
        $current_time = now();
        $user_id = $this->my_auth->get_user_id();

        $user_info = $this->user_library->get($user_id);
        $data['street_info'] = $this->street_library->get($user_info['street_id']);
        $data['team_info'] = $this->team_library->get($data['street_info']['team_id']);

        $building_cooldowns = $this->cooldown_library->get_by_type($user_info['street_id'], Cooldown_Model::COOLDOWN_TYPE_BUILDING);
        if (isset($building_cooldowns['cooldown_id'])) {
            $building_cooldowns = array($building_cooldowns);
        }

        $data['building_cooldowns'] = array();
        if (!empty($building_cooldowns)) {
            foreach ($building_cooldowns as &$cd) {
                $cd['end_time'] = (intval($cd['end_time']) - $current_time) * 1000;
                if ($cd['end_time'] > 0) {
                    $data['building_cooldowns'][] = $cd;
                }
            }
        }

        $data['user_info'] = $user_info;
        $this->load->view('user_info_view', $data);
    }

}
