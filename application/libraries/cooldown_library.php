<?php

require_once(APPPATH . 'libraries/abstract_library.php');

class Cooldown_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();

        $this->type = 'cooldown';
        $this->cache_key = 'cooldown.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('cooldown_model'));
    }

    /**
     * Get all the cooldown objects of a street
     * @param type $street_id
     * @return type 
     */
    public function get_by_street($street_id) {
        $cooldowns = parent::$CI->cooldown_model->get_where(array('street_id' => $street_id));
        if ($cooldowns['return_code'] == API_SUCCESS && !empty($cooldowns['data'])) {
            return $cooldowns['data'];
        }
        return FALSE;
    }

    /**
     * Get the cooldown objects of a type of a street
     * @param type $street_id
     * @param type $type
     * @return type 
     */
    public function get_by_type($street_id, $type) {
        $cooldowns = parent::$CI->cooldown_model->get_where(array('street_id' => $street_id, 'cooldown_type' => $type));
        if ($cooldowns['return_code'] == API_SUCCESS && !empty($cooldowns['data'])) {
            return $cooldowns['data'];
        }
        return FALSE;
    }

    /**
     * Get if the the street has a free cooldown slot
     * @return type 
     */
    public function get_available_building_cooldown() {
        $street_id = parent::$CI->my_auth->get_street_id();

        $cooldowns = $this->get_by_type($street_id, Cooldown_Model::COOLDOWN_TYPE_BUILDING);
        if (isset($cooldowns['cooldown_id'])) {
            $cooldowns = array($cooldowns);
        }
        
        if (empty($cooldowns) || count($cooldowns) < Cooldown_Model::MAX_COOLDOWN_SLOT_BUILDING) {
            $data = array(
                'cooldown_type' => Cooldown_Model::COOLDOWN_TYPE_BUILDING,
                'street_id' => $street_id,
                'end_time' => NULL,
            );
            $cd = parent::$CI->cooldown_model->create($data);
            if ($cd['return_code'] !== API_SUCCESS || empty($cd['data'])) {
                return FALSE;
            }
            return $cd['data'];
        } else {
            $current_time = now();
            foreach ($cooldowns as $cd) {
                if (empty($cd['end_time']) || $cd['end_time'] <= $current_time) {
                    return $cd;
                }
            }
        }
        return FALSE;
    }

}