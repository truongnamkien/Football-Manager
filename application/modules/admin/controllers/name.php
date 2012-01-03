<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Name extends MY_Inner_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['type'] = 'name';
        $this->load->library(array('name_library'));
        $this->set_title(lang('manager_title') . ' - ' . lang('manager_' . $this->data['type']));
        $this->load->language('name');
    }

    private function _get_types() {
        return array(Name_Model::CATEGORY_LAST_NAME => Name_Model::CATEGORY_LAST_NAME,
            Name_Model::CATEGORY_MIDDLE_NAME => Name_Model::CATEGORY_MIDDLE_NAME,
            Name_Model::CATEGORY_FIRST_NAME => Name_Model::CATEGORY_FIRST_NAME
        );
    }

    protected function set_validation_rules($action) {
        $rules = array(
            array('field' => 'name', 'label' => lang('name_name'), 'rules' => 'trim|strip_tags|max_length[30]|required'),
            array('field' => 'category', 'label' => lang('name_category'), 'rules' => 'required'),
        );
        return $rules;
    }

    protected function prepare_object($id = FALSE) {
        $object = array(
            'name' => '',
            'category' => '',
        );
        if ($id != FALSE) {
            $object = $this->get_object($id);
        }

        $result = array();
        foreach ($object as $key => $val) {
            $label = form_label(lang($this->data['type'] . '_' . $key), $key);
            $value = array('name' => $key, 'value' => $val);

            if ($key == 'category') {
                $roles = $this->_get_types();
                $value = form_dropdown($key, $roles, $val);
            } else {
                $value = form_input($value);
            }
            $result[] = array($label => $value);
        }
        return $result;
    }

    protected function _main_nav($page = 'index', $id = '') {
        $nav_list = parent::_main_nav($page, $id);
        if ($page == 'index') {
            $nav_list['name_import'] = site_url('admin/name/import');
        }

        return $nav_list;
    }

    public function import() {
        $this->data['action'] = 'import';
        $this->data['form_data'] = array();

        $key = 'name_list';
        $label = form_label(lang($key), $key);
        $value = array('name' => $key, 'value' => '');
        $value = form_textarea($value);
        $this->data['form_data'][] = array($label => $value);

        $key = 'category';
        $label = form_label(lang('name_' . $key), $key);
        $value = array('name' => $key, 'value' => '');
        $roles = $this->_get_types();
        $value = form_dropdown($key, $roles, '');
        $this->data['form_data'][] = array($label => $value);

        $rules = array(
            array('field' => 'name_list', 'label' => lang('name_list'), 'rules' => 'trim|strip_tags|required'),
            array('field' => 'category', 'label' => lang('name_category'), 'rules' => 'required'),
        );
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $this->data['main_nav'] = $this->_main_nav('import');
            $this->load->view('create_update_view', $this->data);
        } else {
            $params = $this->handle_post_inputs();
            $this->add_name_to_db($params['name_list'], $params['category']);
            redirect(site_url('admin/' . $this->data['type']));
        }
    }

    private function add_name_to_db($name, $category) {
        if (is_string($name)) {
            $name = preg_split("/[,. ]/", $name);
        }
        if (!empty($name) && count($name) == 1) {
            $sub_name = current($name);
            if (!empty($sub_name)) {
                $this->name_library->create(array('category' => $category, 'name' => $sub_name));
            }
        } else if (count($name) > 1) {
            foreach ($name as $sub_name) {
                $this->add_name_to_db($sub_name, $category);
            }
        }
    }

}