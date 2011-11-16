<?php

class Street_Library {

    public static $instance = NULL;
    private $full_info = FALSE;
    private static $CI = null;

    function __construct() {
        self::$CI = & get_instance();
        self::$CI->load->model(array('street_model', 'street_building_model', 'building_type_model'));
    }

    public static function get($street_id = NULL) {
        self::current();

        $street_info = self::$CI->street_model->get_street($street_id);
        if ($street_info['return_code'] == API_SUCCESS && !empty($street_info['data'])) {
            $street_info = $street_info['data'];

            $buildings = self::$CI->street_building_model->get_all_building($street_id);
            $building_types = array();
            $building_info = array();
            if ($buildings['return_code'] == API_SUCCESS && !empty($buildings['data'])) {
                $buildings = $buildings['data'];
                foreach ($buildings as $building) {
                    $type = self::$CI->building_type_model->get_building_type($building['building_type_id']);
                    if ($type['return_code'] == API_SUCCESS && !empty($type['data'])) {
                        $building_types[$building['building_type_id']] = array_merge($building, $type['data']);
                        $building_info[$building['street_building_id']] = array_merge($building, $type['data']);
                    }
                }
            }
            $street_info['building_types'] = $building_types;
            $street_info['buildings'] = $building_info;
        } else {
            $street_info = array();
        }

        self::$instance->full_info = $street_info;
        return self::$instance;
    }

    public static function upgrade($building_type_id) {
        return self::change_level($building_type_id, TRUE);
    }

    public static function downgrade($building_type_id) {
        return self::change_level($building_type_id, FALSE);
    }

    private function change_level($building_type_id, $is_upgrade = TRUE) {
        $street_info = self::execute();
        $building = $street_info['building_types'][$building_type_id];
        $current_level = $building['level'];
        $updated_data = array();
        if ($is_upgrade) {
            $updated_data['level'] = $current_level + 1;
        } else {
            $updated_data['level'] = $current_level - 1;
        }
        return self::$CI->street_building_model->update_street_building($building, $updated_data);
    }

    public static function create($area, $street_type) {
        $street_info = self::$CI->street_model->create_street($area, array('street_type' => $street_type));
        if ($street_info['return_code'] == API_SUCCESS && !empty($street_info['data'])) {
            $street_info = $street_info['data'];
        }

        $building_types = self::$CI->building_type_model->get_all_building_type();
        if ($building_types['return_code'] == API_SUCCESS && !empty($building_types['data'])) {
            $building_types = $building_types['data'];
        }

        $buildings = self::$CI->street_building_model->create_street_building($street_info['street_id'], $building_types);
        if ($buildings['return_code'] == API_SUCCESS && !empty($buildings['data'])) {
            $buildings = $buildings['data'];
        }
        $street_info['buildings'] = $buildings;
        return $street_info;
    }

    /**
     * return the new instance.
     */
    public static function factory() {
        self::$instance = new self;
        return self::$instance;
    }

    /**
     * return the current.
     */
    public static function current() {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function execute() {
        self::current();

        $result = array();
        if (self::$instance->full_info != FALSE) {
            $result = self::$instance->full_info;
        }

        return $result;
    }

}