<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class Team_Model extends Abstract_Model {

    public function __construct() {
        parent::__construct();
        $this->type = 'team';
        $this->database = 'team';
    }
    
    public function get_team_by_name($team_name) {
        return $this->get_where(array('team_name' => $team_name));
    }

    protected function check_existed($data) {
        $street = $this->get_team_by_name($data['team_name']);
        if ($street['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }

}
