<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Flexquestion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('flexquestion_model');
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login/');
        } else {
            $data["extra_js"] = array('flexquestion');
            $data['page_title'] = "Manage Flex Question";
            $data['page'] = "flex_question";
            $data['main_content'] = 'flexquestion/manage_flexquestion';
            $this->load->view('main_content', $data);
        }
    }

    function manage() {
        $this->datatables->select('FlexQID,f.FlexName,Qtype,QuestionText,isRequired,Qorder');
            $this->datatables->join(TBL_FLEXMST .' f' , 'f.FlexID = flex_question.FlexID', 'left');
		if($this->input->post('qtype') && $this->input->post('qtype')>0)
		{
                        $this->datatables->where('Qtype',$this->input->post('qtype'));
		}		
		
                
        $this->datatables->from(TBL_FLEX_QUESTION)
            ->add_column('action', $this->action_row_patient('$1'), 'FlexQID');
        $this->datatables->edit_column('isRequired', '$1', 'flex_is(isRequired)');
        $this->datatables->edit_column('Qtype', '$1', 'question_type_text(Qtype)');
	$this->datatables->unset_column('FlexQID');
        echo $this->datatables->generate();
    }
    
    function remove() 
    {
        $question_id = ($this->input->post('id') && $this->input->post('id') > 0) ? $this->input->post('id') : 0;
		//var_dump($fcmtoken_id);die;
		if ($this->flexquestion_model->remove($question_id))
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
    
    function viewque($id) 
    {
        $data_found = 0;
        if ($id > 0) {
                $que = $this->flexquestion_model->get_flex($id);
            if (is_object($que) && count($que) > 0) {
                $data["que_info"] = $que;
                $data_found = 1;
            }
            
            $opt = $this->flexquestion_model->get_opt($id);
            $data["opt_info"] = $opt;
        }
        
        
        
        if ($data_found == 0) {
            redirect('flexquestion/');
        }
        $data["extra_js"] = array('flexquestion');
        $data['page_title'] = "View Question";
         $data['page'] = "flex_question";
        $data['mode'] = "View";
        $data['main_content'] = 'flexquestion/view_question';
        $this->load->view('main_content', $data);
    } 
    
    
    function view_question(){
        $id = $this->input->post("id");
        if ($id > 0) {
            $que = $this->flexquestion_model->get_flex($id);
            $opt = array();
            $opt = $this->flexquestion_model->get_opt($id);
        }
            $response = array("status" => "ok", "que_info" => $que,"opt_info" => $opt);
        echo json_encode($response);
        die();
    }
    
    function action_row_patient($id) {
        $view_url = base_url().'flexquestion/viewque/';
        $action = <<<EOF
            <div class="tooltip-top">
                
                <a data-original-title="View Details" data-placement="top" data-toggle="tooltip" href="javascript:;" data-id="{$id}" class="btn btn-xs btn-info btn-equal btn-mini view_details"><i class="fa fa-eye"></i></a>
                
	        <a data-original-title="Remove Question" data-placement="top" data-toggle="tooltip" href="javascript:" class="btn btn-danger btn-xs btn-equal btn-mini remove-partner" data-id="{$id}" ><i class="fa fa-trash-o"></i></a>
            </div>
EOF;
        return $action;
    	}
        
}


