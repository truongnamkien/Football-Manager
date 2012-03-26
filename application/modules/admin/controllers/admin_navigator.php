<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Navigator extends MY_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->my_auth->login_required(TRUE);
    }

    public function _main_nav() {
        $data['main_navs'] = array(
            'system' => array('admin', 'building_type', 'npc', 'name'),
            'user' => array('user'),
        );

        $this->load->view('navigator/main_nav_view', $data);
    }

    public function _menu_current($menu_names) {
        $ci = &get_instance();
        $uri_segment = $ci->uri->segment(2);
        if (in_array($uri_segment, $menu_names) || ($uri_segment === FALSE && in_array('admin', $menu_names))) {
            return 'current';
        }
        return '';
    }

    public function _menu_render($params) {
        $menu = '';
        foreach ($params as $type) {
            $menu .= '<li><a href="' . site_url('admin/' . $type) . '"';
            $menu .= 'class="' . admin_menu_current(array($type)) . '">';
            $menu .= lang('manager_' . $type) . '</a></li>';
        }
        echo $menu;
    }

}
