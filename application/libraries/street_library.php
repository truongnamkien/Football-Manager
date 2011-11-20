<?php

class Street_Library {

    public static $instance = NULL;
    private $street_info = FALSE;
    private $CI = NULL;
    private $cache_key = 'street.info:';

    function __construct() {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        self::$instance->CI = & get_instance();
        self::$instance->CI->load->model(array('street_model', 'cooldown_model'));
        self::$instance->CI->load->driver('cache');
        self::$instance->CI->load->library('building_library');
    }

    public static function get($street_id) {
        if (self::$instance->street_info != FALSE && isset(self::$instance->street_info[$street_id]) && !empty(self::$instance->street_info[$street_id])) {
            return self::$instance->street_info[$street_id];
        }
        $cache_data = self::$instance->CI->cache->get(self::$instance->cache_key . $street_id);
        if ($cache_data) {
            self::$instance->street_info[$street_id] = $cache_data;
            return self::$instance->street_info[$street_id];
        }
        $street = self::$instance->CI->street_model->get_street($street_id);
        if ($street['return_code'] == API_SUCCESS && !empty($street['data'])) {
            $street = $street['data'];
            if ($street_id == self::$instance->CI->my_auth->get_street_id()) {
                $buildings = Building_Library::get_all_buildings($street_id);
                $street['buildings'] = $buildings;
            }

            // Lấy Cooldown list của Street
            $cooldowns = self::$instance->CI->cooldown_model->get_cooldown_by_street($street_id);
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
                $cooldown = self::$instance->CI->cooldown_model->create_cooldown($data);
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
                    $cooldown = self::$instance->CI->cooldown_model->create_cooldown($data);
                    $cooldown = $cooldown['data'];
                    $street_cooldowns['buildings'][$cooldown['cooldown_id']] = $cooldown;
                }
            }
            $street['cooldowns'] = $street_cooldowns;

            self::$instance->CI->cache->save(self::$instance->cache_key . $street_id, $street);
            self::$instance->street_info[$street_id] = $street;
            return self::$instance->street_info[$street_id];
        }
        return FALSE;
    }

    public static function upgrade($street_building_id) {
        $current_time = now();
        $available_cd = self::get_available_building_cooldown();
        $street = self::get(self::$instance->CI->my_auth->get_street_id());

        if ($available_cd == FALSE) {
            return FALSE;
        } else {
            $cooldown_time = self::get_cooldown_time($building_type_id);
            $building = Building_Library::upgrade($street_building_id);
            if ($building == FALSE) {
                return FALSE;
            }

            $cooldown = self::update_cooldown($available_cd, $current_time + $cooldown_time);
            $street['cooldowns']['buildings'][$available_cd] = $cooldown;
            $street['buildings'][$street_building_id] = $building;
            $street_id = $street['street_id'];
            self::$instance->CI->cache->delete(self::$instance->cache_key . $street_id);
            self::$instance->CI->cache->save(self::$instance->cache_key . $street_id, $street);
            self::$instance->street_info[$street_id] = $street;
            return self::$instance->street_info[$street_id];
        }
    }

    private static function get_available_building_cooldown() {
        $current_time = now();
        $street = self::get(self::$instance->CI->my_auth->get_street_id());
        foreach ($street['cooldowns']['buildings'] as $cd) {
            if ($cd['end_time'] == NULL || $cd['end_time'] <= $current_time) {
                return $cd['cooldown_id'];
            }
        }
        return FALSE;
    }

    private static function update_cooldown($cooldown_id, $time) {
        $cooldown = self::$instance->CI->cooldown_model->update_cooldown($cooldown_id, array('end_time' => $time));
        if ($cooldown['return_code'] == API_SUCCESS && !empty($cooldown['data'])) {
            return $cooldown['data'];
        }
        return FALSE;
    }

    public static function get_fee($street_building_id) {
        $building = Building_Library::get($street_building_id);
        $fee = $building['beginning_fee'];
        $rate = $building['fee_rate'];
        $level = $building['level'];
        for ($i = 1; $i < $level; $i++) {
            $fee = $fee * $rate;
        }
        return $fee;
    }

    public static function get_cooldown_time($building_type_id) {
        $building = Building_Library::get($street_building_id);
        $level = $building['level'];
        $fee = self::get_fee($building_type_id);
        $rate = intval($level / Street_Building_Model::LEVEL_PER_SECTION) + 1;
        return $fee / $rate;
    }

    public static function create($area, $street_type) {
        $street = self::$instance->CI->street_model->create_street($area, array('street_type' => $street_type));
        if ($street['return_code'] != API_SUCCESS || empty($street['data'])) {
            return FALSE;
        }
        $street = $street['data'];
        $buildings = Building_Library::create_building_for_street($street['street_id']);
        $street['buildings'] = $buildings;
        self::$instance->CI->cache->save(self::$instance->cache_key . $street['street_id'], $street);
        self::$instance->street_info[$street['street_id']] = $street;
        return $street;
    }

}