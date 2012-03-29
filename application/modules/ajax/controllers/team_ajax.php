<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Team_Ajax extends MY_Ajax {

    public function __construct() {
        parent::__construct();

        $this->load->library(array('player_library', 'team_formation_library', 'formation_library'));
        $this->load->language(array('team'));
        $this->my_auth->login_required();
    }

    /**
     * Lưu đội hình
     */
    public function save_formation() {
        $street_id = $this->my_auth->get_street_id();
        $street = $this->street_library->get($street_id);
        $team_id = $street['team_id'];

        $formation_id = $this->input->get_post('formation_id');
        if ($formation_id && $formation = $this->formation_library->get($formation_id)) {
            $positions = array('goalkeeper');
            for ($i = 1; $i < 11; $i++) {
                $positions[] = 'position_' . $i;
            }
            $formation_data = $this->_collect($positions);
            $ret = $this->_validate_formation_info($formation_data, $team_id);
            if ($ret == TRUE) {
                $formation_data['formation_id'] = $formation_id;
                $formation_data['team_id'] = $team_id;
                $team_formation = $this->team_formation_library->get_formation_of_team($team_id);
                if (!empty($team_formation)) {
                    $this->team_formation_library->update($team_formation['team_formation_id'], $formation_data);
                } else {
                    $this->team_formation_library->create($formation_data);
                }
                $this->my_asyncresponse->run("show_alert('" . lang('team_formation_success_save') . "');");
            } else {
                $this->my_asyncresponse->run("show_alert('" . lang('team_formation_error_invalid_player') . "');");
            }
        } else {
            $this->my_asyncresponse->run("show_alert('" . lang('team_formation_error_invalid_formation') . "');");
        }
        $this->my_asyncresponse->send();
    }

    /**
     * Cập nhật field sang đội hình mới
     * @return type 
     */
    public function update_formation() {
        $formation_id = $this->input->get_post('formation_id');
        $street_id = $this->my_auth->get_street_id();
        $street = $this->street_library->get($street_id);
        $team_id = $street['team_id'];
        $html = Modules::run('team/_pagelet_formation', $formation_id, $team_id);
        $this->my_asyncresponse->html("#formation_field", $html);
        $this->my_asyncresponse->send();
    }

    /*
     * Check xem đội hình cập nhật có bị trùng không
     */

    private function _validate_formation_info($player_list, $team_id) {
        $checked_players = array();
        foreach ($player_list as $player_id) {
            if (empty($player_id) || in_array($player_id, $checked_players)) {
                return FALSE;
            } else {
                $player = $this->player_library->get_where(array('player_id' => $player_id, 'team_id' => $team_id));
                if ($player) {
                    $checked_players[] = $player_id;
                } else {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

}