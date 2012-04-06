<?php

require_once(APPPATH . 'libraries/abstract_library.php');

class Street_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();

        $this->type = 'street';
        $this->cache_key = 'street.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('street_model', 'street_building_model'));
        parent::$CI->load->library(array('building_library', 'map_library', 'team_library', 'cooldown_library'));
        parent::$CI->load->language('building');
    }

    /**
     * Create a street object and its data
     * @param type $data
     * @return type
     */
    public function create($data) {
        if (!isset($data['street_type']) || !isset($data['area']) || !isset($data['team_id'])) {
            return FALSE;
        }

        $street = parent::$CI->map_library->create_street($data['area'], array('street_type' => $data['street_type'], 'team_id' => $data['team_id']));
        if ($data['street_type'] == Street_Model::STREET_TYPE_PLAYER) {
            parent::$CI->building_library->create_building_for_street($street['street_id']);
        }
        return $this->get($street['street_id'], TRUE);
    }

    /**
     * Remove a street object and its data
     * @param type $street_id 
     */
    public function remove($street_id) {
        $street = $this->get($street_id, TRUE);

        // Remove buildings
        if (isset($street['buildings']) && !empty($street['buildings'])) {
            foreach ($street['buildings'] as $building) {
                parent::$CI->building_library->remove($building['street_building_id']);
            }
        }
        $buildings = parent::$CI->builiding_library->get_all($street_id);
        if (!empty($buildings)) {
            if (isset($buildings['street_building_id'])) {
                $buildings = array($buildings);
            }
            foreach ($buildings as $building) {
                parent::$CI->builiding_library->remove($building['street_building_id']);
            }
        }

        // Remove cooldowns
        $cooldowns = parent::$CI->cooldown_library->get_by_street($street_id);
        if (!empty($cooldowns)) {
            if (isset($cooldowns['cooldown_id'])) {
                $cooldowns = array($cooldowns);
            }
            foreach ($cooldowns as $cd) {
                parent::$CI->cooldown_library->remove($cd['cooldown_id']);
            }
        }
        parent::remove($street_id);

        // Xóa street thì phải xóa luôn team của street
        parent::$CI->team_library->remove($street['team_id']);
    }

    /**
     * Get the street with the coordinate
     * @param type $x_coor
     * @param type $y_coor
     * @return type 
     */
    public function get_street_by_coordinate($x_coor, $y_coor) {
        $street = parent::$CI->street_model->get_where(array('x_coor' => $x_coor, 'y_coor' => $y_coor));
        if ($street['return_code'] == API_SUCCESS && !empty($street['data'])) {
            return $street['data'];
        }
        return FALSE;
    }

    /**
     * Get the street in the area
     * @param type $min_x
     * @param type $max_x
     * @param type $min_y
     * @param type $max_y
     * @return type 
     */
    public function get_street_by_area($min_x, $max_x, $min_y, $max_y) {
        $streets = parent::$CI->street_model->get_where('x_coor >= ' . $min_x . ' and x_coor <= ' . $max_x . ' and y_coor >= ' . $min_y . ' and y_coor <= ' . $max_y);
        if ($streets['return_code'] == API_SUCCESS && !empty($streets['data'])) {
            $streets = $streets['data'];
            if (isset($streets['street_id'])) {
                $streets = array($streets);
            }
            $result = array();
            foreach ($streets as $street) {
                $x_coor = $street['x_coor'] % Street_Model::AREA_WIDTH;
                $y_coor = $street['y_coor'] % street_model::AREA_HEIGHT;
                $result[$x_coor][$y_coor] = $street;
            }
            return $result;
        }
        return FALSE;
    }

}