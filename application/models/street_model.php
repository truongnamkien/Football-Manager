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

    public function update($street_id, $update_data, $filter = array()) {
        unset($update_data['x_coor']);
        unset($update_data['y_coor']);
        return parent::update($id, $update_data, $filter);
    }

    public function get_street_by_area($min_x, $max_x, $min_y, $max_y) {
        $streets = $this->get_where('x_coor >= ' . $min_x . ' and x_coor <= ' . $max_x . ' and y_coor >= ' . $min_y . ' and y_coor <= ' . $max_y);
        if ($streets['return_code'] == API_SUCCESS && !empty($streets['data'])) {
            $streets = $streets['data'];
            $result = array();
            foreach ($streets as $street) {
                $x_coor = $street['x_coor'] % self::AREA_WIDTH;
                $y_coor = $street['y_coor'] % self::AREA_HEIGHT;
                $result[$x_coor][$y_coor] = $street;
            }

            return $this->_ret(API_SUCCESS, $result);
        }

        return $this->_ret(API_FAILED);
    }

    public function get_street_by_coordinate($x_coor, $y_coor) {
        return $this->get_where(array('x_coor' => $x_coor, 'y_coor' => $y_coor));
    }

    protected function check_existed($data) {
        $street = $this->get_street_by_coordinate($data['x_coor'], $data['y_coor']);
        if ($street['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }

}
