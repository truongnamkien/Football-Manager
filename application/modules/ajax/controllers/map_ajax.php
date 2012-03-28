<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Map_Ajax extends MY_Ajax {
    
    protected $current_street;
    
    public function __construct() {
        parent::__construct();

        $this->load->library(array('street_library', 'user_library'));
        $this->load->language('map');
        $this->load->model(array('street_model'));
        $this->my_auth->login_required();
    }

    public function upgrade()
    {
        $x_coor = $this->input->get_post('x_coor');
        $y_coor = $this->input->get_post('y_coor');
        
        $data['streets'] = $this->map_library->get_by_coor($x_coor, $y_coor);
        $data['x_coor'] = $x_coor;
        $data['y_coor'] = $y_coor;

        $html = $this->load->view('map/pagelet_map_view', $data, TRUE);
//        $this->response->run("show_alert(' ".$x_coor . " " . $y_coor." ')");
        $this->response->html('#map_body', $html);
       
        $this->response->send();
    }

    public function show_map($data = FALSE)
    {
        $streets = $data['streets'];
        $x_coor = $data['x_coor'];
        $y_coor = $data['y_coor'];
        if (empty($streets)) {
            echo 'street is FALSE';
        } else {
            for ($i = 0; $i < Street_model::AREA_HEIGHT; $i++)
                    for ($j = 0; $j < Street_model::AREA_WIDTH; $j++)
                        if (isset($streets[$j][$i]))
                            $this->response->html('#map_position_'.$i.'_'.$j, $streets[$j][$i]['street_id']);
                        else{
                            $x = $x_coor + $j;
                            $y = $y_coor + $i;
                            $this->response->html('#map_position_'.$i.'_'.$j, lang('map_empty_cell').  " = " . $x . " " . $y);
                        }
        }
        $this->response->html('#map_ix1', "value=".$x_coor);
        $this->response->html('#map_ix2', "value=".$y_coor);
    }
}
