<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class Player_Model extends Abstract_Model {

    public function __construct() {
        parent::__construct();
        $this->type = 'player';
        $this->database = 'player';
    }

    protected function check_existed($data) {
        return $this->_ret(API_SUCCESS, FALSE);
    }

}

