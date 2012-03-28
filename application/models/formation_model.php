<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class Formation_Model extends Abstract_Model {

    public function __construct() {
        parent::__construct();
        $this->type = 'formation';
        $this->database = 'formation';
    }

    public function get_formation_by_name($name) {
        return $this->get_where(array('name' => $name));
    }

    protected function check_existed($data) {
        $npc = $this->get_formation_by_name($data['name']);
        if ($npc['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }
}

