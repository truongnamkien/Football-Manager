<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class NPC_Model extends Abstract_Model {

    public function __construct() {
        parent::__construct();
        $this->type = 'npc';
        $this->database = 'npc';
    }

    protected function check_existed($data) {
        $npc = $this->get_where(array('street_id' => $data['street_id']));
        if ($npc['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }

}

