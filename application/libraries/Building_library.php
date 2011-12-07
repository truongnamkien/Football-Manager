<?php

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
    }

    public function get($street_building_id, $is_force = FALSE) {
        return parent::get($street_building_id, $is_force, array('after_get' => 'after_get_callback'));
    }

    public function get_all($street_id = FALSE, $is_force = FALSE) {
        if ($street_id == FALSE) {
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

        $buildings = parent::$CI->street_building_model->get_all(array('street_id' => $street_id));
        if ($buildings['return_code'] == API_SUCCESS && !empty($buildings['data'])) {
            $buildings = $buildings['data'];
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

    public function get_by_type($street_id, $type) {
        $buildings = $this->get_all($street_id);
        foreach ($buildings as $building) {
            if ($building['type'] == $type) {
                return $building;
            }
        }
        return FALSE;
    }

    public function upgrade($street_building_id) {
        $building = $this->get($street_building_id);
        $street_id = parent::$CI->my_auth->get_street_id();

        if ($building == FALSE) {
            return lang('building_upgrade_error');
        }
        $level = $building['level'];
        if ($building['type'] != Building_Type_Model::BUILDING_TYPE_MANAGEMENT) {
            $manage_building = $this->get_by_type($street_id, Building_Type_Model::BUILDING_TYPE_MANAGEMENT);
            $max_level = ($manage_building != FALSE ? $manage_building['level'] : Street_Building_Model::MAX_LEVEL);
        } else {
            $max_level = Street_Building_Model::MAX_LEVEL;
        }
        if ($level < $max_level) {
            $building = $this->update($street_building_id, array('level' => ($level + 1)));
            if ($building == NULL) {
                return lang('building_upgrade_error');
            }
            return $building;
        } else if (isset($manage_building)) {
            return lang_key('building_upgrade_max_level_2', '', array('name' => $manage_building['name']));
        } else {
            return lang('building_upgrade_max_level_1');
        }
    }

    public function create_building_for_street($street_id) {
        $building_types = parent::$CI->building_type_library->get_all();
        
        $buildings = array();
        foreach ($building_types as $type) {
            $type['street_id'] = $street_id;
            $buildings[] = $this->create($type);
        }
        return $buildings;
    }

    private function get_building_extra_info($building) {
        $building_type = parent::$CI->building_type_library->get($building['building_type_id']);
        $building = array_merge($building, $building_type);
        return $building;
    }

    protected function after_get_callback($building) {
        return $this->get_building_extra_info($building);
    }

}