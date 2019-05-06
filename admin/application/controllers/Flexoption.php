<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Flexoption extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('flexoption_model');
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login/');
        } else {
            $data["extra_js"] = array('flexoption');
            $data['page_title'] = "Manage Flex Option";
            $data['page'] = "flex_option";
            $data['main_content'] = 'flexoption/manage_flexoption';
            $this->load->view('main_content', $data);
        }
    }

    function manage() {
        $this->datatables->select('FlexOptID,fq.QuestionText,FlexOption,OptOrder');
            $this->datatables->join(TBL_FLEX_QUESTION.' fq ' , 'fq.FlexQID = flex_option.FlexQueID', 'left');
		if($this->input->post('qtype') && $this->input->post('qtype')>0)
		{
                        $this->datatables->where('Qtype',$this->input->post('qtype'));
		}		
		
                
        $this->datatables->from(TBL_FLEX_OPTION)
            ->add_column('action', $this->action_row_patient('$1'), 'FlexQueID');
	$this->datatables->unset_column('FlexOptID');
        echo $this->datatables->generate();
    }
    
    function remove() 
    {
        $option_id = ($this->input->post('id') && $this->input->post('id') > 0) ? $this->input->post('id') : 0;
		//var_dump($fcmtoken_id);die;
		if ($this->flexoption_model->remove($option_id))
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
	        <a data-original-title="Remove Option" data-placement="top" data-toggle="tooltip" href="javascript:" class="btn btn-danger btn-xs btn-equal btn-mini view_details remove-partner" data-id="{$id}" ><i class="fa fa-trash-o"></i></a>
            </div>
EOF;
        return $action;
    	}
        
}


