<?php

class Street_Library {

    public static $instance = NULL;
    private $full_info = FALSE;
    private static $CI = null;

    function __construct() {
        self::$CI = & get_instance();
        self::$CI->load->model(array('street_model', 'street_building_model', 'building_type_model', 'cooldown_model'));
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

            // Lấy Cooldown list của Street
            $cooldowns = self::$CI->cooldown_model->get_cooldown_by_street($street_id);
            if ($cooldowns['return_code'] == API_SUCCESS && !empty($cooldowns['data'])) {
                $cooldowns = $cooldowns['data'];
            } else {
                $cooldowns = array();
            }

            $street_cooldowns['buildings'] = array();
            $street_cooldowns['research'] = FALSE;
            foreach ($cooldowns as $cd) {
                if ($cd['cooldown_type'] == Cooldown_Model::COOLDOWN_TYPE_BUILDING) {
                    $street_cooldowns['buildings'][$cd['cooldown_id']] = $cd;
                } else if ($cd['cooldown_type'] == Cooldown_Model::COOLDOWN_TYPE_RESEARCH) {
                    $street_cooldowns['research'] = $cd;
                }
            }

            // Nếu Cooldown list không đủ theo quy ước thì bổ sung record
            if ($street_cooldowns['research'] == FALSE) {
                $data = array(
                    'cooldown_type' => Cooldown_Model::COOLDOWN_TYPE_RESEARCH,
                    'street_id' => $street_id,
                    'end_time' => NULL,
                );
                $cooldown = self::$CI->cooldown_model->create_cooldown($data);
                $street_cooldowns['research'] = $cooldown['data'];
            }
            if (count($street_cooldowns['buildings']) < Cooldown_Model::MAX_COOLDOWN_SLOT_BUILDING) {
                $num = Cooldown_Model::MAX_COOLDOWN_SLOT_BUILDING - count($street_cooldowns['buildings']);
                for ($i = 0; $i < $num; $i++) {
                    $data = array(
                        'cooldown_type' => Cooldown_Model::COOLDOWN_TYPE_BUILDING,
                        'street_id' => $street_id,
                        'end_time' => NULL,
                    );
                    $cooldown = self::$CI->cooldown_model->create_cooldown($data);
                    $cooldown = $cooldown['data'];
                    $street_cooldowns['buildings'][$cooldown['cooldown_id']] = $cooldown;
                }
            }
            $street_info['cooldowns'] = $street_cooldowns;
        } else {
            $street_info = array();
        }

        self::$instance->full_info = $street_info;
        return self::$instance;
    }

    public static function upgrade($building_type_id) {
        $street_info = self::execute();
        $current_time = now();
        $available_cd = self::get_available_building_cooldown();

        if ($available_cd == FALSE) {
            return array('return_code' => API_FAILED);
        } else {
            $cooldown_time = self::get_cooldown_time($building_type_id);
            $building = $street_info['building_types'][$building_type_id];
            $current_level = $building['level'];
            $updated_data['level'] = $current_level + 1;

            $ret = self::$CI->street_building_model->update_street_building($building, $updated_data);
            if ($ret['return_code'] == API_SUCCESS && !empty($ret['data'])) {
                $cooldown = self::update_cooldown($available_cd, $current_time + $cooldown_time);
                $street_info['building_types'][$building_type_id] = $ret['data'];
                $street_info['buildings'][$building['street_building_id']] = $ret['data'];

                $street_info['cooldowns']['buildings'][$available_cd] = $cooldown['data'];
                self::$instance->full_info = $street_info;
                return $ret;
            } else {
                return array('return_code' => API_FAILED);
            }
        }
    }

    private static function get_available_building_cooldown() {
        $street_info = self::execute();
        $current_time = now();

        foreach ($street_info['cooldowns']['buildings'] as $cd) {
            if ($cd['end_time'] == NULL || $cd['end_time'] <= $current_time) {
                return $cd['cooldown_id'];
            }
        }
        return FALSE;
    }

    private static function update_cooldown($cooldown_id, $time) {
        return self::$CI->cooldown_model->update_cooldown($cooldown_id, array('end_time' => $time));
    }

    public static function get_fee($building_type_id) {
        $street_info = self::execute();
        $building = $street_info['building_types'][$building_type_id];
        $fee = $building['beginning_fee'];
        $rate = $building['fee_rate'];
        $level = $building['level'];
        for ($i = 0; $i < $level; $i++) {
            $fee = $fee * $rate;
        }
        return $fee;
    }

    public static function get_cooldown_time($building_type_id) {
        $street_info = self::execute();
        $building = $street_info['building_types'][$building_type_id];
        $level = $building['level'];
        $fee = self::get_fee($building_type_id);
        $rate = intval($level / Street_Building_Model::LEVEL_PER_SECTION) + 1;

        return $fee / $rate;
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