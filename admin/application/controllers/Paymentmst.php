<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paymentmst extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('paymentmst_model');
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login/');
        } else {
            $data["extra_js"] = array('paymentmst');
            $data['page_title'] = "Manage Payment";
            $data['page'] = "paymentmst";
            $data['main_content'] = 'paymentmst/manage_paymentmst';
            $this->load->view('main_content', $data);
        }
    }

    function manage() {
        $this->datatables->select('UserpaymentMstID,u.username,PayType,isDefault');
            $this->datatables->join(TBL_USERS.' u ' , 'u.id = user_payment_mst.UserID', 'left');
		if($this->input->post('pay_type') && $this->input->post('pay_type')>0)
		{
                        $this->datatables->where('PayType',$this->input->post('pay_type'));
		}		
		
                
        $this->datatables->from(TBL_PAYMENT_MST)
            ->add_column('action', $this->action_row_patient('$1'), 'UserpaymentMstID');
        $this->datatables->edit_column('PayType', '$1', 'pay_type(PayType)');
        $this->datatables->edit_column('isDefault', '$1', 'flex_is(isDefault)');
	$this->datatables->unset_column('UserpaymentMstID');
        echo $this->datatables->generate();
    }
    
    function remove() 
    {
        $pay_id = ($this->input->post('id') && $this->input->post('id') > 0) ? $this->input->post('id') : 0;
		//var_dump($fcmtoken_id);die;
		if ($this->paymentmst_model->remove($pay_id))
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
        $view_url = base_url().'paymentmst/viewpayment/';
        $action = <<<EOF
            <div class="tooltip-top">
                <a data-original-title="View" data-placement="top" data-toggle="tooltip" href="{$view_url}{$id}" class="btn btn-info btn-equal btn-mini view_details btn-xs"><i class="fa fa-eye"></i></a>
                
	        <a data-original-title="Remove" data-placement="top" data-toggle="tooltip" href="javascript:" class="btn btn-danger btn-xs btn-equal btn-mini view_details remove-partner" data-id="{$id}" ><i class="fa fa-trash-o"></i></a>
            </div>
EOF;
        return $action;
    }
    
    function viewpayment($id){
        $data_found = 0;
        if ($id > 0) {
                $pay = $this->paymentmst_model->get_pay($id);
            if (is_object($pay) && count($pay) > 0) {
                $data["pay_info"] = $pay;
                $data_found = 1;
            }
            
            $dtl = $this->paymentmst_model->get_dtl($id);
            $data["dtl_info"] = $dtl;
        }
        
    function view_question(){
        $id = $this->input->post("id");
        if ($id > 0) {
            $que = $this->flexquestion_model->get_pay($id);
            $opt = array();
            $opt = $this->flexquestion_model->get_dtl($id);
        }
            $response = array("status" => "ok", "pay_info" => $pay,"dtl_info" => $opt);
        echo json_encode($response);
        die();
    }
        
        
        
        if ($data_found == 0) {
            redirect('paymentmst/');
        }
        $data["extra_js"] = array('paymentmst');
        $data['page_title'] = "View Payment";
        $data['page'] = "paymentmst";
        $data['mode'] = "View";
        $data['main_content'] = 'paymentmst/view_payment';
        $this->load->view('main_content', $data);
    }
        
}


