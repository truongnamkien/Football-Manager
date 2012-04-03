<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Building_Type extends MY_Inner_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['type'] = 'building_type';
        $this->load->model(array('building_type_model'));
        $this->load->library(array('building_type_library'));
        $this->load->language('building');
        $this->set_title(lang('manager_title') . ' - ' . lang('manager_' . $this->data['type']));

    }

    private function _get_types() {
        return array(Building_Type_Model::BUILDING_TYPE_MANAGEMENT => Building_Type_Model::BUILDING_TYPE_MANAGEMENT,
            Building_Type_Model::BUILDING_TYPE_STADIUM_CONTAINER => Building_Type_Model::BUILDING_TYPE_STADIUM_CONTAINER,
            Building_Type_Model::BUILDING_TYPE_TRANSPORT => Building_Type_Model::BUILDING_TYPE_TRANSPORT,
            Building_Type_Model::BUILDING_TYPE_TRAINING => Building_Type_Model::BUILDING_TYPE_TRAINING,
            Building_Type_Model::BUILDING_TYPE_SUPPORT => Building_Type_Model::BUILDING_TYPE_SUPPORT,
            Building_Type_Model::BUILDING_TYPE_RECOVERY => Building_Type_Model::BUILDING_TYPE_RECOVERY,
            Building_Type_Model::BUILDING_TYPE_SERVICE => Building_Type_Model::BUILDING_TYPE_SERVICE,
            Building_Type_Model::BUILDING_TYPE_RESEARCH => Building_Type_Model::BUILDING_TYPE_RESEARCH,
            Building_Type_Model::BUILDING_TYPE_TRANSFER => Building_Type_Model::BUILDING_TYPE_TRANSFER);
    }

    protected function set_actions($id) {
        $actions = parent::set_actions($id);
        return $actions;
    }
    
    protected function set_validation_rules($action) {
        
        if ($action == 'create') {
            $rules = array(
                array('field' => 'name', 'label' => lang('building_type_name'), 'rules' => 'trim|strip_tags|max_length[40]|required|unique[building_type.name]'),
                array('field' => 'description', 'label' => lang('building_type_description'), 'rules' => 'trim|strip_tags|max_length[1000]'),
                array('field' => 'beginning_fee', 'label' => lang('building_type_fee'), 'rules' => 'numeric|required'),
                array('field' => 'fee_rate', 'label' => lang('building_type_fee_rate'), 'rules' => 'numeric|required'),
                array('field' => 'effect', 'label' => lang('building_type_effect'), 'rules' => 'numeric|required'),
                array('field' => 'effect_rate', 'label' => lang('building_type_effect_rate'), 'rules' => 'numeric|required'),
                array('field' => 'street_cell', 'label' => lang('building_type_street_cell'), 'rules' => 'numeric|required|unique[building_type.street_cell]'),
                array('field' => 'fee_rate', 'label' => lang('building_type_fee_rate'), 'rules' => 'numeric|required'),
                array('field' => 'type', 'label' => lang('building_type_type'), 'rules' => 'trim|strip_tags|max_length[40]|required'),
            );
        } else {
            $rules = array(
                array('field' => 'description', 'label' => lang('building_type_description'), 'rules' => 'trim|strip_tags|max_length[1000]'),
                array('field' => 'beginning_fee', 'label' => lang('building_type_fee'), 'rules' => 'numeric|required'),
                array('field' => 'fee_rate', 'label' => lang('building_type_fee_rate'), 'rules' => 'numeric|required'),
                array('field' => 'effect', 'label' => lang('building_type_effect'), 'rules' => 'numeric|required'),
                array('field' => 'effect_rate', 'label' => lang('building_type_effect_rate'), 'rules' => 'numeric|required'),
                array('field' => 'street_cell', 'label' => lang('building_type_street_cell'), 'rules' => 'numeric|required|unique[building_type.street_cell]'),
                array('field' => 'fee_rate', 'label' => lang('building_type_fee_rate'), 'rules' => 'numeric|required'),
                array('field' => 'type', 'label' => lang('building_type_type'), 'rules' => 'trim|strip_tags|max_length[40]|required'),
            );
        }      
    
        return $rules;
    }
    
    protected function prepare_object($id = FALSE) {
        $object = array(
            'name' => '',
            'description' => '',
            'beginning_fee' => '',
            'fee_rate' => '',
            'effect' => '',
            'effect_rate' => '',
            'street_cell' => '',
            'fee_rate' => '',
            'type' => '',
        );
        if (!empty($id)) {
            $object = $this->get_object($id);
        }

        $specific_input = array(
            'type' => array('input' => 'dropdown', 'options' => $this->_get_types()),
            'description' => array('input' => 'textarea')
        );
        unset($object[$this->data['type'] . '_id']);
        return $this->parse_object_field($object, $specific_input);
    }
}
