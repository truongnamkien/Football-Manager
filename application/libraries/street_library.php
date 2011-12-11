<?php

class Street_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();

        $this->type = 'street';
        $this->cache_key = 'street.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('street_model', 'cooldown_model'));
        parent::$CI->load->library(array('building_library', 'map_library'));
    }

    public function get($street_id, $is_force = FALSE) {
        return parent::get($street_id, $is_force, array('after_get' => 'after_get_callback'));
    }

    public function create($data) {
        $street = parent::$CI->map_library->create_street($data['area'], array('street_type' => $data['street_type']));
        if ($data['street_type'] == Street_Model::STREET_TYPE_PLAYER) {
            $buildings = parent::$CI->building_library->create_building_for_street($street['street_id']);
            $street['buildings'] = $buildings;
        }
        return $this->get($street['street_id'], TRUE);
    }

    public function get_all() {
        return FALSE;
    }

    public function count_all() {
        return FALSE;
    }

    public function remove($street_id) {
        $street = $this->get($street_id, TRUE);

        // Remove buildings
        if (isset($street['buildings'])) {
            foreach ($street['buildings'] as $building) {
                parent::$CI->building_library->remove($building['street_building_id']);
            }
        }

        // Remove cooldowns
        if (isset($street['cooldowns'])) {
            parent::$CI->cooldown_model->delete($street['cooldowns']['research']['cooldown_id']);
            foreach ($street['cooldowns']['buildings'] as $cd) {
                parent::$CI->cooldown_model->delete($cd['cooldown_id']);
            }
        }
        parent::remove($street_id);
    }

    public function upgrade($street_building_id) {
        $current_time = now();
        $available_cd = $this->get_available_building_cooldown();
        $street = $this->get(parent::$CI->my_auth->get_street_id());

        if ($available_cd == FALSE) {
            return lang('building_upgrade_non_cooldown');
        } else {
            $cooldown_time = $this->get_cooldown_time($street_building_id);
            $building = parent::$CI->building_library->upgrade($street_building_id);
            if ($building == FALSE || is_string($building)) {
                return $building;
            }

            $cooldown = $this->update_cooldown($available_cd, $current_time + $cooldown_time);
            $street['cooldowns']['buildings'][$available_cd] = $cooldown;
            $street['buildings'][$street_building_id] = $building;
            return $this->get($street['street_id'], TRUE);
        }
    }

    private function get_available_building_cooldown() {
        $current_time = now();
        $street = $this->get(parent::$CI->my_auth->get_street_id());
        foreach ($street['cooldowns']['buildings'] as $cd) {
            if ($cd['end_time'] == NULL || $cd['end_time'] <= $current_time) {
                return $cd['cooldown_id'];
            }
        }
        return FALSE;
    }

    private function update_cooldown($cooldown_id, $time) {
        $cooldown = parent::$CI->cooldown_model->update($cooldown_id, array('end_time' => $time));
        if ($cooldown['return_code'] == API_SUCCESS && !empty($cooldown['data'])) {
            return $cooldown['data'];
        }
        return FALSE;
    }

    public function get_fee($street_building_id) {
        $building = parent::$CI->building_library->get($street_building_id);
        $fee = $building['beginning_fee'];
        $rate = $building['fee_rate'];
        $level = $building['level'];
        for ($i = 1; $i < $level; $i++) {
            $fee = $fee * $rate;
        }
        return $fee;
    }

    public function get_cooldown_time($street_building_id) {
        $building = parent::$CI->building_library->get($street_building_id);
        $level = $building['level'];
        $fee = $this->get_fee($street_building_id);
        $rate = intval($level / Street_Building_Model::LEVEL_PER_SECTION) + 1;
        return intval($fee / $rate);
    }

    private function get_my_street_info($street) {
        $street_id = $street['street_id'];
        if ($street_id == parent::$CI->my_auth->get_street_id()) {
            $buildings = parent::$CI->building_library->get_all($street_id);
            $street['buildings'] = $buildings;

            // Lấy Cooldown list của Street
            $cooldowns = parent::$CI->cooldown_model->get_cooldown_by_street($street_id);
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
                $cooldown = parent::$CI->cooldown_model->create($data);
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
                    $cooldown = parent::$CI->cooldown_model->create($data);
                    $cooldown = $cooldown['data'];
                    $street_cooldowns['buildings'][$cooldown['cooldown_id']] = $cooldown;
                }
            }
            $street['cooldowns'] = $street_cooldowns;
        }
        return $street;
    }
    
    protected function after_get_callback($street) {
        return $this->get_my_street_info($street);
    }

}