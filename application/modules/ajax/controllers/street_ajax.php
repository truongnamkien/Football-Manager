<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Street_Ajax extends MY_Ajax {

    public function __construct() {
        parent::__construct();

        $this->load->library(array('street_library', 'user_library'));
        $this->load->language('building');
    }

    public function upgrade() {
        $building_street_id = $this->input->get_post('bs');
        $street_id = $this->input->get_post('st');

        $user_id = $this->my_auth->get_user_id();
        User_Library::get($user_id);
        $user_info = User_Library::execute();
        $street_info = $user_info['street'];
        $buildings = $street_info['buildings'];
        $permission = FALSE;
        if ($street_info['street_id'] == $street_id && isset($buildings[$building_street_id])) {
            $permission = TRUE;
        }

        $message = '';
        if ($permission) {
            $ret = Street_Library::upgrade($buildings[$building_street_id]['building_type_id']);
            if ($ret['return_code'] == API_SUCCESS) {
                $message = lang('building_upgrade') . ' ' . lang('building_success');
            } else {
                $message = lang('building_upgrade') . ' ' . lang('building_failed');
            }
        } else {
            $message = lang('building_upgrade_non_permission');
        }
        $this->response->run("alert('" . $message . "')");
        $this->response->send();
    }
    
    public function downgrade() {
        $building_street_id = $this->input->get_post('bs');
        $street_id = $this->input->get_post('st');

        $user_id = $this->my_auth->get_user_id();
        User_Library::get($user_id);
        $user_info = User_Library::execute();
        $street_info = $user_info['street'];
        $buildings = $street_info['buildings'];
        $permission = FALSE;
        if ($street_info['street_id'] == $street_id && isset($buildings[$building_street_id])) {
            $permission = TRUE;
        }

        $message = '';
        if ($permission) {
            $ret = Street_Library::downgrade($buildings[$building_street_id]['building_type_id']);
            if ($ret['return_code'] == API_SUCCESS) {
                $message = lang('building_downgrade') . ' ' . lang('building_success');
            } else {
                $message = lang('building_downgrade') . ' ' . lang('building_failed');
            }
        } else {
            $message = lang('building_downgrade_non_permission');
        }
        $this->response->run("alert('" . $message . "')");
        $this->response->send();
    }
    
}
