<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Building_Type extends MY_Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->my_auth->login_required(TRUE);

        $this->load->language('building');
        $this->load->model(array('building_type_model'));
    }

    public function index() {
        $building_types = $this->building_type_model->get_all_building_type();
        $data = array();
        if ($building_types['return_code'] == API_SUCCESS && !empty($building_types['data'])) {
            $data['building_types'] = $building_types['data'];
        }

        $this->load->view('building_type/building_type_list_view', $data);
    }

    public function create() {
        $validate = $this->_validate_building_type();

        $collect = $this->_collect(array(
            'name',
            'description',
            'beginning_fee',
            'fee_rate',
            'effect',
            'effect_rate',
            'street_cell',
            'type'));
        if ($validate) {
            $building_type = $this->building_type_model->create_building_type($collect);

            if ($building_type['return_code'] === API_SUCCESS) {
                redirect(site_url('admin/building_type'));
            }
        }
        $collect['types'] = $this->_get_types();
        $this->load->view('building_type/building_type_create_view', $collect);
    }

    public function edit() {
        $building_type = $this->_get_building_type();
        $validate = $this->_validate_building_type();

        if ($validate) {
            $update_data = array();
            foreach ($building_type as $name => $val) {
                if ($new_val = $this->input->post($name)) {
                    if ($new_val != $val) {
                        $update_data[$name] = $new_val;
                        $building_type[$name] = $new_val;
                    }
                }
            }
            if (!empty($update_data)) {
                $this->building_type_model->update_building_type($building_type['building_type_id'], $update_data);
            }
            redirect(site_url('admin/building_type/show?building_type_id=' . $building_type['building_type_id']));
        }

        $building_type['types'] = $this->_get_types();
        $this->load->view('building_type/building_type_edit_view', $building_type);
    }

    public function show() {
        $building_type = $this->_get_building_type();

        $this->load->view('building_type/building_type_show_view', $building_type);
    }

    public function remove() {
        $building_type_id = $this->input->get_post('building_type_id');
        $this->building_type_model->delete_building_type($building_type_id);

        redirect(site_url('admin/building_type'));
    }

    private function _get_building_type() {
        if (FALSE == ($building_type_id = $this->input->get_post('building_type_id'))) {
            show_404();
        }

        $building_type = $this->building_type_model->get_building_type($building_type_id);
        if ($building_type['return_code'] != API_SUCCESS || empty($building_type['data'])) {
            show_404();
        } else {
            $building_type = $building_type['data'];
        }
        return $building_type;
    }

    private function _validate_building_type() {
        $this->form_validation->CI = & $this;
        $this->form_validation
                ->set_rules('name', 'lang:building_type_name', 'trim|strip_tags|max_length[40]|required|unique[building_type.name]')
                ->set_rules('description', 'lang:building_type_description', 'trim|strip_tags|max_length[1000]')
                ->set_rules('beginning_fee', 'lang:building_type_fee', 'numeric|required')
                ->set_rules('fee_rate', 'lang:building_type_fee_rate', 'numeric|required')
                ->set_rules('effect', 'lang:building_type_effect', 'numeric|required')
                ->set_rules('effect_rate', 'lang:building_type_effect_rate', 'numeric|required')
                ->set_rules('street_cell', 'lang:building_type_street_cell', 'numeric|required|unique[building_type.street_cell]');
        return $this->form_validation->run();
    }

    private function _get_types() {
        return array(Building_Type_Model::BUILDING_TYPE_MANAGEMENT,
            Building_Type_Model::BUILDING_TYPE_STADIUM_CONTAINER,
            Building_Type_Model::BUILDING_TYPE_TRANSPORT,
            Building_Type_Model::BUILDING_TYPE_TRAINING,
            Building_Type_Model::BUILDING_TYPE_SUPPORT,
            Building_Type_Model::BUILDING_TYPE_RECOVERY,
            Building_Type_Model::BUILDING_TYPE_SERVICE,
            Building_Type_Model::BUILDING_TYPE_RESEARCH,
            Building_Type_Model::BUILDING_TYPE_STORAGE,
            Building_Type_Model::BUILDING_TYPE_TRANSFER);
    }

}
