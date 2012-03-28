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

    /**
     * Remove a NPC with its data
     * @param type $id 
     */
    public function remove($id) {
        $npc = $this->get($id);
        parent::remove($id);

        // Xóa NPC phải xóa street của NPC luôn
        parent::$CI->street_library->remove($npc['street_id']);
    }

    /**
     * Remove all of NPC
     */
    public function remove_all() {
        $npc_list = $this->get_all();
        foreach ($npc_list as $npc) {
            $this->remove($npc['npc_id']);
        }
    }

    /**
     * Get NPC of the street
     * @param type $street_id
     * @return type 
     */
    public function get_npc_with_street($street_id) {
        $street = $this->user_model->get_where(array('street_id' => $street_id));
        if ($street_id['return_code'] == API_SUCCESS && !empty($street_id['data'])) {
            return $street_id['data'];
        }
        return FALSE;
    }

}
