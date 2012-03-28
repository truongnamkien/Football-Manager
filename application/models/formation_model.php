<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class Formation_Model extends Abstract_Model {

    public function __construct() {
        parent::__construct();
        $this->type = 'formation';
        $this->database = 'formation';
    }

    protected function check_existed($data) {
        $npc = $this->get_where(array('name' => $data['name']));
        if ($npc['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }
}

