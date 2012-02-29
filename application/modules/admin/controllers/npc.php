<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class NPC extends MY_Inner_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['type'] = 'npc';
        $this->load->library(array('npc_library', 'auto_data'));
        $this->set_title(lang('manager_title') . ' - ' . lang('manager_' . $this->data['type']));
        $this->load->language('npc');
    }

    public function create() {
        show_404();
    }

    public function update() {
        show_404();
    }

    public function show() {
        show_404();
    }

    public function reset() {
        $this->npc_library->remove_all();
        $this->auto_data->auto_create_npc();
        redirect(site_url('admin/' . $this->data['type']));
    }

    protected function _main_nav($page = 'index', $id = '') {
        $nav_list = array();
        $type = $this->data['type'];
        $nav_list[$type . '_reset'] = site_url('admin/' . $type . '/reset');
        return $nav_list;
    }

    protected function set_actions($id) {
        $type = $this->data['type'];
        $path = 'admin/' . $type . '/';
        $actions['remove'] = anchor($path . 'remove/' . $id, lang($type . '_remove'), array('class' => 'remove', 'onclick' => 'return confirm(\'' . lang($this->data['type'] . '_remove_confirm') . '\');'));
        return $actions;
    }

    protected function set_validation_rules($action) {
        return array();
    }

    protected function prepare_object($id = FALSE) {
        return array();
    }

}

