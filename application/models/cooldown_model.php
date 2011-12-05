<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class Cooldown_Model extends Abstract_Model {
    const COOLDOWN_TYPE_BUILDING = 'building';
    const COOLDOWN_TYPE_RESEARCH = 'research';
    const COOLDOWN_TYPE_MATCHING = 'marching';

    const MAX_COOLDOWN_SLOT_BUILDING = 3;
    const MAX_COOLDOWN_SLOT_RESEARCHING = 1;

    public function __construct() {
        parent::__construct();
        $this->type = 'cooldown';
        $this->database = 'cooldown';
    }

    public function get_cooldown_by_street($street_id) {
        return $this->get_where(array('street_id' => $street_id));
    }

    protected function check_existed($data) {
        $cooldowns = $this->get_where(array('street_id' => $data['street_id'], 'cooldown_type' => $data['cooldown_type']));
        if ($cooldowns['return_code'] == API_SUCCESS && !empty($cooldowns['data'])) {
            if (($data['cooldown_type'] == self::COOLDOWN_TYPE_RESEARCH && count($cooldowns['data']) >= self::MAX_COOLDOWN_SLOT_BUILDING)
                    || ($data['cooldown_type'] == self::COOLDOWN_TYPE_BUILDING && count($cooldowns['data']) >= self::MAX_COOLDOWN_SLOT_BUILDING)) {
                return $this->_ret(API_SUCCESS, TRUE);
            }
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }

}
