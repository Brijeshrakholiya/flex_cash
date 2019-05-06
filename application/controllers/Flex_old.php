<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Flex extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('flex_model');
        $this->load->model('home_model');
    }
    
    function temp_question(){
        $post_data = $this->input->post();
        $post_data['UserID'] = $this->tank_auth->get_user_id();
        if($this->flex_model->add_temp_question($post_data)){
            $que = $this->home_model->get_new_que($this->tank_auth->get_user_id());
            $response = array("status" => "ok","que_info" => $que);
        }else{
            $response = array("status" => "error");
        }
        echo json_encode($response);
        die;
    }
    
    function flex_details($id){
        $data["flex_info"] = $this->flex_model->get_flex_details($id);
        $data["comment_info"] = $this->flex_model->get_flex_comments($id);
        $data["join_info"] = $this->flex_model->get_user_join($id);
        $data["invitee_info"] = $this->flex_model->get_user_invitee($id);
        //var_dump($data['invitee_info']);die;
        $data["extra_js"] = array('flexdtl');
        $data['page_title'] = 'Flex Details';
        $data['main_content'] = 'flex/flex_details';
        $this->load->view('main_content', $data);
    }
    
    function join_flex($id){
        $data["extra_js"] = array('flexdtl');
        $data["flex_info"] = $this->flex_model->get_flex_joindtl($id);
        $data["que_info"] = $this->flex_model->get_question($id);
        $data["payment_info"] = $this->flex_model->get_user_paymentdtl($this->tank_auth->get_user_id());
        $data['page_title'] = 'Join Flex';
        $data['main_content'] = 'flex/join_flex';
        $this->load->view('main_content', $data);    
    }
    
    function user_comments(){
         if ($this->input->post()) {
            $data["extra_js"] = array('flexdtl');
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $error_element = error_elements();
           
            $this->form_validation
                    ->set_rules('comment', 'Comment', 'required')
                    ->set_error_delimiters($error_element[0], $error_element[1]);
                    $date = date("Y-m-d H:i:s");
            if ($this->form_validation->run()) {
                $post_data = array(
                    "UserID" => $this->tank_auth->get_user_id(),
                    "FlexID" => $this->input->post('flex_id'),
                    "Comment" => $this->input->post('comment'),
                    "CommentDate" => $date,
                    "CreatedOn" => $date,
                    "CreatedBy" => $this->tank_auth->get_user_id(),
                    "ModifiedBy" => $this->tank_auth->get_user_id(),
                    
                );
                
                if ($id = $this->flex_model->add_comment($post_data)) {
                    
                    $this->session->set_flashdata('success_msg', 'Detail Saved Succesfully.');
                    $response = array("status" => "ok", "heading" => "Saved successfully...", "message" => "Comment Saved Succesfully.");
                } else {
                    $response = array("status" => "error", "heading" => "Not Saved successfully...", "message" => "Comment Not Saved Succesfully.");
                }
            } else {
                $errors = $this->form_validation->error_array();
                $this->session->set_flashdata('error_msg', 'There was an unknown error that occurred. You will need to fill all the fileds.');
                $response['error'] = $errors;
            }
            echo json_encode($response);
            die;
        }
    }
    
    function join_form(){
        //var_dump($this->input->post());die;
        $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
        
        if($this->input->post()){
            $flex_id = $this->input->post('flex_id');
            $opt_ans = $this->input->post('opt_ans');
            $ans = $this->input->post('ans');
            $quantity = $this->input->post('quantity');
            $amount = $this->input->post('amount');
            $payable_amount = $this->input->post('payable_amount');
            $flexamt = $amount * $quantity;
            $payment_dtlid = $this->input->post('pay_dtlid');
            $transactionid = '123456';
            $ist_success = 1;
            /*var_dump($opt_ans);
            var_dump($ans);die;*/
            foreach($opt_ans as $key => $val){
                //var_dump('Que.'.$key.'  Ans.'.$val);
                $date = date("Y-m-d H:i:s");
                $post_data = array(
                    "UserFlexID" => $flex_id,
                    "FlexQID" => $key,
                    "Answer" => '',
                    "FlexOID" => $val,
                    "CreatedOn" => $date,
                    "CreatedBy" => $this->tank_auth->get_user_id(),
                    "ModifiedBy" => $this->tank_auth->get_user_id(),
                );
                if($val != 0){
                    $this->flex_model->add_que_ans($post_data);
                }
            }
            foreach($ans as $key => $val){
                //var_dump('Que.'.$key.'  Ans.'.$val);
                $date = date("Y-m-d H:i:s");
                $post_data = array(
                    "UserFlexID" => $flex_id,
                    "FlexQID" => $key,
                    "Answer" => $val,
                    "FlexOID" => '',
                    "CreatedOn" => $date,
                    "CreatedBy" => $this->tank_auth->get_user_id(),
                    "ModifiedBy" => $this->tank_auth->get_user_id(),
                );
                if($val != ''){
                $this->flex_model->add_que_ans($post_data);
                }
            }
            
            if($payment_dtlid == null){
            $date = date("Y-m-d H:i:s");
            $user_payment_dtl = array(
                "UserID" => $this->tank_auth->get_user_id(),
                "PayType" => $this->input->post('payment_method'),
                "CardNo" => $this->input->post('card_dtl'),
                "ExpiryMonth" => date('m',strtotime($this->input->post('ex_date'))),
                "ExpiryYear" => date('Y',strtotime($this->input->post('ex_date'))),
                "isDefault" => 0,//$this->input->post('isdefault'),
                "CreatedOn" => $date,
                "CreatedBy" => $this->tank_auth->get_user_id(),
                "ModifiedOn" => $date,
                "ModifiedBy" => $this->tank_auth->get_user_id(),
            );             
            $payment_dtlid = $this->home_model->add_payment_dtl($user_payment_dtl);
            }
            
            $flex_join_data = array(
                "FlexID" => $flex_id,
                "UserID" => $this->tank_auth->get_user_id(),
                "JoinDate" => date("Y-m-d"),
                "FlexAmt" => $payable_amount,
                "Qty" => $quantity,
                "UserpaymentDtlID" => $payment_dtlid,
                "TransactionID" => $transactionid,
                "isTransactionSuccess" => $ist_success,
                "CreatedOn" => date("Y-m-d H:i:s"),
                "CreatedBy" => $this->tank_auth->get_user_id(),
                "ModifiedBy" => $this->tank_auth->get_user_id(),
            );
            if($this->flex_model->add_user_join($flex_join_data)){
                    
                    $this->session->set_flashdata('success_msg', 'Detail Saved Succesfully.');
                    $response = array("status" => "ok", "heading" => "Saved successfully...", "message" => "You Joined Flex Succesfully.");
                } else {
                    $response = array("status" => "error", "heading" => "Not Saved successfully...", "message" => "Error.");
                }
            } else {
                $errors = $this->form_validation->error_array();
                $this->session->set_flashdata('error_msg', 'There was an unknown error that occurred. You will need to fill all the fileds.');
                $response['error'] = $errors;
            }
            echo json_encode($response);
            die;
        }
        
    function success_page(){
        $data['page_title'] = 'Transaction Details';
        $data['main_content'] = 'flex/transection_success';
        $this->load->view('main_content', $data);
    } 
    
    function add_new_paymentdtl(){
        //var_dump($this->input->post('PayType'));die;
        //$post_data = $this->input->post();
        
        $payType = $this->input->post('PayType');
        $Expiry = $this->input->post('Expiry');
        $CardNo = $this->input->post('CardNo');
        $isDefault = $this->input->post('isDefault'); 
        if($payType == 2){
            $CardName = 'Credit Card';
        }else{
            $CardName = 'Debit Card';
        }
        $ExpiryMonth = date('m',strtotime($Expiry));
        $ExpiryYear = date('Y',strtotime($Expiry));
        
        $post_data = $this->input->post();
        $id = $this->tank_auth->get_user_id();
        //$post_data['$payType'] = $id;
        
        $post_data =array(
            "UserID" => $id,
            "PayType" => $payType,
            "CardName" => $CardName,
            "CardNo" => $CardNo,
            "ExpiryMonth" => $ExpiryMonth,
            "ExpiryYear" => $ExpiryYear,
            "isDefault" => $isDefault,
            "CreatedOn" => date("Y-m-d H:i:s"),
            "CreatedBy" => $this->tank_auth->get_user_id(),
            "ModifiedBy" => $this->tank_auth->get_user_id(),
        );
        //var_dump($post_data);die;
        if($this->flex_model->add_new_paydtl($id,$post_data)){
            $response = array("status" => "ok");
        }else{
            $response = array("status" => "error");
        }
        echo json_encode($response);
        die;
    }
    
    
    function del_temp_question(){
        $id = $this->input->post('id');
        //var_dump($id);die;
        if($this->flex_model->del_que($id)){
            $que = $this->home_model->get_new_que($this->tank_auth->get_user_id());
            $response = array("status" => "ok","que_info" => $que);
        }else{
            $response = array("status" => "error");
        }
        echo json_encode($response);
        die;
    }
    
    function date_demo(){
        get_remaing_days('2017-12-07 01:44:23');
    }
}    