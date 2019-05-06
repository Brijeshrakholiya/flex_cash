<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Flexmst extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('flexmst_model');
        $this->load->model('flexquestion_model');
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login/');
        } else {
            $data["extra_js"] = array('flexmst');
            $data['page_title'] = "Manage Flex";
            $data['page'] = "flex";
            $data['main_content'] = 'flexmst/manage_flexmst';
            $this->load->view('main_content', $data);
        }
    }

    function add() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login/');
        } else {
            $data["extra_js"] = array('flexmst');
            $data['page_title'] = "Add Flex";
            $data['main_content'] = 'flexmst/add_flexmst';
            $this->load->view('main_content', $data);
        }
    }
    
    function submit_form() {
                
        if ($this->input->post()) {
            $data["extra_js"] = array('flexmst');
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $error_element = error_elements();
           
            $this->form_validation
                    ->set_rules('flex_name', 'FlexName', 'required')
                    ->set_rules('flex_cat', 'FlexCat', 'required')
                    ->set_rules('flex_desc', 'FlexDesc', 'required')
                    //->set_rules('flex_image', 'FlexImageURL', 'required')
                    ->set_rules('amount_type', 'AmountType', 'required')
                    ->set_rules('amount', 'Amount', 'required')
                    ->set_rules('maxqty', 'MaxQty', 'required|numeric')
                    ->set_rules('goalqty', 'GoalQty', 'required|numeric')
                    ->set_rules('published_date', 'PublishedDate', 'required')
                    ->set_rules('end_on', 'EndsOn', 'required')
                    ->set_error_delimiters($error_element[0], $error_element[1]);
                    $date = date("Y-m-d H:i:s");
            if ($this->form_validation->run()) {
                $post_data = array(
                    "FlexUserID" => '1',
                    "FlexName" => $this->input->post('flex_name'),
                    "FlexCat" => $this->input->post('flex_cat'),
                    "FlexDesc" => $this->input->post('flex_desc'),
                    //"FlexImageURL" => '1',//$this->input->post('flex_image'),
                    "AmountType" => $this->input->post('amount_type'),
                    "Amount" => $this->input->post('amount'),
                    "MaxQty" => $this->input->post('maxqty'),
                    "GoalQty" => $this->input->post('goalqty'),
                    "FlexType" => $this->input->post('flex_type'),
                    "isCharged" => $this->input->post('ischarged'),
                    "isPublished" => $this->input->post('ispublished'),
                    "Status" => $this->input->post('status'),
                    "PublishedDate" => date('Y-m-d',strtotime($this->input->post('published_date'))),
                    "EndsOn" => date('Y-m-d',strtotime($this->input->post('end_on'))),
                    "CreatedOn" => $date,
                    "CreatedBy" => $this->tank_auth->get_user_id(),
                    "ModifiedOn" => $date,
                    "ModifiedBy" => $this->tank_auth->get_user_id(),
                    
                );
                
                $config['upload_path'] = FLEX_IMG_PATH;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 0;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);
                $flex_image = "";
                
                if (isset($_FILES["flex_image"]["name"]) && $_FILES["flex_image"]["name"] != "") {
                    if ($this->upload->do_upload('flex_image')) {

                        $upload_data = $this->upload->data();
                        $flex_image = $upload_data["file_name"];
                        $post_data['FlexImageURL'] = $flex_image;
                        if(isset($flex_info))
                        {
                            if ($flex_info->FlexImageURL && $flex_info->FlexImageURL != '') {
                                if ($file_path != "" && file_exists($file_path)):
                                $file_path =  FLEX_IMG_PATH . $user->FlexImageURL;
                                        unlink($file_path);
                                endif;
                            }
                        }
                    } else {
                        $response['heading'] = 'Upload File Not Valid !';
                        $response['message'] = $this->upload->display_errors();
                        echo json_encode($response);
                        die;
                    }
                }   
                
               
                
                $flex_id = ($this->input->post('flex_id') && $this->input->post('flex_id') > 0) ? $this->input->post('flex_id') : 0;
                if ($flex_id > 0) {
                   
                    if ($this->flexmst_model->update_flex($post_data, $flex_id)):

                        $this->session->set_flashdata('success_msg', 'Details updated successfully.');
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else:
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                } else {
                    if ($this->flexmst_model->add_flex($post_data)) {
                        $this->session->set_flashdata('success_msg', 'Fcmtoken Detail Saved Succesfully.');
                        $response = array("status" => "ok", "heading" => "Saved successfully...", "message" => "Fcmtoken Detail Saved Succesfully.");
                    } else {
                        $response = array("status" => "error", "heading" => "Not Saved successfully...", "message" => "Fcmtoken Detail Not Saved Succesfully.");
                    }
                }
            } else {
                $errors = $this->form_validation->error_array();
                $response['error'] = $errors;
            }
            echo json_encode($response);
            die;
        }
    }
    
    function manage() {
        $this->datatables->select('f.FlexID,f.FlexName,u.username,f.FlexCat,f.Amount,DATE_FORMAT(f.EndsOn, "%d %b %Y"),(SELECT SUM(`j`.`Qty`) as Total from user_flexjoin j where j.FlexID = f.FlexID)');
                $this->datatables->join(TBL_USERS.' u ' , 'u.id = f.FlexUserID', 'left');
        
		if($this->input->post('flex_cat') && $this->input->post('flex_cat')>0)
		{
                        $this->datatables->where('f.FlexCat',$this->input->post('flex_cat'));
		}		
		if($this->input->post('amount_type') && $this->input->post('amount_type')>0)
		{
                        $this->datatables->where('f.AmountType',$this->input->post('amount_type'));
		}		
		if($this->input->post('flex_type') && $this->input->post('flex_type')>0)
		{
                        $this->datatables->where('f.FlexType',$this->input->post('flex_type'));
		}
                if($this->input->post('status') && $this->input->post('status')>0)
		{
                        $this->datatables->where('f.Status',$this->input->post('status'));
		}
		
                
        $this->datatables->from(TBL_FLEXMST.' f')
            ->add_column('question', $this->action_flex_question('$1'), 'f.FlexID')
            ->add_column('action', $this->action_row_patient('$1'), 'f.FlexID');
        $this->datatables->edit_column('f.FlexCat', '$1', 'flex_cat_text(f.FlexCat)');
	$this->datatables->unset_column('f.FlexID');
        $this->datatables->unset_column('f.ModifiedOn');
        echo $this->datatables->generate();
    }
    
     function editflex($id) 
	{//var_dump($id);die;
            $data_found = 0;
            if ($id > 0) {
                    $flex = $this->flexmst_model->get_flex($id);
                if (is_object($flex) && count($flex) > 0) {
                    $data["flex_info"] = $flex;
                    $data_found = 1;
                }
            }
            if ($data_found == 0) {
                redirect('flexmst/');
            }
            $data["extra_js"] = array('flexmst');
            $data['page_title'] = "Edit Flex";
            $data['mode'] = "Edit";
            $data['main_content'] = 'flexmst/add_flexmst';
            $this->load->view('main_content', $data);
        }
        
    function viewflex($id) 
    {
        $data_found = 0;
        if ($id > 0) {
                $flex = $this->flexmst_model->get_flex($id);
            if (is_object($flex) && count($flex) > 0) {
                $data["flex_info"] = $flex;
                $data_found = 1;
            }
        }
        if ($data_found == 0) {
            redirect('flexmst/');
        }
        $join = $this->flexmst_model->get_flex_joiner($id);
        $data["join_info"] = $join;
        
        $com = $this->flexmst_model->get_user_comment($id);
        $data["comment_info"] = $com;
        
        $inv = $this->flexmst_model->get_user_invitee($id);
        $data["invitee_info"] = $inv;
        
        $data["extra_js"] = array('flexmst');
        $data['page_title'] = "View Flex";
         $data['page'] = "flex";
        $data['mode'] = "View";
        $data['main_content'] = 'flexmst/view_flexmst';
        $this->load->view('main_content', $data);
    }    
    
    function remove() 
    {
        $flex_id = ($this->input->post('id') && $this->input->post('id') > 0) ? $this->input->post('id') : 0;
		//var_dump($fcmtoken_id);die;
		if ($this->flexmst_model->remove($flex_id))
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
    
    function action_flex_question($id){
        $url= base_url().'flexmst/question_list/';
        $action = <<<EOF
            <div class="tooltip-top text-center">
               <a data-original-title="View Question" data-placement="top" data-toggle="tooltip" href="{$url}{$id}" class="btn btn-success btn-mini view_details"><i class="fa fa-question-circle"></i> View Question List</a>
            </div>
EOF;
        return $action;
    }
    function action_flex_joiner($id){
        $join = $this->flexmst_model->flex_joiner_count($id);
        $action = <<<EOF
            <div class="tooltip-top text-center">
               <a data-original-title="Flex Joiner" data-placement="top" data-toggle="tooltip" class="badge badge-success">{$join}</a>
            </div>
EOF;
        return $action;
    }
    
    function action_row_patient($id) {
        $url= base_url().'flexmst/editflex/';
        $view_url = base_url().'flexmst/viewflex/';
        $action = <<<EOF
            <div class="tooltip-top">
               <a data-original-title="View Flex" data-placement="top" data-toggle="tooltip" href="{$view_url}{$id}" class="btn btn-info btn-xs btn-equal btn-mini view_details"><i class="fa fa-eye"></i></a>
              
 	       <a data-original-title="Remove Flex" data-placement="top" data-toggle="tooltip" href="javascript:" class="btn btn-danger btn-xs btn-equal btn-mini view_details remove-partner" data-id="{$id}" ><i class="fa fa-trash-o"></i></a>
            </div>
EOF;
        return $action;
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
    function question_list($id){
        if ($id > 0) {
                $que = $this->flexmst_model->get_question($id);
                $data["que_info"] = $que;
        }
        $data["flex_name"] = $this->flexmst_model->get_flexname($id);
        
        $data["extra_js"] = array('flexmst');
        $data['page_title'] = "Question";
        $data['page'] = "flex";
        $data['mode'] = "View";
        $data['main_content'] = 'flexmst/view_questionlist';
        $this->load->view('main_content', $data);
    }  
    
    function flex_joiner($id){
        if ($id > 0) {
                $join = $this->flexmst_model->get_flex_joiner($id);
                $data["join_info"] = $join;
        }
        $data["flex_name"] = $this->flexmst_model->get_flexname($id);
        
        $data["extra_js"] = array('flexmst');
        $data['page_title'] = "Flex Joiner";
        $data['page'] = "flex";
        $data['mode'] = "View";
        $data['main_content'] = 'flexmst/flex_joiner';
        $this->load->view('main_content', $data);
    }
      
    function flex_joiner_dtl(){
        $id = $this->input->post("id");
        $uid = $this->input->post("uid");
        if ($id > 0) {
            $join = $this->flexmst_model->get_flex_joinerdtl($id,$uid);
        }
            $path = IMG_URL.USER_IMG_VIEW_PATH;
            $response = array("status" => "ok", "join_info" => $join,"path" => $path);
        echo json_encode($response);
        die();
    }
       
}


