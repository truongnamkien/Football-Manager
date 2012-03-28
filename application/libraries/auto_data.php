<?php

class Auto_Data {

    private static $CI = NULL;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->config('npc', TRUE);
        $this->CI->load->config('player', TRUE);
        $this->CI->load->library(array('street_library', 'npc_library', 'name_library', 'player_library', 'team_library'));
        $this->CI->load->model(array('street_model', 'name_model'));
    }

    /**
     * Auto generate data of NPC
     */
    public function auto_create_npc() {
        // Tính số area tối đa
        $cols = Street_Model::MAP_WIDTH / Street_Model::AREA_WIDTH;
        $rows = Street_Model::MAP_HEIGHT / Street_Model::AREA_HEIGHT;
        $num_areas = $cols * $rows;

        $level_count = array();
        $streets_per_level = $this->CI->config->item('npc_max_per_level', 'npc');
        $max_level = $this->CI->config->item('npc_max_level', 'npc');

        $streets_per_area = round(($streets_per_level * $max_level / $num_areas), 0);
        for ($i = 0; $i < $num_areas; $i++) {
            for ($j = 0; $j < $streets_per_area; $j++) {
                do {
                    $level = rand(1, $max_level);
                } while (isset($level_count[$level]) && $level_count[$level] >= $streets_per_level);
                if (!isset($level_count[$level])) {
                    $level_count[$level] = 1;
                } else {
                    $level_count[$level]++;
                }

                // Tạo team
                $team = $this->CI->team_library->create();
                // Tạo cầu thủ cho team
                $this->auto_create_team_player($level, $team);

                // Tạo street (có trỏ tới team)
                $street = $this->CI->street_library->create(array('area' => $i, 'street_type' => Street_Model::STREET_TYPE_NPC, 'team_id' => $team['team_id']));

                // Tạo NPC
                $npc_data = array('level' => $level, 'street_id' => $street['street_id']);
                $ret = $this->CI->npc_library->create($npc_data);
            }
        }
    }

    /**
     * Auto generate data of a player
     * @param type $level
     * @param type $position
     * @param type $team_id
     * @return type 
     */
    public function auto_create_player($level, $position, $team_id) {
        $position_list = $this->CI->config->item('player_position_list', 'player');
        if (!in_array($position, $position_list)) {
            return FALSE;
        }

        $player_info = array();
        $player_info['position'] = $position;
        $player_info['team_id'] = $team_id;

        $position_rates = $this->CI->config->item('player_rate_for_postion', 'player');
        $position_rates = $position_rates[$position];
        $num_of_indexes = count($position_rates);

        // Chỉ số dành cho 
        $max_points = $level * $this->CI->config->item('player_max_point_per_level', 'player');
        $max = $this->CI->config->item('player_max_point_for_position', 'player') / $num_of_indexes;
        $min = $this->CI->config->item('player_min_point_for_position', 'player') / $num_of_indexes;

        foreach ($position_rates as $index => $rate) {
            $player_info[$index] = ($max_points * rand($min, $max)) / 100;
            $max_points -= $player_info[$index];
        }

        $index_list = $this->CI->config->item('player_index_list', 'player');
        $num_of_indexes = count($index_list) - $num_of_indexes;
        $min = 0;
        $max = 100 / $num_of_indexes;
        foreach ($index_list as $index) {
            if (!isset($player_info[$index])) {
                $player_info[$index] = ($max_points * rand($min, $max)) / 100;
            }
        }
        $player_info['last_name'] = $this->CI->name_library->get_random_by_category(Name_Model::CATEGORY_LAST_NAME);
        do {
            $player_info['first_name'] = $this->CI->name_library->get_random_by_category(Name_Model::CATEGORY_FIRST_NAME);
        } while ($player_info['first_name'] == $player_info['last_name']);
        do {
            $player_info['middle_name'] = $this->CI->name_library->get_random_by_category(Name_Model::CATEGORY_MIDDLE_NAME);
        } while ($player_info['middle_name'] == $player_info['first_name'] || $player_info['middle_name'] == $player_info['last_name']);

        $player = $this->CI->player_library->create($player_info);
    }

    /**
     * Auto generate data of players of a team
     * @param type $level
     * @param type $team 
     */
    public function auto_create_team_player($level, $team) {
        $position_amount = $this->CI->config->item('player_num_of_player', 'player');
        foreach ($position_amount as $position => $amount) {
            for ($i = 0; $i < $amount; $i++) {
                $this->auto_create_player($level, $position, $team['team_id']);
            }
        }
    }

}
