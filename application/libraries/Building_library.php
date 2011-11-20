<?php

class Building_Library {

    private static $building_info = FALSE;
    private static $CI = NULL;
    private static $cache_key = 'building.info:';

    function __construct() {
        self::$CI = & get_instance();
        self::$CI->load->model(array('street_building_model', 'building_type_model'));
        self::$CI->load->driver('cache');
    }

    public static function get($street_building_id) {
        if (self::$building_info != FALSE && isset(self::$building_info[$street_building_id]) && !empty(self::$building_info[$street_building_id])) {
            return self::$building_info[$street_building_id];
        }
        $cache_data = self::$CI->cache->get(self::$cache_key . $street_building_id);
        if ($cache_data) {
            self::$building_info[$street_building_id] = $cache_data;
            return self::$building_info[$street_building_id];
        }

        $building = self::$CI->street_building_model->get_street_building($street_building_id);
        if ($building['return_code'] == API_SUCCESS && !empty($building['data'])) {
            $building = $building['data'];
            $building_type = self::$CI->building_type_model->get_building_type($building['building_type_id']);
            if ($building_type['return_code'] == API_SUCCESS && !empty($building_type['data'])) {
                $building = array_merge($building, $building_type['data']);
            }
            self::$CI->cache->save(self::$cache_key . $street_building_id, $building);
            self::$building_info[$street_building_id] = $building;
            return self::$building_info[$street_building_id];
        }
        return FALSE;
    }

    public static function get_all_buildings($street_id = FALSE) {
        if ($street_id == FALSE) {
            $street_id = self::$CI->my_auth->get_street_id();
        }

        $building_types = self::$CI->building_type_model->get_all_building_type();
        if ($building_types['return_code'] == API_SUCCESS && !empty($building_types['data'])) {
            $building_types = $building_types['data'];
        } else {
            return FALSE;
        }

        if (self::$building_info != FALSE && count(self::$building_info) == count($building_types)) {
            return self::$building_info;
        }

        $types = self::$CI->building_type_model->get_all_building_type();
        $building_types = array();
        if ($types['return_code'] == API_SUCCESS && !empty($types['data'])) {
            foreach ($types['data'] as $type) {
                $building_types[$type['building_type_id']] = $type;
            }
        }
        $buildings = self::$CI->street_building_model->get_all_building($street_id);
        if ($buildings['return_code'] == API_SUCCESS && !empty($buildings['data'])) {
            $buildings = $buildings['data'];
        } else {
            $buildings = array();
        }
        $result = array();
        foreach ($buildings as $building) {
            $building = array_merge($building, $building_types[$building['building_type_id']]);
            $street_building_id = $building['street_building_id'];
            $result[$street_building_id] = $building;
            self::$building_info[$street_building_id] = $building;
            self::$CI->cache->delete(self::$cache_key . $street_building_id);
            self::$CI->cache->save(self::$cache_key . $street_building_id, $building);
        }
        return $result;
    }

    public static function get_by_type($type) {
        $buildings = self::get_all_buildings();
        foreach ($buildings as $building) {
            if ($building['type'] == $type) {
                return $building;
            }
        }
        return FALSE;
    }

    public static function upgrade($street_building_id) {
        $building = self::get($street_building_id);
        if ($building == FALSE) {
            return lang('building_upgrade_error');
        }
        $level = $building['level'];
        if ($building['type'] != Building_Type_Model::BUILDING_TYPE_MANAGEMENT) {
            $manage_building = self::get_by_type(Building_Type_Model::BUILDING_TYPE_MANAGEMENT);
            $max_level = ($manage_building != FALSE ? $manage_building['level'] : Street_Building_Model::MAX_LEVEL);
        } else {
            $max_level = Street_Building_Model::MAX_LEVEL;
        }
        if ($level < $max_level) {
            $building = self::$CI->street_building_model->update_street_building($street_building_id, array('level' => ($level + 1)));
            if ($building['return_code'] != API_SUCCESS || empty($building['data'])) {
                return lang('building_upgrade_error');
            }
            $building = $building['data'];
            $building_type = self::$CI->building_type_model->get_building_type($building['building_type_id']);
            if ($building_type['return_code'] == API_SUCCESS && !empty($building_type['data'])) {
                $building = array_merge($building, $building_type['data']);
            }
            self::$CI->cache->delete(self::$cache_key . $street_building_id);
            self::$CI->cache->save(self::$cache_key . $street_building_id, $building);
            self::$building_info[$street_building_id] = $building;
            return self::$building_info[$street_building_id];
        } else if (isset($manage_building)) {
            return lang_key('building_upgrade_max_level_2', '', array('name' => $manage_building['name']));
        } else {
            return lang('building_upgrade_max_level_1');
        }
    }

    public static function create_building_for_street($street_id) {
        $building_types = self::$CI->building_type_model->get_all_building_type();
        if ($building_types['return_code'] !== API_SUCCESS || empty($building_types['data'])) {
            return FALSE;
        }
        $building_types = $building_types['data'];
        $buildings = self::$CI->street_building_model->create_street_building($street_info['street_id'], $building_types);
        if ($buildings['return_code'] == API_SUCCESS && !empty($buildings['data'])) {
            $buildings = $buildings['data'];
        } else {
            $buildings = array();
        }
        return $buildings;
    }

}