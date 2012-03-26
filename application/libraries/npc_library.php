<?php
require_once(APPPATH . 'libraries/abstract_library.php');

class NPC_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();

        $this->type = 'npc';
        $this->cache_key = 'npc.info.';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
        );
        parent::$CI->load->model(array('npc_model'));
        parent::$CI->load->library(array('street_library'));
    }

    public function get($id, $is_force = FALSE) {
        return parent::get($id, $is_force, array());
    }

    public function remove($id) {
        $npc = $this->get($id);
        parent::remove($id);

        // Xóa NPC phải xóa street của NPC luôn
        parent::$CI->street_library->remove($npc['street_id']);
    }

    public function remove_all() {
        $npc_list = $this->get_all();
        foreach ($npc_list as $npc) {
            $this->remove($npc['npc_id']);
        }
    }

}
