<?php

class Map_Library extends Abstract_Library {

    private static $map_info = FALSE;
    private static $cache_key = 'map.info:';

    function __construct() {
        parent::__construct();
        parent::$CI->load->model(array('street_model'));
    }

    public static function generate_coordinate($area = FALSE) {
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
            $is_valid = self::check_valid_coordinate($x_coor, $y_coor);
        }

        return array('x_coor' => $x_coor, 'y_coor' => $y_coor);
    }

    public static function check_valid_coordinate($x_coor, $y_coor) {
        if ($x_coor == FALSE || $y_coor == FALSE) {
            return FALSE;
        }

        $street = parent::$CI->street_model->get_street_by_coordinate($x_coor, $y_coor);
        if ($street['return_code'] == API_SUCCESS && !empty($street['data'])) {
            return FALSE;
        }
        return TRUE;
    }

    public static function create_street($area, $street_info) {
        $coor = self::generate_coordinate($area);
        if ($area == FALSE) {
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
        $street = parent::$CI->street_model->create_street($street_info);
        if ($street['return_code'] != API_SUCCESS || empty($street['data'])) {
            return FALSE;
        }
        $street = $street['data'];

        // Cập nhật cache
        $area = intval($street['x_coor'] / Street_Model::AREA_WIDTH) + intval($street['y_coor'] / Street_Model::AREA_HEIGHT) * (Street_Model::MAP_HEIGHT / Street_Model::AREA_HEIGHT);
        $streets = self::get_area($area);
        $x_coor = $street['x_coor'] % Street_Model::AREA_WIDTH;
        $y_coor = $street['y_coor'] % Street_Model::AREA_HEIGHT;
        $streets[$x_coor][$y_coor] = $street;
        parent::$CI->cache->delete(self::$cache_key . $area);
        parent::$CI->cache->save(self::$cache_key . $area, $streets);
        self::$map_info[$area] = $streets;

        return $street;
    }

    public static function get_area($area) {
        if (self::$map_info != FALSE && isset(self::$map_info[$area]) && !empty(self::$map_info[$area])) {
            return self::$map_info[$area];
        }
        $cache_data = parent::$CI->cache->get(self::$cache_key . $area);
        if ($cache_data) {
            self::$map_info[$area] = $cache_data;
            return self::$map_info[$area];
        }

        $total_row = intval(Street_Model::MAP_HEIGHT / Street_Model::AREA_HEIGHT);
        $row = intval($area / $total_row);
        $col = $area % $total_row;

        $min_x = $col * Street_Model::AREA_WIDTH;
        $min_y = $row * Street_Model::AREA_HEIGHT;
        $max_x = $min_x + Street_Model::AREA_WIDTH - 1;
        $max_y = $min_y + Street_Model::AREA_HEIGHT - 1;
        $streets = parent::$CI->street_model->get_street_by_area($min_x, $max_x, $min_y, $max_y);
        if ($streets['return_code'] != API_SUCCESS || empty($streets['data'])) {
            return FALSE;
        }
        $streets = $streets['data'];
        parent::$CI->cache->save(self::$cache_key . $area, $streets);
        self::$map_info[$area] = $streets;
        return self::$map_info[$area];
    }

    public static function get_area_by_coor($x_coor, $y_coor) {
        $area = intval($x_coor / Street_Model::AREA_WIDTH) + intval($y_coor / Street_Model::AREA_HEIGHT) * (Street_Model::MAP_HEIGHT / Street_Model::AREA_HEIGHT);
        return self::get_area($area);
    }

}
