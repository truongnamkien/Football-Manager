<?php

require_once(APPPATH . 'libraries/abstract_library.php');

class Map_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();
        $this->type = 'map';
        $this->cache_key = 'map.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('street_model'));
        parent::$CI->load->library(array('street_library'));
    }

    public function create($data) {
        return FALSE;
    }

    public function update($id, $data) {
        return FALSE;
    }

    public function remove($id) {
        return FALSE;
    }

    public function get_all() {
        return FALSE;
    }

    public function count_all() {
        return FALSE;
    }

    public function create_street($area, $street_info) {
        $coor = $this->generate_coordinate($area);
        if ($area === FALSE) {
            $total_row = intval(Street_Model::MAP_HEIGHT / Street_Model::AREA_HEIGHT);

            if ($area !== FALSE) {
                $row = $coor['y_coor'];

                $row = intval($area / $total_row);
                $col = $area % $total_row;

                $min_x = $col * Street_Model::AREA_WIDTH;
                $min_y = $row * Street_Model::AREA_HEIGHT;
                $max_x = $min_x + Street_Model::AREA_WIDTH - 1;
                $max_y = $min_y + Street_Model::AREA_HEIGHT - 1;
            }
        }
        $street_info = array_merge($street_info, $coor);
        if (isset($street_info['street_id'])) {
            unset($street_info['street_id']);
        }
        $street = parent::$CI->street_model->create($street_info);
        if ($street['return_code'] != API_SUCCESS || empty($street['data'])) {
            return FALSE;
        }
        $street = $street['data'];

        // Cập nhật cache
        $area = intval($street['x_coor'] / Street_Model::AREA_WIDTH) + intval($street['y_coor'] / Street_Model::AREA_HEIGHT) * (Street_Model::MAP_HEIGHT / Street_Model::AREA_HEIGHT);
        $streets = $this->get($area);
        $x_coor = $street['x_coor'] % Street_Model::AREA_WIDTH;
        $y_coor = $street['y_coor'] % Street_Model::AREA_HEIGHT;
        $streets[$x_coor][$y_coor] = $street;

        $key = $this->_get_key('cache.object.info', array('$id' => $area));
        parent::$CI->cache->delete($key);
        parent::$CI->cache->save($key, $streets);
        return $street;
    }

    public function get($area, $is_force = FALSE) {
        $key = $this->_get_key('cache.object.info', array('$id' => $area));
        if (!$is_force) {
            $cache_data = parent::$CI->cache->get($key);
            if ($cache_data) {
                return $cache_data;
            }
        } else {
            parent::$CI->cache->delete($key);
        }

        $total_row = intval(Street_Model::MAP_HEIGHT / Street_Model::AREA_HEIGHT);
        $row = intval($area / $total_row);
        $col = $area % $total_row;

        $min_x = $col * Street_Model::AREA_WIDTH;
        $min_y = $row * Street_Model::AREA_HEIGHT;
        $max_x = $min_x + Street_Model::AREA_WIDTH - 1;
        $max_y = $min_y + Street_Model::AREA_HEIGHT - 1;
        $streets = parent::$CI->street_library->get_street_by_area($min_x, $max_x, $min_y, $max_y);
        parent::$CI->cache->save($key, $streets);
        return $streets;
    }

    public function get_by_coor($x_coor, $y_coor) {
        $area = intval($x_coor / Street_Model::AREA_WIDTH) + intval($y_coor / Street_Model::AREA_HEIGHT) * (Street_Model::MAP_HEIGHT / Street_Model::AREA_HEIGHT);
        return $this->get($area);
    }

    private function generate_coordinate($area = FALSE) {
        $min_x = 0;
        $min_y = 0;
        $max_x = Street_Model::MAP_WIDTH;
        $max_y = Street_Model::MAP_HEIGHT;

        $total_row = intval(Street_Model::MAP_HEIGHT / Street_Model::AREA_HEIGHT);

        if ($area !== FALSE) {
            $row = intval($area / $total_row);
            $col = $area % $total_row;

            $min_x = $col * Street_Model::AREA_WIDTH;
            $min_y = $row * Street_Model::AREA_HEIGHT;
            $max_x = $min_x + Street_Model::AREA_WIDTH - 1;
            $max_y = $min_y + Street_Model::AREA_HEIGHT - 1;
        }

        $is_valid = FALSE;
        while (!$is_valid) {
            $x_coor = rand($min_x, $max_x);
            $y_coor = rand($min_y, $max_y);
            $is_valid = $this->check_valid_coordinate($x_coor, $y_coor);
        }

        return array('x_coor' => $x_coor, 'y_coor' => $y_coor);
    }

    private function check_valid_coordinate($x_coor, $y_coor) {
        if ($x_coor == FALSE || $y_coor == FALSE) {
            return FALSE;
        }

        $street = parent::$CI->street_library->get_street_by_coordinate($x_coor, $y_coor);
        return $street === FALSE;
    }

}
