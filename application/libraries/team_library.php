<?php

require_once(APPPATH . 'libraries/abstract_library.php');

class Team_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();

        $this->type = 'team';
        $this->cache_key = 'team.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('team_model'));
        parent::$CI->load->library(array('player_library', 'team_formation_library'));
        parent::$CI->load->language('team');
    }

    public function create($data = array()) {
        if (empty($data)) {
            $data['team_name'] = lang('team_team');
        }
        $team = parent::create($data);
        if (empty($data)) {
            return parent::update($team['team_id'], array('team_name' => $team['team_name'] . ' ' . $team['team_id']));
        }
        return $team;
    }

    public function remove($id) {
        parent::remove($id);

        // Xóa player
        $players = parent::$CI->player_library->get_by_team($id);
        foreach ($players as $player) {
            parent::$CI->player_library->remove($player['player_id']);
        }

        // Xóa formation của team
        $formations = parent::$CI->team_formation_library->get_formation_of_team($id);
        foreach ($formations as $formation) {
            parent::$CI->team_formation_library->remove($formation['team_formation_id']);
        }
    }

    /**
     * Get the team with the name
     * @param type $team_name
     * @return type 
     */
    public function get_team_by_name($team_name) {
        $team = $this->team_model->get_where(array('team_name' => $team_name));
        if ($team['return_code'] == API_SUCCESS && !empty($team['data'])) {
            return $team['data'];
        }
        return FALSE;
    }

}