<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Street_Ajax extends MY_Ajax {

    public function __construct() {
        parent::__construct();

        $this->load->library(array('street_library', 'user_library'));
        $this->load->language('building');
        $this->my_auth->login_required();
    }

    public function upgrade($street_building_id = FALSE) {
        if ($street_building_id == FALSE) {
            $street_building_id = $this->input->get_post('street_building_id') | '';
        }
        if (empty($street_building_id)) {
            return FALSE;
        }

        $user_id = $this->my_auth->get_user_id();
        $user = User_Library::get($user_id);
        $street = Street_Library::get($user['street_id']);
        $permission = FALSE;
        if (isset($street['buildings'][$street_building_id])) {
            $permission = TRUE;
        }

        $message = '';
        if ($permission) {
            $fee = Street_Library::get_fee($street_building_id);
            $enough_balance = User_Library::check_enough_balance($fee);
            if ($enough_balance) {
                $street = Street_Library::upgrade($street_building_id);
                if ($street !== FALSE && !is_string($street)) {
                    $cooldowns = $street['cooldowns']['buildings'];
                    $current_time = now();
                    foreach ($cooldowns as $cd) {
                        if ($cd['end_time'] > $current_time) {
                            $this->response->run("Cooldown.init(" . (($cd['end_time'] - $current_time) * 1000) . ", 'cooldown_" . $cd['cooldown_id'] . "')");
                        }
                    }

                    $user = User_Library::update_balance($fee);
                    $this->response->html("#street_building_" . $street_building_id . " .building_level", $street['buildings'][$street_building_id]['level']);
                    if ($user != FALSE) {
                        $this->response->html("#my_balance", $user['balance']);
                    }
                    $message = lang('building_upgrade_success');
                } else {
                    $message = $street;
                }
            } else {
                $message = lang('building_not_enough_money');
            }
        } else {
            $message = lang('building_upgrade_non_permission');
        }
        $this->response->run("show_alert('" . $message . "')");
        $this->response->send();
    }

}
