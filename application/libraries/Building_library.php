<?php

class Building_Library {

    public static $instance = NULL;
    private $building_info = FALSE;
    private $street_id = FALSE;
    private $CI = NULL;
    private $cache_key = 'building.info:';

    function __construct() {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        self::$instance->CI = & get_instance();
        self::$instance->CI->load->model(array('street_building_model', 'building_type_model'));
        self::$instance->CI->load->driver('cache');
        self::$instance->street_id = self::$instance->CI->my_auth->get_street_id();
    }

    public static function get($street_building_id) {
        if (self::$instance->building_info != FALSE && isset(self::$instance->building_info[$street_building_id]) && !empty(self::$instance->building_info[$street_building_id])) {
            return self::$instance->building_info[$street_building_id];
        }
        $cache_data = self::$instance->CI->cache->get(self::$instance->cache_key . $street_building_id);
        if ($cache_data) {
            self::$instance->building_info[$street_building_id] = $cache_data;
            return self::$instance->building_info[$street_building_id];
        }

        $building = self::$instance->CI->street_building_model->get_street_building($street_building_id);
        if ($building['return_code'] == API_SUCCESS && !empty($building['data'])) {
            $building = $building['data'];
            $building_type = self::$instance->CI->building_type_model->get_building_type($building['building_type_id']);
            if ($building_type['return_code'] == API_SUCCESS && !empty($building_type['data'])) {
                $building = array_merge($building, $building_type['data']);
            }
            self::$instance->CI->cache->save(self::$instance->cache_key . $street_building_id, $building);
            self::$instance->building_info[$street_building_id] = $building;
            return self::$instance->building_info[$street_building_id];
        }
        return FALSE;
    }

    public static function get_all_buildings($street_id = FALSE) {
        if ($street_id == FALSE) {
            $street_id = self::$instance->street_id;
        }

        $building_types = self::$instance->CI->building_type_model->get_all_building_type();
        if ($building_types['return_code'] == API_SUCCESS && !empty($building_types['data'])) {
            $building_types = $building_types['data'];
        } else {
            return FALSE;
        }

        if (self::$instance->building_info != FALSE && count(self::$instance->building_info) == count($building_types)) {
            return self::$instance->building_info;
        }

        $types = self::$instance->CI->building_type_model->get_all_building_type();
        $building_types = array();
        if ($types['return_code'] == API_SUCCESS && !empty($types['data'])) {
            foreach ($types['data'] as $type) {
                $building_types[$type['building_type_id']] = $type;
            }
        }
        $buildings = self::$instance->CI->street_building_model->get_all_building($street_id);
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
            self::$instance->building_info[$street_building_id] = $building;
            self::$instance->CI->cache->delete(self::$instance->cache_key . $street_building_id);
            self::$instance->CI->cache->save(self::$instance->cache_key . $street_building_id, $building);
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
            return FALSE;
        }
        $level = $building['level'];
        if ($building['type'] != Building_Type_Model::BUILDING_TYPE_MANAGEMENT) {
            $manage_building = self::get_by_type(Building_Type_Model::BUILDING_TYPE_MANAGEMENT);
            $max_level = ($manage_building != FALSE ? $manage_building['level'] : Street_Building_Model::MAX_LEVEL);
        } else {
            $max_level = Street_Building_Model::MAX_LEVEL;
        }
        if ($level < $max_level) {
            $building = self::$instance->CI->street_building_model->update_street_building($street_building_id, array('level' => ($level + 1)));
            if ($building['return_code'] != API_SUCCESS || empty($building['data'])) {
                return FALSE;
            }
            $building = $building['data'];
            $building_type = self::$instance->CI->building_type_model->get_building_type($building['building_type_id']);
            if ($building_type['return_code'] == API_SUCCESS && !empty($building_type['data'])) {
                $building = array_merge($building, $building_type['data']);
            }
            self::$instance->CI->cache->delete(self::$instance->cache_key . $street_building_id);
            self::$instance->CI->cache->save(self::$instance->cache_key . $street_building_id, $building);
            self::$instance->building_info[$street_building_id] = $building;
            return self::$instance->building_info[$street_building_id];
        } else {
            return FALSE;
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