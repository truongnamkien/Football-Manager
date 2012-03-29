<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Team extends MY_Inner_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('player_library', 'street_library'));
        $this->load->language(array('team', 'player', 'formation'));
    }

    public function player() {
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

}