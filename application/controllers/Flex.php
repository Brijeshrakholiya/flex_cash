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
        $this->load->model('user_model');
    }
    
    function share_link(){
        if(isset($_GET['link'])){
            $url = base64_decode($this->input->get('link'));
            $this->session->set_userdata('url',$url);
        }
        if ($this->session->userdata('url') != ''){
            $url = $this->session->userdata('url');
        }else{
            $url = '';
        } 
        redirect($url);
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
        /*if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }else{*/
        
            $data["flex_info"] = $this->flex_model->get_flex_details($id);
            $data["comment_info"] = $this->flex_model->get_flex_comments($id);
            $data["join_info"] = $this->flex_model->get_user_join($id);
            $data["invitee_info"] = $this->flex_model->get_user_invitee($id);
            if ($this->tank_auth->is_logged_in()) {
                $uid = $this->tank_auth->get_user_id();
                $data["inv_info"] = $this->flex_model->invite_user($uid,$id);
            }    
            //var_dump($data['inv_info']);die;
            $data["extra_js"] = array('flexdtl','jquery-accessible-dialog-tooltip-aria');
            //$data["extra_js"] = array('jquery-accessible-dialog-tooltip-aria');
            $data['page_title'] = 'Flex Details';
            $data['main_content'] = 'flex/flex_details';
            $this->load->view('main_content', $data);
        //}    
    }
    
    function join_flex($id){
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }else{
            $data["extra_js"] = array('flexdtl');
            $data["flex_info"] = $this->flex_model->get_flex_joindtl($id);
            $data["que_info"] = $this->flex_model->get_question($id);
            $data["payment_info"] = $this->flex_model->get_user_paymentdtl($this->tank_auth->get_user_id());
            //var_dump($data['flex_info']);die;
            $data['page_title'] = 'Join Flex';
            $data['main_content'] = 'flex/join_flex';
            $this->load->view('main_content', $data);    
        }    
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
                    
                    $uid = $this->tank_auth->get_user_id();
                    $flex = $this->flex_model->flex($this->input->post('flex_id'));
                    $user = $this->user_model->user($uid);
                    $img = $user->image;
                    $desc = '<a href="'.base_url().'user/user_activity/'.$user->id.'">'.$user->username.'</a> Commented on <a href="'.base_url().'flex/flex_details/'.$flex->FlexID.'">'.$flex->FlexName.'</a>.';
                    $userID = $flex->FlexUserID;
                    $icon = 'comments';
                    $notification = $user->username.' Commented on '.$flex->FlexName;
                    
                    $notification_data = array(
                        "UserID" => $userID,
                        "Icon" => $icon,
                        "ImageURL" => $img,
                        "Notification" => $notification,
                        "NotificationDesc" => $desc, 
                        "NotificationDate" => $date,
                        "IsViewed" => 0,
                        "CreatedBy" => $uid,
                        "CreatedOn" => $date,
                        "ModifiedBy" => $uid,
                    );
                    if($userID != $uid){
                        $TokenID = $this->user_model->get_tokenid($userID);
                        $Notification = $notification;
                        if($TokenID != ''){
                            if (one_singal_notification($TokenID,$Notification)) {
                            }
                        }
                        $this->home_model->add_notification($notification_data);
                    }
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
        //var_dump($this->input->post());
        $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
        
        if($this->input->post()){
            $flex_id = $this->input->post('flex_id');
            $flex_name = $this->input->post('flex_name');
            $opt_ans = $this->input->post('opt_ans');
            $ans = $this->input->post('ans');
            $quantity = $this->input->post('quantity');
            $amount = $this->input->post('new_amount');
            $payable_amount = $this->input->post('payable_amount');
            $flexamt = $amount * $quantity;
            $payment_dtlid = $this->input->post('pay_dtlid');
            $ist_success = 1;
            $card_no = $this->input->post('card_no');
            $cvc = $this->input->post('cvv_no');
            $expiry = $this->input->post('expiry');
            $date=explode('/',$expiry);
            
            $exp_month = $date[0];
            $exp_year = $date[1];
            
            require_once(APPPATH.'libraries/Stripe/init.php');//or you

            \Stripe\Stripe::setApiKey(STRIPE_KEY);
           
            $flex_userid =$this->flex_model->get_flex_userid($flex_id);
            $stripe_account = $this->flex_model->get_stripe_account($flex_userid);
            
            //var_dump($flex_userid.'-----'.$stripe_account);die;
            try {
                    $token = \Stripe\Token::create(array(
                                    "card" => array(
                                      'number' => $card_no,
                                      'cvc' => $cvc,
                                      'exp_month' => $exp_month,
                                      'exp_year' => $exp_year,
                                      'name' => $this->session->userdata('email'),
                                    )
                    ));


                    $dollars = ($payable_amount*100);
                    $stripeToken = $token->id;
                    $dec = 'Charge For '.$flex_name;


                    $Charge=\Stripe\Charge::create(array(
                      "amount" => $dollars,
                      "currency" => "usd",
                      "source" => $stripeToken, // obtained with Stripe.js
                      "description" => $dec,
                    ));    
//                    ),array("stripe_account" => $stripe_account));

            	$transactionid = $Charge->id;		
            	$this->session->set_userdata('TransactionID',$transactionid);
			}
			catch (Exception $e) {
                            $body = $e->getJsonBody();
                            $err  = $body['error'];
                           $response = array("status" => "error", "heading" => "Not Saved successfully...", "message" => $err['message']);                           
                           echo json_encode($response);
                           die;
         }
        
            
            
            if($payment_dtlid == null){
            $date = date("Y-m-d H:i:s");
            $user_payment_dtl = array(
                "UserID" => $this->tank_auth->get_user_id(),
                "PayType" => $this->input->post('payment_method'),
                "CardNo" => $this->input->post('card_dtl'),
                "ExpiryMonth" => $exp_month,
                "ExpiryYear" => $exp_year,
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
                "FlexAmt" => $flexamt,
                "TxAmt" => $payable_amount,
                "Qty" => $quantity,
                "UserpaymentDtlID" => $payment_dtlid,
                "TransactionID" => $transactionid,
                "isTransactionSuccess" => $ist_success,
                "CreatedOn" => date("Y-m-d H:i:s"),
                "CreatedBy" => $this->tank_auth->get_user_id(),
                "ModifiedBy" => $this->tank_auth->get_user_id(),
            );
            
        
            
            if($joinid = $this->flex_model->add_user_join($flex_join_data)){
                    $date = date("Y-m-d H:i:s");
                    $pay_data = array(
                        "UserID" => $this->tank_auth->get_user_id(),
                        "FlexID" => $flex_id,
                        "FlexUserAccountID" => $stripe_account,
                        "FlexChargeID" => $transactionid,
                        "FlexAmt" => $flexamt,
                        "FlexTxAmt" => $payable_amount,
                        "IsFlexActive" => 1,
                        "CreatedOn" => $date,
                    );
                    $payid = $this->flex_model->add_pay_data($pay_data);
                
                    foreach($opt_ans as $key => $val){
                        //var_dump('Que.'.$key.'  Ans.'.$val);
                        $date = date("Y-m-d H:i:s");
                        $post_data = array(
                            "UserFlexID" => $flex_id,
                            "JoinID" => $joinid,
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
                            "JoinID" => $joinid,
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
                    
                    $uid = $this->tank_auth->get_user_id();
                    $flex = $this->flex_model->flex($flex_id);
                    $user = $this->user_model->user($uid);
                    $date = date("Y-m-d H:i:s");
                    
                    $img = $user->image;
                    $desc = '<a href="'.base_url().'user/user_activity/'.$user->id.'">'.$user->username.'</a> Join <a href="'.base_url().'flex/flex_details/'.$flex->FlexID.'">'.$flex->FlexName.'</a>.';
                    $userID = $flex->FlexUserID;
                    $icon = 'plus-circle';
                    $notification = $user->username.' Join '.$flex->FlexName;
                            
                    $notification_data = array(
                        "UserID" => $userID,
                        "Icon" => $icon,
                        "ImageURL" => $img,
                        "Notification" => $notification,
                        "NotificationDesc" => $desc, 
                        "NotificationDate" => $date,
                        "IsViewed" => 0,
                        "CreatedBy" => $uid,
                        "CreatedOn" => $date,
                        "ModifiedBy" => $uid,
                    );
                    if($userID != $uid){
                        $TokenID = $this->user_model->get_tokenid($userID);
                        $Notification = $notification;
                        if($TokenID != ''){
                            if (one_singal_notification($TokenID,$Notification)) {
                            }
                        }
                        $this->home_model->add_notification($notification_data);
                    }
                    
                    if($flex->GoalQty == $flex->Joiner){
                        
                        $date = date("Y-m-d H:i:s");
                        $img = 'notification.jpg';
                        $desc = 'Your Flex <a href="'.base_url().'flex/flex_details/'.$flex->FlexID.'">'.$flex->FlexName.'</a> has reached its Goal.';
                        $userID = $flex->FlexUserID;
                        $icon = 'signal';
                        $notification = 'Your Flex '.$flex->FlexName.'has reached its Goal.';

                        $notification_data = array(
                            "UserID" => $userID,
                            "Icon" => $icon,
                            "ImageURL" => $img,
                            "Notification" => $notification,
                            "NotificationDesc" => $desc, 
                            "NotificationDate" => $date,
                            "IsViewed" => 0,
                            "CreatedBy" => $uid,
                            "CreatedOn" => $date,
                            "ModifiedBy" => $uid,
                        );
                        if($userID){
                            $TokenID = $this->user_model->get_tokenid($userID);
                            $Notification = $notification;
                            if($TokenID != ''){
                                if (one_singal_notification($TokenID,$Notification)) {
                                }
                            }
                            $this->home_model->add_notification($notification_data);
                        }
                    }
                    
                    $follow_data = array(
                        'UserID' => $userID,
                        'FollowersID' => $uid,
                        'CreatedBy' => $uid,
                        'CreatedOn' => date("Y-m-d H:i:s"),
                    );
                    $this->flex_model->join_follow_user($follow_data);
                    
                    
                    
                    
                    
                    $this->session->set_flashdata('success_msg', 'Detail Saved Succesfully.');
                    $response = array("status" => "ok", "heading" => "Saved successfully...", "message" => "You Joined Flex Succesfully.","id" =>$flex_id);
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
        
    function success_page($id){
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }else{
            if ($this->tank_auth->is_logged_in()) {
                $uid = $this->tank_auth->get_user_id();
                $data["inv_info"] = $this->flex_model->invite_user($uid,$id);
            }    
            $data["extra_js"] = array('flexdtl');
            $data['join_info'] = $this->flex_model->get_flex_joindtl($id);
            $data['page_title'] = 'Transaction Details';
            $data['main_content'] = 'flex/transection_success';
            $this->load->view('main_content', $data);
        }    
    } 
    
    function add_new_paymentdtl(){
        //var_dump($this->input->post('PayType'));die;
        //$post_data = $this->input->post();
        
        $payType = $this->input->post('PayType');
        $ExpiryMonth = $this->input->post('ExpiryMonth');
        $ExpiryYear = $this->input->post('ExpiryYear');        
        //$Expiry = $this->input->post('Expiry');
        $CardNo = $this->input->post('CardNo');
        $isDefault = $this->input->post('isDefault'); 
        if($payType == 2){
            $CardName = 'Credit Card';
        }else{
            $CardName = 'Debit Card';
        }
        //$ExpiryMonth = date('m',strtotime($Expiry));
        //$ExpiryYear = date('Y',strtotime($Expiry));
        
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
            if($que == null){$que = 0;}
            $response = array("status" => "ok","que_info" => $que);
        }else{
            $response = array("status" => "error");
        }
        echo json_encode($response);
        die;
    }
    
    function change_card(){
        $ptype = $this->input->post('type');
        $uid = $this->input->post('uid');
        if($no = $this->flex_model->get_card_no($ptype,$uid)){
            //var_dump($no);die;
            $response = array("status" => "ok","no_info" => $no);
        }else{
            $response = array("status" => "error");
        }
        echo json_encode($response);
        die;
    }
    
    function change_card_no(){
        $no = $this->input->post('no');
        $uid = $this->input->post('uid');
        if($date = $this->flex_model->get_ex_date($no,$uid)){
            //var_dump($date[0]->ExpiryMonth);die;
            $monthNum  = $date[0]->ExpiryMonth;
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('M'); 
            $year = $date[0]->ExpiryYear;
            $hi_data = $monthNum.'/'.$year;
            $data = $monthName.' '.$year;
            $pay_id = $date[0]->UserpaymentDtlID;
            $response = array("status" => "ok","date" => $data,"hi_date" => $hi_data,"pay_id" => $pay_id);
        }else{
            $response = array("status" => "error");
        }
        echo json_encode($response);
        die;
    }
    
    function invite_web_user(){
        if($this->input->post()){
            $FlexID = $this->input->post('flexid');
            $InviteByID = $this->input->post('uid');
            $Invitee = $this->input->post('user_ids');
            $date = date("Y-m-d H:i:s");
            foreach ($Invitee as $inv){
                $Inv_data = array(
                    'FlexID' => $FlexID,
                    'InviteByID' => $InviteByID,
                    'InviteeID' => $inv,
                    'InvitationDate' => date('Y-m-d'),
                    'CreatedBy' => $InviteByID,
                    'CreatedOn' => $date,
                    'ModifiedOn' => $date,
                );
                $this->flex_model->add_invite_user($Inv_data);
                
                $user = $this->user_model->user($InviteByID);
                $flex = $this->flex_model->flex($FlexID);
                $date = date("Y-m-d H:i:s");
                $img = $user->image;
                $desc = '<a href="'.base_url().'user/user_activity/'.$user->id.'">'.$user->username.'</a> Invited you to Join <a href="'.base_url().'flex/flex_details/'.$flex->FlexID.'">'.$flex->FlexName.'</a>.';
                $userID = $inv;
                $icon = 'flag';
                $notification = $user->username.' Invited you to Join '.$flex->FlexName;
                
                $notification_data = array(
                    "UserID" => $userID,
                    "Icon" => $icon,
                    "ImageURL" => $img,
                    "Notification" => $notification,
                    "NotificationDesc" => $desc, 
                    "NotificationDate" => $date,
                    "IsViewed" => 0,
                    "CreatedBy" => $InviteByID,
                    "CreatedOn" => $date,
                    "ModifiedBy" => $InviteByID,
                );
                if($userID != $InviteByID){
                    $TokenID = $this->user_model->get_tokenid($userID);
                    $Notification = $notification;
                    if($TokenID != ''){
                        if (one_singal_notification($TokenID,$Notification)) {
                        }
                    }
                    $this->home_model->add_notification($notification_data);
                }
                
            }
            $response = array("status" => "ok","message"=>"Invitation Send successfully.","heading"=>"Success");
            
        }else{
            $response = array("status" => "error","message"=>"Invitation Not Send successfully.");
        }
        echo json_encode($response);
        die;
    }
    
    function joiner_dtl(){
        $jid = $this->input->post('jid');
        $joiner_info = $this->flex_model->get_joiner_dtl($jid); 
        $que_info = $this->flex_model->get_que_ans($jid); 
        
        if($joiner_info){
            $response = array("status" => "ok","joiner_info"=>$joiner_info,"que_info" => $que_info);
        }
        echo json_encode($response);
        die;
    }
    
    function date(){
        echo date('Y-m-d H:i:s');
        echo '<br>';
        echo time_elapsed_string('2017-12-21 14:15:45');die;
    }
}    