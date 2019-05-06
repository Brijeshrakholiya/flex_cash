<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        
        require_once(APPPATH.'libraries/Stripe/init.php');//or you
        \Stripe\Stripe::setApiKey(STRIPE_KEY);
        
        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('user_model');
        $this->load->model('flex_model');
        $this->load->model('home_model');
        
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }else{
            $uid = $this->tank_auth->get_user_id();
            $data["extra_js"] = array('user');
            $user = $this->user_model->profile_dtl($uid,$uid);
            $data['flex_info'] = $this->user_model->my_flex($uid);
            $data['join_info'] = $this->user_model->my_join($uid);
            $data["payment_info"] = $this->user_model->get_user_all_paymentdtl($uid);
            $data["follower_info"] = $this->user_model->get_user_follower($uid);
            $data["following_info"] = $this->user_model->get_user_following($uid);
            $data['account_info'] = $this->user_model->get_account_details($uid);
            $data['money_out'] = $this->user_model->get_money_out($uid);
            $data['money_in'] = $this->user_model->get_money_in($uid);
            $data['money_info'] = $this->user_model->get_money($uid);

            //var_dump($data['money_out']);die();
            $data['user_info'] = $user;
            $data['page_title'] = 'Profile';
            $data['main_content'] = 'user/user_profile';
            $this->load->view('main_content', $data);
        }    
    }
    
    
    
    
    function submit_form() {
        //var_dump($this->input->post());die;  
        
         if ($this->input->post()) {
         $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $id = $this->tank_auth->get_user_id();
            $name = $this->input->post('username');
            $post_data = array(
                //"id" => $this->tank_auth->get_user_id(),
                "username" => $this->input->post('username'),
                "email" => $this->input->post('email'),
                "phone" => $this->input->post('phone'),
            );
            
            $config['upload_path'] = USER_IMG_VIEW_PATH;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_size'] = 0;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $image = "";
            //$post_data = "";

            $thumb_path = USER_IMG_THUMB_PATH;
            if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {

                if ($this->upload->do_upload('image')) {

                    $upload_data = $this->upload->data();
                    $image = $upload_data["file_name"];
                    $post_data['image'] = $image;
                    $img_name = explode('.', $image);
                    /*
                    $data = $this->user_model->profile_dtl($id);

                    if ($data->image != '') {
                        $file_path = IMG_URL.USER_IMG_VIEW_PATH . $data->image;
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                        //var_dump($file_path);die;
                        $thumb_file_path = IMG_URL.USER_IMG_THUMB_PATH.$data->image;
                        if (file_exists($thumb_file_path)) {
                            unlink($thumb_file_path);
                        }
                        
                    }
                    */
                    image_resize_upload('image',$thumb_path,$img_name[0],TRUE,$thumb_path,100,100); 
                } else {
                    $response['heading'] = 'Upload File Not Valid !';
                    $response['message'] = $this->upload->display_errors();
                    echo json_encode($response);
                    die;
                }
            }
                if ($data = $this->user_model->update_user($id,$post_data)) {
                    $this->session->set_userdata("username",$name);
                    $this->session->set_flashdata('success_msg', 'Detail Saved Succesfully.');
                    $response = array("status" => "ok", "heading" => "Saved successfully...", "message" => "Details Saved Succesfully.");
                } else {
                    $response = array("status" => FALSE, "heading" => "Not Saved successfully...", "message" => "User Detail Not Saved Succesfully.");
                }
            } else {
                $errors = $this->form_validation->error_array();
                $this->session->set_flashdata('error_msg', 'There was an unknown error that occurred. You will need to fill all the fileds.');
                //redirect('home/create_flex/');
                $response['error'] = $errors;
            }
            echo json_encode($response);
            die;
    }
    
    function del_user_paydtl(){
        $id = $this->input->post('id');
        $data = $this->user_model->del_paydtl($id); 
        if($data == 1){
            //$que = $this->home_model->get_new_que($this->tank_auth->get_user_id());
            $response = array("status" => "ok");
        }else{
            $response = array("status" => "error");
        }
        echo json_encode($response);
        die;
    }
    
    function make_defult_payment(){
        $id = $this->input->post('id');
        $uid = $this->tank_auth->get_user_id();
        if($this->user_model->set_defult_payment($id,$uid)){
            $response = array("status" => "ok");
        }else{
            $response = array("status" => "error");
        }
        echo json_encode($response);
        die;
    }
    
    function change_password(){ 
        if ($this->input->post()) {
            //var_dump($this->input->post());die;
            $error_element = error_elements();
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
            $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            if ($this->form_validation->run()) {
                if ($this->tank_auth->change_password($old_password,$new_password)){
                    $this->session->set_flashdata('success_msg', 'Flex Detail Saved Succesfully.');
                    $response = array("status" => "ok", "heading" => "Saved successfully...", "message" => "Password Updated Succesfully.");
                }else {
                    $response = array("status" => "error", "heading" => "Not Saved successfully...", "message" => "Password Not updated Succesfully.");
                }
            }else {
                $errors = $this->form_validation->error_array();
                $this->session->set_flashdata('error_msg', 'There was an unknown error that occurred. You will need to fill all the fileds.');
                //redirect('home/create_flex/');
                $response['error'] = $errors;
            }
            echo json_encode($response);
            die;
        }
    }
    
    function user_activity($uid){
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }else{
            $id = $this->tank_auth->get_user_id();
            $data["extra_js"] = array('user');
            $user = $this->user_model->profile_dtl($uid,$id);
            $data['flex_info'] = $this->user_model->my_flex($uid);
            $data['act_info'] = $this->user_model->user_act_dtl($uid);
            $data['user_info'] = $user;
            $data['uid'] = $id;
            $data['page_title'] = 'User Details';
            $data['main_content'] = 'user/user_activity';
            $this->load->view('main_content', $data);
        }    
    }
    
    function follow_user(){
        $id = $this->input->post('id');
        $uid = $this->tank_auth->get_user_id();
        
        $follow_data = array(
                    'UserID' => $id,
                    'FollowersID' => $uid,
                    'CreatedBy' => $uid,
                    'CreatedOn' => date("Y-m-d H:i:s"),
                );
        $data = $this->user_model->web_follow_user($follow_data);
        
        $follow = $this->user_model->get_follow_cnt($id);
            if (!empty($data)) {
                $user = $this->user_model->user($uid);
                $date = date("Y-m-d H:i:s");
                $img = $user->image;
                $desc = '<a href="'.base_url().'user/user_activity/'.$user->id.'">'.$user->username.'</a> Started following you.';
                $userID = $id;
                $icon = 'rss';
                $notification = $user->username.' Started following you.';
                
            $res = array("status" => "ok", "message" => "You have succesfully Followed.", "data" => $follow,"btn" => "UNFOLLOW");
        }else{
               $user = $this->user_model->user($uid);
                $date = date("Y-m-d H:i:s");
                $img = $user->image;
                $desc = '<a href="'.base_url().'user/user_activity/'.$user->id.'">'.$user->username.'</a>  Unfollows you.';
                $userID = $id;
                $icon = 'eye-slash'; 
                $notification = $user->username.' Unfollows you.';
            
            $res = array("status" => "ok", "message" => "You have succesfully Unfollowed.", "data" => $follow,"btn" => "FOLLOW");
        }
        
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
        
        echo json_encode($res);
        die();
    }
    
    
    function add_accountdtl(){
         $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
        // var_dump($this->input->post());die;
        if($this->input->post()){
            $user_id = $this->tank_auth->get_user_id();
            $email = $this->input->post('ac_email');
            $account_holder_name = $this->input->post('account_holder_name');
            $account_holder_type = "individual";//$this->input->post('account_holder_type');   
            $bank_name = $this->input->post('bank_name');
            $account_number = $this->input->post('account_number');
                    
           try { 
            $acct=\Stripe\Account::create(array(
                "type" => "custom",
                "country" => "US",
                "email" => $email,

                "external_account" => array(
                    "object" => "bank_account",
                    "account_holder_name" => $account_holder_name,
                    "account_holder_type" => $account_holder_type,
                    "bank_name" => $bank_name,
                    "country" => "US",
                    "currency" => "usd",
                    "routing_number" => "110000000",
                    "account_number" => $account_number,
                ),
            ));
            }
            catch (Exception $e) {
                $isTransactionSuccess = 0;
                $body = $e->getJsonBody();
                $err  = $body['error'];
               $response = array("status" => "error", "heading" => "Not Saved successfully...", "message" => $err['message']);                           
           echo json_encode($response);
           die;
         }
            
            $accout_id=$acct->id;
            $accout_secret=$acct->keys->secret;
            $accout_publish=$acct->keys->publishable;
            
            $date = date("Y-m-d H:i:s");
            $user_account_dtl = array(
                "UserID" => $user_id,
                "StripeAcID" => $accout_id,
                "Email" => $email,
                "AccountHolderName" => $account_holder_name,
                "AccountHolderType" => $account_holder_type,
                "BankName" => $bank_name,
                "AcNo" => $account_number,
                "SecretKey" => $accout_secret,
                "PublishableKey" => $accout_publish,
                "CreatedOn" => $date,
                "CreatedBy" => $user_id,
            ); 
            
            $Account_dtlid = $this->user_model->add_account_dtl($user_account_dtl);
            
                if($Account_dtlid){
                    
                $date = date("Y-m-d H:i:s");
                $desc = 'Checkout Your Mail and Setup Your Strip Account to Get Your Payouts.';
                $userID = $row->FlexUserID;
                $icon = 'address-book-o';
                $notification = 'Checkout Your Mail and Setup Your Strip Account to Get Your Payouts.';
                $img  = 'notification.jpg';
                
                $notification_data = array(
                    "UserID" => $user_id,
                    "Icon" => $icon,
                    "ImageURL" => $img,
                    "Notification" => $notification,
                    "NotificationDesc" => $desc, 
                    "NotificationDate" => $date,
                    "IsViewed" => 0,
                    "CreatedBy" => 1,
                    "CreatedOn" => $date,
                    "ModifiedBy" => 1,
                );
                if($user_id){
                    $TokenID = $this->user_model->get_tokenid($user_id);
                    $Notification = $notification;
                    if($TokenID != ''){
                     if (one_singal_notification($TokenID,$Notification)) {
                        }
                    }
                    $this->home_model->add_notification($notification_data);
                }
                    
                    
                    $this->session->set_flashdata('success_msg', 'Detail Saved Succesfully.');
                    $response = array("status" => "ok", "heading" => "Saved successfully...", "message" => "Your Account Details Saved Succesfully.");
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
    
    function refund_request(){
        $uid = $this->tank_auth->get_user_id();
        $jid = $this->input->post('jid');
        $fid = $this->input->post('fid');
        $fuid = $this->input->post('uid');
        
        $flexname = $this->user_model->get_flexname($fid);
        $joindtl = $this->user_model->get_joindtl($jid);
        
        $date = date("Y-m-d H:i:s");
        $request_data = array(
            "JoinID" => $jid,
            "UserID" => $uid,
            "FlexID" => $fid,
            "TransactionID" => $joindtl->TransactionID,
            "RequestDate" => $date,
            "Status" => 0,
        );
        $this->user_model->add_refund_request($request_data);
        
        $data['user'] = $this->user_model->user($uid);
        $data['flex_name'] = $flexname;
        $data['join_info'] = $joindtl;
        $data['site_name'] = $this->config->item('website_name', 'tank_auth');
        $admin_email = $this->config->item('webmaster_email', 'tank_auth');
        $user_email = 'anil.onesourcewebs@gmail.com';//$this->user_model->get_user_email($fuid);
        $from_email = $admin_email;//$this->user_model->get_user_email($uid);
        
        $type ='refund_request';
        //echo $from_email.'<br />'.$user_email.'<br />'.$admin_email;die;
        
        
        $this->load->library('email');
        $this->email->from($from_email);
        $this->email->reply_to($from_email);
        $this->email->to($user_email,$admin_email);
        $this->email->subject(sprintf("Refund Request", $this->config->item('website_name', 'tank_auth')));
        $this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
        $this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
        if($this->email->send())
        {
            $flex = $this->flex_model->flex($fid);
            $user = $this->user_model->user($uid);
            $img = $user->image;
            $desc = '<a href="'.base_url().'user/user_activity/'.$user->id.'">'.$user->username.'</a> has Requested a Refund for <a href="'.base_url().'flex/flex_details/'.$flex->FlexID.'">'.$flex->FlexName.'</a> Flex.';
            $userID = $flex->FlexUserID;
            $icon = 'money';
            $notification = $user->username.' has Requested a Refund for '.$flex->FlexName.' Flex';

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
            
            $response = array("status" => "ok");
        }
        else
        {
            $response = array("status" => "error");
        }
        echo json_encode($response);
        die;
    }
    
    function request_money(){
        $uid = $this->tank_auth->get_user_id();
        $fid = $this->input->post('fid');
        
        $account = $this->user_model->get_account_details($uid);
        
        if($account != NULL){
            $date = date("Y-m-d H:i:s");
            $account_data = array(
                "UserID" => $uid,
                "FlexID" => $fid,
                "AccountID" => $account->StripeAcID,
                "RequestDate" => $date,
            );
            $this->user_model->add_money_request($account_data);
            
            $data['account'] = $account;
            $data['user'] = $this->user_model->user($uid);
            $data['site_name'] = $this->config->item('website_name', 'tank_auth');
            $admin_email = $this->config->item('webmaster_email', 'tank_auth');
            $from_email = $admin_email;//$this->user_model->get_user_email($uid);
            
            $type ='request_money';

            $this->load->library('email');
            $this->email->from($from_email);
            $this->email->reply_to($from_email);
            $this->email->to('anil.onesourcewebs@gmail.com');
            $this->email->subject(sprintf("Request Money", $this->config->item('website_name', 'tank_auth')));
            $this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
            $this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
            if($this->email->send())
            {
                $response = array("status" => "ok");
            }
            else
            {
                $response = array("status" => "error","message"=>"There was an unknown error that occurred. You will need to refresh the page to continue working.");
            }
        }else{
            $response = array("status" => "error","message"=>"You have no money for Transfer.");
        }    
        echo json_encode($response);
        die;
    }
    
    function details(){
        

       $dtl = \Stripe\BalanceTransaction::all(array("limit" => 5));
       
       echo $dtl;
       die();
       
    }
    
    function acceptance(){
       $acct = \Stripe\Account::retrieve('acct_1BhBS7FSEFGtsQRp');
        $acct->tos_acceptance->date = time();
        // Assumes you're not using a proxy
        $acct->tos_acceptance->ip = $_SERVER['REMOTE_ADDR'];
        $acct->save();
       
    }
    
    
    
    function trans(){
        $transfer = \Stripe\Transfer::create(array(
        "amount" => 100,
        "currency" => "usd",
        "source_transaction" => "ch_1Bj1niEQ0igarWdKfXQXegPV",
        "destination" => "acct_1BizsZJic3GxPYJW",
      ));
    }
    
    
    function customer(){

    \Stripe\Customer::create(array(
      //"name" => "Tom C",
      "email" => "tomc@gmail.com",  
      "description" => "Customer for FlexCash",
      "source" => "tok_1Bj1j1EQ0igarWdK196v5liu",
      //"object" => "Card",
      //"exp_month" => "02",
      //"exp_year" => "2020",
      //"number" => "4242424242424242",
      ));
    }
    
    function charge(){

        \Stripe\Charge::create(array(
          "amount" => 1000,
          "currency" => "usd",
          "customer" => "cus_C8hjC2p0QSMdAJ", // obtained with Stripe.js
          "description" => "Charge for Test"
        ));
    }
    
    function new_charge(){
        

        $token = \Stripe\Token::create(array(
          "customer" => "cus_C8hjC2p0QSMdAJ",
        ), array("stripe_account" => "{CONNECTED_STRIPE_ACCOUNT_ID}"));

    }
    function customer_merchant(){
        
        $charge = \Stripe\Charge::create(array(
            "amount" => 1000,
            "currency" => "usd",
            "customer" => "cus_C8hjC2p0QSMdAJ",
            "source" => "cus_C8hjC2p0QSMdAJ",
          ));
        
    }
    
    function card(){
    
    \Stripe\Refund::create(array( "charge" => "ch_1BkWYLEQ0igarWdKQJkCuVu4", ));
    }
    
} 

    

                            