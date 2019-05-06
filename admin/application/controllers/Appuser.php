<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Appuser extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('appuser_model');
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login/');
        } else {
            $data["extra_js"] = array('appuser');
            $data['page_title'] = "Manage App Users";
            $data['page'] = "users";
            $data['main_content'] = 'appusers/manage_users';
            $this->load->view('main_content', $data);
        }
    }

    function manage() {
        $this->datatables->select('id,username,email,phone,activated');
        
        if($this->input->post('status') && $this->input->post('status')>0)
        {
                $this->datatables->where('activated',$this->input->post('status'));
        }
        $this->datatables->from(TBL_USERS)
            ->add_column('question', $this->action_paymentdtl('$1'), 'id')
            ->add_column('action', $this->action_row_patient('$1'), 'id');
             $this->datatables->edit_column('activated', '$1', 'status(activated)');
	$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    
    function viewuser($id) 
    {
        $data_found = 0;
        if ($id > 0) {
                $user = $this->appuser_model->get_user($id);
            if (is_object($user) && count($user) > 0) {
                $data["user_info"] = $user;
                $data_found = 1;
            }
        }
        if ($data_found == 0) {
            redirect('appuser/');
        }
        $data["extra_js"] = array('appuser');
        $data['page_title'] = "View User";
        $data['page'] = "users";
        $data['mode'] = "View";
        $data['main_content'] = 'appusers/view_user';
        $this->load->view('main_content', $data);
    } 
    
    
    function remove() 
    {
        $user_id = ($this->input->post('id') && $this->input->post('id') > 0) ? $this->input->post('id') : 0;
		//var_dump($fcmtoken_id);die;
		if ($this->appuser_model->remove($user_id))
		{
			$this->session->set_flashdata('success_msg', 'Details updated successfully.');
			$response = array("status" => "ok", "heading" => "Deleted successfully...", "message" => "Delete successfully.");
		}
		else{
			$response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
		}
        echo json_encode($response);
        die;
    }
    
    function action_row_patient($id) {
         $view_url = base_url().'appuser/viewuser/';
        $action = <<<EOF
            <div class="tooltip-top">
                <a data-original-title="View User" data-placement="top" data-toggle="tooltip" href="{$view_url}{$id}" class="btn btn-info btn-xs btn-equal btn-mini"><i class="fa fa-eye"></i></a>
	        <a data-original-title="Remove User" data-placement="top" data-toggle="tooltip" href="javascript:" class="btn btn-danger btn-xs btn-equal btn-mini remove-partner" data-id="{$id}" ><i class="fa fa-trash-o"></i></a>
            </div>
EOF;
        return $action;
    	}
        
    function action_paymentdtl($id){
        $action = <<<EOF
            <div class="tooltip-top">
               <a data-original-title="Payment Details" data-placement="top" data-toggle="tooltip" href="javascript:;" data-id="{$id}" class="btn btn-xs btn-success btn-equal btn-mini view_details"><i class="fa fa-money"></i> Payment Details</a>
            </div>
EOF;
        return $action;
    }
    
    function paymentdtl(){
        $id = $this->input->post("id");
        if ($id > 0) {
            $pay = $this->appuser_model->get_payment($id);
        }
        //var_dump($pay);die;
            $response = array("status" => "ok", "pay_info" => $pay);
        echo json_encode($response);
        die();
    }
    
    function activation(){
        $uid = $this->input->post("uid");
        $val = $this->input->post("val");
            $info = $this->appuser_model->user_activation($uid,$val);
            $response = array("status" => "ok", "info" => $info);
        echo json_encode($response);
        die();
    }
    
}


