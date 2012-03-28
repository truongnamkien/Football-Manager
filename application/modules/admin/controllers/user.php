<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Inner_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['type'] = 'user';
        $this->load->model(array('user_model'));
        $this->set_title(lang('manager_title') . ' - ' . lang('manager_' . $this->data['type']));
        $this->load->language('user');
    }

    public function create() {
        show_404();
    }

    private function _get_status() {
        return array(
            User_Model::USER_STATUS_INACTIVE => User_Model::USER_STATUS_INACTIVE,
            User_Model::USER_STATUS_ACTIVE => User_Model::USER_STATUS_ACTIVE,
            User_Model::USER_STATUS_RECOVERY_PASSWORD => User_Model::USER_STATUS_RECOVERY_PASSWORD
        );
    }

    protected function set_actions($id) {
        $actions = parent::set_actions($id);
        $path = 'admin/' . $this->data['type'] . '/';

        return $actions;
    }

    protected function set_validation_rules($action) {
        $rules = array();
        if ($action == 'update') {
            $rules = array(
                array('field' => 'display_name', 'label' => lang('user_display_name'), 'rules' => 'trim|strip_tags|max_length[40]|required'),
                array('field' => 'password_confirm', 'label' => lang('user_password_confirm'), 'rules' => 'matches[password]'),
                array('field' => 'user_status', 'label' => lang('user_user_status'), 'rules' => 'required'),
            );
        }
        return $rules;
    }

    protected function prepare_object($id = FALSE) {
        $object = array(
            'email' => '',
            'display_name' => '',
            'user_status' => '',
            'street_id' => '',
            'balance' => ''
        );
        if (!empty($id)) {
            $object = $this->get_object($id);
        }
        $object = array_merge($object, array('password' => '', 'password_confirm' => ''));

        $specific_input = array(
            'password' => array('input' => 'password'),
            'password_confirm' => array('input' => 'password'),
            'user_status' => array('input' => 'dropdown', 'options' => $this->_get_status())
        );
        if (!empty($id)) {
            $specific_input['email'] = array('input' => 'label');
        }
        unset($object[$this->data['type'] . '_id']);
        return $this->parse_object_field($object, $specific_input);
    }

    protected function get_object($id = FALSE) {
        $object = parent::get_object($id);
        unset($object['password']);
        return $object;
    }

    protected function get_all_objects() {
        $objects = parent::get_all_objects();
        foreach ($objects as &$obj) {
            unset($obj['password']);
        }
        return $objects;
    }

    protected function _main_nav($page = 'index', $id = '') {
        $nav_list = parent::_main_nav($page, $id);
        $type = $this->data['type'];
        if ($page == 'index') {
            unset($nav_list[$type . '_create']);
        }

        return $nav_list;
    }

}
