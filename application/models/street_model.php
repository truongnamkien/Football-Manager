<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class Street_Model extends Abstract_Model {
    const MAP_WIDTH = 100;
    const MAP_HEIGHT = 100;

    const AREA_WIDTH = 10;
    const AREA_HEIGHT = 10;

    const STREET_TYPE_PLAYER = 'player';
    const STREET_TYPE_NPC = 'npc';

    public function __construct() {
        parent::__construct();
        $this->type = 'street';
        $this->database = 'streets';
    }

    protected function check_existed($data) {
        $street = $this->get_where(array('x_coor' => $data['x_coor'], 'y_coor' => $data['y_coor']));
        if ($street['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }
        return $this->_ret(API_SUCCESS, FALSE);
    }

}
