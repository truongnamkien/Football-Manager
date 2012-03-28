<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class Team_Formation_Model extends Abstract_Model {

    public function __construct() {
        parent::__construct();
        $this->type = 'team_formation';
        $this->database = 'team_formation';
    }

    public function get_formation_of_team($team_id) {
        return $this->get_where(array('team_id' => $team_id));
    }

    protected function check_existed($data) {
        $npc = $this->get_formation_of_team($data['team_id']);
        if ($npc['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }
}

