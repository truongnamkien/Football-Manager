<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Team extends MY_Inner_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('player_library', 'street_library', 'team_formation_library', 'formation_library'));
        $this->load->language(array('team', 'player', 'formation'));
        $this->load->config('formation', TRUE);
    }

    /**
     * Trang danh sách cầu thủ
     */
    public function player() {
        $this->set_title(lang('team_player'));
        $street_id = $this->my_auth->get_street_id();
        $street = $this->street_library->get($street_id);
        $player_list = $this->player_library->get_by_team($street['team_id']);
        $data['player_list'] = array(
            'goalkeeper' => array(),
            'def_wing' => array(),
            'def_center' => array(),
            'mid_wing' => array(),
            'mid_center' => array(),
            'for_wing' => array(),
            'for_center' => array()
        );
        foreach ($player_list as $player) {
            $data['player_list'][$player['position']][] = $player;
        }

        $this->load->view('team_player_list_view', $data);
    }

    /**
     * Trang chỉnh đội hình
     */
    public function formation() {
        $this->set_title(lang('team_formation'));
        $street_id = $this->my_auth->get_street_id();
        $street = $this->street_library->get($street_id);
        
        $data['default_formations'] = $this->formation_library->get_all();

        $data['team_id'] = $street['team_id'];
        $data['formation'] = $this->team_formation_library->get_formation_of_team($street['team_id']);
        if (empty($data['formation'])) {
            $data['formation'] = $data['default_formations'][0];
        }
        $data['player_list'] = $this->player_library->get_by_team($street['team_id']);

        $this->load->view('team_formation_view', $data);
    }

    public function _pagelet_formation($formation_id, $team_id) {
        $this->index = 1;
        $data['formation'] = $this->formation_library->get($formation_id);
        $data['team_id'] = $team_id;
        $this->load->view('pagelet_formation_field', $data);
    }

    public function _pagelet_formation_area($area, $format, $team_id) {
        $available_formats = $this->_get_format_for_area($area);

        $formats = $this->config->item('formation_all_format', 'formation');
        $data['format'] = $formats[$available_formats[$format]];
        $data['team_id'] = $team_id;

        $this->load->view('pagelet_formation_area', $data);
    }

    public function _pagelet_player_select($team_id, $name = FALSE) {
        $data['player_list'] = $this->player_library->get_by_team($team_id);
        if (empty($name)) {
            $data['name'] = 'position_' . $this->index;
            $this->index++;
        } else {
            $data['name'] = $name;
        }

        $this->load->view('pagelet_player_select', $data);
    }

    /**
     * Get available format for area
     * @param type $area
     * @return type 
     */
    private function _get_format_for_area($area) {
        $area_format = $this->config->item('formation_format_for_area', 'formation');
        foreach ($area_format as $key => $value) {
            if (strpos($area, $key) !== FALSE) {
                return $value;
            }
        }
        return FALSE;
    }

}