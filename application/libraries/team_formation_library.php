<?php

require_once(APPPATH . 'libraries/abstract_library.php');

class Team_Formation_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();

        $this->type = 'team_formation';
        $this->cache_key = 'team_formation.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
        );
        parent::$CI->load->model(array('team_formation_model'));
    }

    /**
     * Get the formation of the team
     * @param type $team_id
     * @return type 
     */
    public function get_formation_of_team($tream_id) {
        $formations = self::$CI->team_formation_model->get_where(array('team_id' => $team_id));
        if ($formations['return_code'] == API_SUCCESS && !empty($players['data'])) {
            $formations = $object['data'];
            if (isset($formations['team_formation_id'])) {
                $formations = array($formations);
            }
            return $formations;
        }
        return FALSE;
    }

}