<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Street_Ajax extends MY_Ajax {

    public function __construct() {
        parent::__construct();

        $this->load->library(array('street_library', 'user_library', 'building_library'));
        $this->load->language('building');
        $this->my_auth->login_required();
    }

    /**
     * Nâng cấp nhà
     * @param type $street_building_id
     * @return type
     */
    public function upgrade($street_building_id = FALSE) {
        if ($street_building_id == FALSE) {
            $street_building_id = $this->input->get_post('street_building_id') | '';
        }
        if (empty($street_building_id)) {
            $message = lang('building_upgrade_non_permission');
        } else {
            $street_building = $this->building_library->get($street_building_id);
            $user_id = $this->my_auth->get_user_id();
            $user = $this->user_library->get($user_id);
            $permission = FALSE;
            if ($street_building['street_id'] == $user['street_id']) {
                $permission = TRUE;
            }

            if ($permission) {
                $enough_balance = $this->user_library->check_enough_balance($street_building['fee']);
                if ($enough_balance) {
                    $ret = $this->building_library->upgrade($street_building_id);
                    if (is_string($ret)) {
                        $message = $ret;
                    } else {
                        $cooldown = $ret['cooldown'];
                        $building = $ret['building'];
                        $current_time = now();
                        if ($cooldown['end_time'] > $current_time) {
                            $this->response->run("Cooldown.init(" . (($cooldown['end_time'] - $current_time) * 1000) . ", " . $cooldown['cooldown_id'] . ");");
                        }
                        $user = $this->user_library->update_balance($street_building['fee']);
                        $this->response->html("#street_building_" . $street_building_id . "_level", $building['level']);
                        if ($user != FALSE) {
                            $this->response->html("#user_balance", $user['balance']);
                        }
                        $message = lang('building_upgrade_success');
                    }
                } else {
                    $message = lang('building_not_enough_money');
                }
            } else {
                $message = lang('building_upgrade_non_permission');
            }
        }
        $this->response->run("show_alert('" . $message . "')");
        $this->response->send();
    }

    /**
     * Hiển thị thông tin chi tiết của building trong lightbox
     * @param type $cell 
     */
    public function show_building_detail($cell) {
        $html = Modules::run('street/building', $cell);

        $this->load->library('my_dialog');
        $this->my_dialog->set_body($html);
        $this->my_dialog->run(2);
    }

}

