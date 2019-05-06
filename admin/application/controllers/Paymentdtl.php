<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paymentdtl extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('paymentdtl_model');
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login/');
        } else {
            $data["extra_js"] = array('paymentdtl');
            $data['page_title'] = "Manage Payment Detail";
            $data['page'] = "paymentdtl";
            $data['main_content'] = 'paymentdtl/manage_paymentdtl';
            $this->load->view('main_content', $data);
        }
    }

    function manage() {
        $this->datatables->select('UserpaymentDtlID,CardName,CardNo,ExpiryMonth,ExpiryYear,isDefault');
        $this->datatables->from(TBL_PAYMENT_DTL)
            ->add_column('action', $this->action_row_patient('$1'), 'UserpaymentDtlID');
        $this->datatables->edit_column('isDefault', '$1', 'flex_is(isDefault)');
	$this->datatables->unset_column('UserpaymentDtlID');
        echo $this->datatables->generate();
    }
    
    function remove() 
    {
        $pay_id = ($this->input->post('id') && $this->input->post('id') > 0) ? $this->input->post('id') : 0;
		//var_dump($fcmtoken_id);die;
		if ($this->paymentdtl_model->remove($pay_id))
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
        $action = <<<EOF
            <div class="tooltip-top">
	        <a data-original-title="Remove" data-placement="top" data-toggle="tooltip" href="javascript:" class="btn btn-danger btn-xs btn-equal btn-mini view_details remove-partner" data-id="{$id}" ><i class="fa fa-trash-o"></i></a>
            </div>
EOF;
        return $action;
    	}
        
}


