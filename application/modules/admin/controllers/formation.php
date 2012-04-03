<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Formation extends MY_Inner_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['type'] = 'formation';
        $this->load->library(array('formation_library'));
        $this->set_title(lang('manager_title') . ' - ' . lang('manager_' . $this->data['type']));
        $this->load->language('formation');
        $this->load->config('formation', TRUE);
    }

    protected function set_validation_rules($action) {
        $rules = array(
            array('field' => 'name', 'label' => lang('formation_name'), 'rules' => 'trim|strip_tags|max_length[20]|required|unique[formation.name]'),
        );
        return $rules;
    }

    protected function prepare_object($id = FALSE) {
        $areas = $this->config->item('formation_all_area', 'formation');

        $object = array('all_format' => $this->_get_all_format_display(), 'name' => '');
        foreach ($areas as $area) {
            $object[$area] = '';
            $specific_input[$area] = array('input' => 'dropdown', 'options' => $this->_get_format_for_area($area));
        }
        if (!empty($id)) {
            $object = array_merge($object, $this->get_object($id));
        }
        $specific_input['all_format'] = array('input' => 'label');
        unset($object[$this->data['type'] . '_id']);
        return $this->parse_object_field($object, $specific_input);
    }

    protected function create_update($id = FALSE) {
        $this->data['action'] = (empty($id) ? 'create' : 'update');
        if (!empty($id)) {
            $this->data['id'] = $id;
        }
        $this->data['form_data'] = $this->prepare_object($id);
        $validation_rules = $this->set_validation_rules($this->data['action']);
        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $params = $this->handle_post_inputs();

            $ret = $this->_formation_validate($params);
            if (is_string($ret)) {
                $this->data['error_msg'] = $ret;
            } else {
                $params = array_merge($params, $ret);
                $this->handle_create_update_object($params, $this->data['action'], $id);
            }
        }
        if (empty($id)) {
            $id = '';
        }
        $this->data['main_nav'] = $this->_main_nav($this->data['action'], $id);
        $this->load->view('create_update_view', $this->data);
    }

    protected function get_all_objects() {
        $formations = parent::get_all_objects();
        foreach ($formations as &$formation) {
            $formation = $this->_display_formation($formation);
        }
        return $formations;
    }

    public function show($id = FALSE) {
        $data['object'] = $this->_display_formation($this->get_object($id));

        $data['id'] = $id;
        $data['type'] = $this->data['type'];
        $data['main_nav'] = $this->_main_nav('show', $id);
        $this->load->view('show_view', $data);
    }

    /**
     * Get available format for area
     * @param type $area
     * @return type 
     */
    private function _get_format_for_area($area) {
        $area_format = $this->config->item('formation_format_for_area', 'formation');
        foreach ($area_format as $key => $value) {
            if (strpos($area, $key) !== FALSE) {
                return $value;
            }
        }
        return FALSE;
    }

    /**
     * Get the all of display photos of the formats
     * @return type 
     */
    private function _get_all_format_display() {
        $formats = $this->config->item('formation_all_format', 'formation');
        $data['format_photos'] = array();
        foreach ($formats as $key => $value) {
            $data['format_photos'][$value['number']][$key] = asset_url('images/formation/formation_' . $key . '.png');
        }
        return $this->load->view('formation/pagelet_all_formats', $data, TRUE);
    }

    /**
     * Validate as if the formation has enough player and correct format
     * @param type $data
     * @return int 
     */
    private function _formation_validate($data) {
        $all_area = $this->config->item('formation_all_area', 'formation');
        $formation = array();
        foreach ($all_area as $area) {
            if (isset($data[$area]) && !empty($data[$area])) {
                $formation[$area] = $data[$area];
            } else {
                $formation[$area] = 0;
            }
        }

        $formats = $this->config->item('formation_all_format', 'formation');
        $total_players = 0;
        foreach ($formation as $area => $format) {
            $available_format = $this->_get_format_for_area($area);
            $format = $available_format[$format];

            if (!isset($formats[$format])) {
                return lang('formation_error_invalid_format', '', lang('formation_' . $area));
            } else {
                $total_players += $formats[$format]['number'];
                if (strpos($area, 'wing') !== FALSE) {
                    $total_players += $formats[$format]['number'];
                }
            }
        }
        if ($total_players > 10) {
            return lang('formation_error_greater_than');
        } else if ($total_players < 10) {
            return lang('formation_error_less_than');
        }
        return $formation;
    }

    private function _display_formation($formation) {
        $result['formation_id'] = $formation['formation_id'];
        $result['name'] = $formation['name'];

        $areas = $this->config->item('formation_all_area', 'formation');
        foreach ($areas as $area) {
            $available_format = $this->_get_format_for_area($area);
            $data[$area] = $available_format[$formation[$area]];
        }
        $result['formation'] = $this->load->view('formation/pagelet_formation_view', $data, TRUE);
        if (isset($formation['actions']) && !empty($formation['actions'])) {
            $result['actions'] = $formation['actions'];
        }
        return $result;
    }

}