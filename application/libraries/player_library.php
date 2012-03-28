<?php

require_once(APPPATH . 'libraries/abstract_library.php');

class Player_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();

        $this->type = 'player';
        $this->cache_key = 'player.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->config('player', TRUE);
        parent::$CI->load->model(array('player_model'));
    }

    /**
     * Get player by id
     * @param type $id
     * @param type $is_force
     * @return type 
     */
    public function get($id, $is_force = FALSE) {
        return parent::get($id, $is_force, array('after_get' => 'after_get_callback'));
    }

    /**
     * Get player by team id
     * @param type $team_id
     * @return type 
     */
    public function get_by_team($team_id) {
        $players = self::$CI->player_model->get_where(array('team_id' => $team_id));
        if ($players['return_code'] == API_SUCCESS && !empty($players['data'])) {
            $players = $players['data'];
            if (isset($players['player_id'])) {
                $players = array($players);
            }

            foreach ($players as &$player) {
                $player = $this->after_get_callback($player);
            }
            return $players;
        }
        return FALSE;
    }

    /**
     * Call back after get player
     * @param type $player
     * @return type 
     */
    protected function after_get_callback($player) {
        return $this->get_player_strength($player);
    }

    /**
     * Get the strength of player
     * @param array $player
     */
    private function get_player_strength($player) {
        $indexes = parent::$CI->config->item('player_index_list', 'player');
        $total = 0;
        foreach ($indexes as $index) {
            $total += $player[$index];
        }

        $position_rates = parent::$CI->config->item('player_rate_for_postion', 'player');

        if (isset($player['position']) && isset($position_rates[$player['position']])) {
            $rates = $position_rates[$player['position']];
            foreach ($rates as $index => $rate) {
                $total += $player[$index] * $rate;
            }
        }
        $player['strength'] = $total / 10;
        return $player;
    }

}
