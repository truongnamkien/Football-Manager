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
        if ($id != FALSE) {
            $object = $this->get_object($id);
        }
        $object = array_merge($object, array('password' => '', 'password_confirm' => ''));

        $result = array();
        foreach ($object as $key => $val) {
            $label = form_label(lang($this->data['type'] . '_' . $key), $key);
            $value = array('name' => $key, 'value' => $val);

            if ($key == 'user_id' || ($key == 'email' && !empty($val))) {
                $value = array_merge($value, array('disabled' => 'disabled'));
            }

            if ($key == 'password' || $key == 'password_confirm') {
                $value = form_password($value);
            } else if ($key == 'user_status') {
                $roles = $this->_get_status();
                $value = form_dropdown($key, $roles, $val);
            } else {
                $value = form_input($value);
            }
            $result[] = array($label => $value);
        }
        return $result;
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
