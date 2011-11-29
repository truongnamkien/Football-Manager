<?php

class Auto_Data {

    private static $CI = NULL;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->config('npc', TRUE);
        $this->CI->load->library(array('street_library', 'npc_library'));
        $this->CI->load->model(array('street_model'));
    }

    public function auto_create_npc() {
        // Tính số area tối đa
        $cols = Street_Model::MAP_WIDTH / Street_Model::AREA_WIDTH;
        $rows = Street_Model::MAP_HEIGHT / Street_Model::AREA_HEIGHT;
        $num_areas = $cols * $rows;

        $level_count = array();
        $streets_per_area = $this->CI->config->item('npc_max_per_area', 'npc');
        $streets_per_level = $this->CI->config->item('npc_max_per_level', 'npc');
        $max_level = $this->CI->config->item('npc_max_level', 'npc');
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
                $street = $this->CI->street_library->create($i, Street_Model::STREET_TYPE_NPC);
                $npc_data = array('level' => $level, 'street_id' => $street['street_id']);
                $ret = $this->CI->npc_library->create($npc_data);
            }
        }
    }

    public function reset_npc_list() {
        $npc_list = $this->CI->npc_library->get_all();
        foreach ($npc_list as $npc) {
            $this->CI->street_library->remove($npc['street_id']);
            $this->CI->npc_library->remove($npc['npc_id']);
        }
    }

}
