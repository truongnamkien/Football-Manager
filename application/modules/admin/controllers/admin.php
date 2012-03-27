<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Inner_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['type'] = 'admin';
        $this->load->model(array('admin_model'));
        $this->load->library(array('admin_library'));
        $this->set_title(lang('manager_title') . ' - ' . lang('manager_' . $this->data['type']));
    }
    
    private function _get_roles() {
        return array(
            Admin_Model::ADMIN_ROLE_ADMIN => Admin_Model::ADMIN_ROLE_ADMIN,
            Admin_Model::ADMIN_ROLE_MODERATOR => Admin_Model::ADMIN_ROLE_MODERATOR
        );
    }

    protected function set_actions($id) {
        $actions = parent::set_actions($id);
        return $actions;
    }

    protected function set_validation_rules($action) {
        if ($action == 'create') {
            $rules = array(
                array('field' => 'display_name', 'label' => lang('admin_display_name'), 'rules' => 'trim|strip_tags|max_length[40]|required'),
                array('field' => 'username', 'label' => 'lang:admin_username', 'rules' => 'trim|strip_tags|required|max_length[80]|unique[admin.username]'),
                array('field' => 'password', 'label' => lang('admin_password'), 'rules' => 'required|min_length[6]|max_length[32]'),
                array('field' => 'password_confirm', 'label' => lang('admin_password_confirm'), 'rules' => 'required|matches[password]'),
                array('field' => 'role', 'label' => lang('admin_role'), 'rules' => 'required'),
            );
        } else {
            $rules = array(
                array('field' => 'display_name', 'label' => lang('admin_display_name'), 'rules' => 'trim|strip_tags|max_length[40]|required'),
                array('field' => 'password_confirm', 'label' => lang('admin_password_confirm'), 'rules' => 'matches[password]'),
                array('field' => 'role', 'label' => lang('admin_role'), 'rules' => 'required'),
            );
        }
        return $rules;
    }

    protected function prepare_object($id = FALSE) {
        $object = array(
            'username' => '',
            'display_name' => '',
            'role' => ''
        );
        if ($id != FALSE) {
            $object = $this->get_object($id);
        }
        $object = array_merge($object, array('password' => '', 'password_confirm' => ''));
        
        $specific_input = array(
            'password' => array('input' => 'password'),
            'password_confirm' => array('input' => 'password'),
            'role' => array('input' => 'dropdown', 'options' => $this->_get_roles())
        );
        if ($id !== FALSE) {
            $specific_input['username'] = array('input' => 'label');
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
}
