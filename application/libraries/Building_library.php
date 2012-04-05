<?php

require_once(APPPATH . 'libraries/abstract_library.php');

class Building_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();
        $this->type = 'street_building';
        $this->cache_key = 'street_building.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type . '.$street_id',
        );
        parent::$CI->load->model(array('street_building_model', 'building_type_model'));
        parent::$CI->load->library(array('building_type_library'));
        parent::$CI->load->language('building');
    }

    public function get($street_building_id, $is_force = FALSE) {
        return parent::get($street_building_id, $is_force, array('after_get' => 'after_get_callback'));
    }

    /**
     * Get all buildings of a street
     * @param type $street_id
     * @param type $is_force
     * @return type 
     */
    public function get_all($street_id = FALSE, $is_force = FALSE) {
        if (empty($street_id)) {
            $street_id = parent::$CI->my_auth->get_street_id();
        }
        $key_all = $this->_get_key('cache.object.info.all', array('$street_id' => $street_id));
        if (!$is_force) {
            $cache_data = parent::$CI->cache->get($key_all);
            if ($cache_data) {
                return $cache_data;
            }
        } else {
            parent::$CI->cache->delete($key_all);
        }

        $buildings = parent::$CI->street_building_model->get_where(array('street_id' => $street_id));
        if ($buildings['return_code'] == API_SUCCESS && !empty($buildings['data'])) {
            $buildings = $buildings['data'];
            if (isset($buildings['street_building_id'])) {
                $buildings = array($buildings);
            }
        } else {
            $buildings = array();
        }
        $result = array();
        foreach ($buildings as $building) {
            $building = $this->get_building_extra_info($building);
            $street_building_id = $building['street_building_id'];
            $result[$street_building_id] = $building;

            $key = $this->_get_key('cache.object.info', array('$id' => $street_building_id));
            parent::$CI->cache->delete($key);
            parent::$CI->cache->save($key, $building);
        }
        parent::$CI->cache->save($key_all, $result);
        return $result;
    }

    public function count_all() {
        return FALSE;
    }

    /**
     * Get building of a street by type
     * @param type $street_id
     * @param type $type
     * @return type 
     */
    public function get_by_type($street_id, $type) {
        $buildings = $this->get_all($street_id);
        foreach ($buildings as $building) {
            if ($building['type'] == $type) {
                return $building;
            }
        }
        return FALSE;
    }

    /**
     * Upgrade a building
     * @param type $street_building_id
     * @return type 
     */
    public function upgrade($street_building_id) {
        $building = $this->get($street_building_id);
        $street_id = parent::$CI->my_auth->get_street_id();

        if (empty($building)) {
            return lang('building_upgrade_error');
        }
        $level = $building['level'];
        if ($building['type'] != Building_Type_Model::BUILDING_TYPE_MANAGEMENT) {
            $manage_building = $this->get_by_type($street_id, Building_Type_Model::BUILDING_TYPE_MANAGEMENT);
            $max_level = (!empty($manage_building) ? $manage_building['level'] : Street_Building_Model::MAX_LEVEL);
        } else {
            $max_level = Street_Building_Model::MAX_LEVEL;
        }
        if ($level < $max_level) {
            $building = $this->update($street_building_id, array('level' => ($level + 1)));
            if (empty($building)) {
                return lang('building_upgrade_error');
            }
            return $building;
        } else if (isset($manage_building)) {
            return lang_key('building_upgrade_max_level_2', '', array('name' => $manage_building['name']));
        } else {
            return lang('building_upgrade_max_level_1');
        }
    }

    /**
     * Create building for street
     * @param type $street_id
     * @return type 
     */
    public function create_building_for_street($street_id) {
        $building_types = parent::$CI->building_type_library->get_all();

        $buildings = array();
        foreach ($building_types as $type) {
            $type['street_id'] = $street_id;
            $buildings[] = $this->create($type);
        }
        return $buildings;
    }

    /**
     * Get full info of a building
     * @param type $building
     * @return type 
     */
    private function get_building_extra_info($building) {
        $building_type = parent::$CI->building_type_library->get($building['building_type_id']);
        $building = array_merge($building, $building_type);
        $fee = $building['beginning_fee'];
        $rate = $building['fee_rate'];
        $level = $building['level'];
        for ($i = 1; $i < $level; $i++) {
            $fee = $fee * $rate;
        }
        $building['fee'] = $fee;
        return $building;
    }

    protected function after_get_callback($building) {
        return $this->get_building_extra_info($building);
    }

    /**
     * Get the building in the cell of the street
     * @param type $street_id
     * @param type $cell
     * @return type 
     */
    public function get_by_street_cell($street_id, $cell) {
        $building_types = parent::$CI->building_type_library->get_by_cell($cell);

        if (!empty($building_types)) {
            if (isset($building_types['building_type_id'])) {
                $buildings = $this->get_by_type($street_id, $building_types['building_type_id']);
            } else {
                $buildings = array();
                foreach ($building_types as $type) {
                    $building = $this->get_street_building($street_id, $type['building_type_id']);
                    $buildings[] = $this->get_building_extra_info($building);
                }
            }
            return $buildings;
        }
        return FALSE;
    }

    /**
     * Get an object of building by in a street
     * @param type $street_id
     * @param type $building_type_id
     * @return type 
     */
    public function get_street_building($street_id, $building_type_id) {
        $street_buildings = parent::$CI->street_building_model->get_where(array('street_id' => $street_id, 'building_type_id' => $building_type_id));
        if ($street_buildings['return_code'] == API_SUCCESS && !empty($street_buildings['data'])) {
            return $street_buildings['data'];
        }
        return FALSE;
    }

}