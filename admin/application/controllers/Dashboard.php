<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('Dashboard_model');
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login/');
        } else {
            $data["extra_js"] = array("");
            $data['page_title'] = "Dashboard";
            $data['page'] = "dashboard";
            $data['main_content'] = 'dashboard/dashboard';
            $this->load->view('main_content', $data);
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */