<?php

class Player_Library extends Abstract_Library {
    const GOAL_KEEPER = 0;
    const DEFENDER_CENTER = 1;
    const DEFENDER_WING = 2;
    const MIDFIELDER_CENTER = 3;
    const MIDFIELDER_WING = 4;
    const FORWARDER_CENTER = 5;
    const FORWARDER_WING = 6;

    function __construct() {
        parent::__construct();

        $this->type = 'player';
        $this->cache_key = 'player.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('player_model'));
    }

    public function get($id, $is_force = FALSE) {
        return parent::get($id, $is_force, array('after_get' => 'after_get_callback'));
    }

    protected function after_get_callback($player) {
        return $this->get_player_strength($player);
    }

    private function get_player_strength($player) {
        $indexes = array('physical', 'flexibility', 'goalkeeper', 'defence', 'shooting', 'passing', 'thwart', 'speed');
        $total = 0;
        foreach ($indexes as $index) {
            $total += $player[$index];
        }
        switch ($player['position']) {
            case GOAL_KEEPER:
                $total += $player['goalkeeper'] * 3;
                break;
            case DEFENDER_CENTER:
                $total += $player['defence'] * 2 + $player['thwart'];
                break;
            case DEFENDER_WING:
                $total += $player['defence'] + $player['speed'] * 2;
                break;
            case MIDFIELDER_CENTER:
                $total += $player['thwart'] + $player['passing'] * 2;
                break;
            case MIDFIELDER_WING:
                $total += $player['passing'] + $player['speed'] * 2;
                break;
            case FORWARDER_CENTER:
                $total += $player['passing'] + $player['shooting'] * 2;
                break;
            case FORWARDER_WING:
                $total += $player['shooting'] + $player['speed'] * 2;
                break;
        }
        $player['strength'] = $total / 10;
    }

}
