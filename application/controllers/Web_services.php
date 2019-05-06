<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Web_services extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->ci = & get_instance();
        $this->load->config('tank_auth', TRUE);
        $this->ci->load->config('tank_auth', TRUE);
        $this->load->helper('url');
        $this->load->model('flex_model');
        $this->load->model('home_model');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->model('tank_auth/users');
        $this->load->helper('security');
        $this->load->model('web_services_model');
        $this->load->model('user_model');
    }

    function index() {
        exit('No direct script access allowed');
    }

    function user_login() {
        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        if ($this->input->get()) {
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
                    $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');
            $username = $this->input->get('username');
            $pass = $this->input->get('pass');
            $remember == $this->input->get('remember');
            $TokenID = $this->input->get('tokenid');

            $user = $this->web_services_model->get_user($username);
            //var_dump($user->activated);die;
            if ($remember) {
                $this->tank_auth->create_autologin($user->id);
            }
            if ($user->activated == 2) {       // fail - not activated
                $res = array("status" => FALSE, "message" => "Your account is not activated.", "data" => "");
                echo json_encode($res);
                die();
            }

            if ($this->tank_auth->login($username, $pass, $remember, $data['login_by_username'], $data['login_by_email'])) {
                $user_dtl = $this->web_services_model->user_dtl($user->id);
                //var_dump($user_dtl->Followers);
                $user->TotalEarning = $user_dtl->TotalEarning;
                $user->IsPayAdd = $user_dtl->IsPayAdd;
                $user->Following = $user_dtl->Following;
                $user->Followers = $user_dtl->Followers;
                $user->CreatFlex = $user_dtl->CreatFlex;
                //var_dump($user);die;
                if($user->IsPayAdd == 1){
                    $user->account_info = $this->user_model->get_account_details($user->id);
                }
                if($TokenID != ''){
                    $this->web_services_model->add_tokenid($user->id,$TokenID);
                }
                
                $user->SupportEmail = $this->config->item('webmaster_email', 'tank_auth');
                $res = array("status" => TRUE, "message" => "You have been successfully logged In.", "data" => $user);
                echo json_encode($res);
                die();
            } else {
                $res = array("status" => FALSE, "message" => "Error in Login", "data" => "");
            }
        }
        echo json_encode($res);
        die();
    }

    function user_register() {

        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        if ($this->input->post()) {
            $username = $this->input->post('username');
            //$profile = $this->input->get('profile');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $pass = $this->input->post('pass');

            /* if (!$this->tank_auth->is_username_available($username)) {
              $res['message'] = $this->lang->line('auth_username_in_use');
              }else */
            if (!$this->tank_auth->is_email_available($email)) {
                $res['message'] = $this->lang->line('auth_email_in_use');
            } else {
                $config['upload_path'] = USER_IMG_VIEW_PATH;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 0;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);
                $image = "";
                $thumb_path = USER_IMG_THUMB_PATH;

                if (!empty($this->input->post('image'))) {
                    if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {
                        if ($this->upload->do_upload('image')) {

                            $upload_data = $this->upload->data();
                            $image = $upload_data["file_name"];
                            $profile = $image;
                            $img_name = explode('.', $image);

                            image_resize_upload('image', $thumb_path, $img_name[0], TRUE, $thumb_path, 100, 100);
                        } else {
                            $response['heading'] = 'Upload File Not Valid !';
                            $response['message'] = $this->upload->display_errors();
                            echo json_encode($response);
                            die;
                        }
                    } else {
                        $response['heading'] = 'Please select file';
                        $response['message'] = $this->upload->display_errors();
                        echo json_encode($response);
                        die;
                    }
                } else {
                    $profile = '4e6937187065812aae8a86ead121b3b6.jpg';
                }
                $hasher = new PasswordHash(
                        $this->ci->config->item('phpass_hash_strength', 'tank_auth'), $this->ci->config->item('phpass_hash_portable', 'tank_auth'));
                $password = $hasher->HashPassword($pass);
                $username = urldecode($username);
                $data = array(
                    'username' => $username,
                    'email' => $email,
                    'image' => $profile,
                    'phone' => $phone,
                    'password' => $password,
                );
                //var_dump($data);die;
                //$result = $this->tank_auth->ci->users->create_mobile_user($data);
                //var_dump($result);die;
                if ($result = $this->tank_auth->ci->users->create_mobile_user($data)) {
                    $res = array("status" => TRUE, "message" => "You have successfully registered.", "data" => $result);
                }
            }
        }
        echo json_encode($res);
        die();
    }
    
    
    function change_password(){
        $uid = $this->input->get('userid');
        $old_password = $this->input->get('old_password');
        $new_password = $this->input->get('new_password');
        $confirm_new_password = $this->input->get('confirm_new_password');
        
        if($uid != ''){
            if ($old_password == '') {
                $res = array("status" => FALSE, "heading" => "Error...", "message" => "Old Password required !");
            } else if ($new_password == '') {
                $res = array("status" => FALSE, "heading" => "Error...", "message" => "New Password required !");
            } else if ($confirm_new_password == '') {
                $res = array("status" => FALSE, "heading" => "Error...", "message" => "Confirm New Password required !");
            }else if($new_password != $confirm_new_password){
                $res = array("status" => FALSE, "heading" => "Error...", "message" => "New Password and Confirm New Password Must be Same !");
            }else{
                $pass =$this->tank_auth->mobile_change_password($uid,$old_password,$new_password);
                if ($pass == TRUE){
                    $res = array("status" => TRUE, "heading" => "Saved successfully...", "message" => "Password Updated Succesfully.");
                }else {
                    $res = array("status" => FALSE, "heading" => "Error...", "message" => "Incorrect old password");
                }
            }
        }else{
            $res = array("status" => FALSE, "heading" => "Error...", "message" => "There was an unknown error that occurred.");
        }
        echo json_encode($res);
        die();
    }
    
    function forgot_password(){
        $email = $this->input->get('email');
        
        if (!is_null($data = $this->tank_auth->forgot_password($email))){

                $data['site_name'] = $this->config->item('website_name', 'tank_auth');

                $new_password = random_string('alnum', 8);
                
                $hasher = new PasswordHash(
                    $this->config->item('phpass_hash_strength', 'tank_auth'), $this->config->item('phpass_hash_portable', 'tank_auth'));
                $hashed_password = $hasher->HashPassword($new_password);
                $data['pass']= $new_password;
                
                $this->web_services_model->update_pass($data['user_id'],$hashed_password);
                
                $this->_send_email('new_pass', $data['email'], $data);
                
                $message =$this->lang->line('auth_message_new_password_sent');

        } else {
            $errors = $this->tank_auth->get_error_message();
            foreach ($errors as $k => $v){	
                $mess['errors'][$k] = $this->lang->line($v);
                $message = "Email doesn't exist";
            }
        }
        
        $res = array("status" => TRUE, "message" => $message);
        echo json_encode($res);
        die();
    }
    
    function update_userprofile() {

        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        if ($this->input->post()) {
            $userid = $this->input->post('userid');
            $username = $this->input->post('username');
            //$profile = $this->input->get('profile');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            
            $username = urldecode($username);
            $config['upload_path'] = USER_IMG_VIEW_PATH;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_size'] = 0;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $image = "";
            $thumb_path = USER_IMG_THUMB_PATH;


            if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {
                if ($this->upload->do_upload('image')) {

                    $upload_data = $this->upload->data();
                    $image = $upload_data["file_name"];
                    $profile = $image;
                    $img_name = explode('.', $image);

                    image_resize_upload('image', $thumb_path, $img_name[0], TRUE, $thumb_path, 100, 100);
                } else {
                    $response['heading'] = 'Upload File Not Valid !';
                    $response['message'] = $this->upload->display_errors();
                    echo json_encode($response);
                    die;
                }
            } else {
                /* $response['heading'] = 'Please select file';
                  $response['message'] = $this->upload->display_errors();
                  echo json_encode($response);
                  die; */
                //$image = $this->web_service_model->get_user_img($userid);
                $profile = '';
            }
            /* if (!$this->tank_auth->is_username_available($username)) {
              $res['message'] = $this->lang->line('auth_username_in_use');
              }else */

            $data = array(
                'username' => $username,
                'email' => $email,
                'image' => $profile,
                'phone' => $phone,
            );
            // var_dump($data);die;
            if ($this->web_services_model->update_user_profile($data, $userid)) {

                $userdata = $this->web_services_model->get_user_data($userid);
                $res = array("status" => TRUE, "message" => "Your details successfully updated.", "data" => $userdata);
            } else {
                $res = array("status" => TRUE, "message" => "Error in update.", "data" => '');
            }
        }
        echo json_encode($res);
        die();
    }

    function get_flex_list() {
        $uid = $this->input->get('userid');
        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        $data = $this->web_services_model->get_flex_list($uid);
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        }
        echo json_encode($res);
        die();
    }

    function get_userflex_join_list() {
        $userid = $this->input->get('userid');
        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        $data = $this->web_services_model->get_userflex_join_list($userid);
        //$data['path'] = '';
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        }
        echo json_encode($res);
        die();
    }

    function get_userflex_list() {
        $userid = $this->input->get('userid');
        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        $data = $this->web_services_model->get_userflex_list($userid);
        //$data['path'] = '';
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        }
        echo json_encode($res);
        die();
    }

    function get_flex_comments() {
        $flexid = $this->input->get('flexid');
        $res = array("status" => FALSE, "message" => "No Comments Avilable for this Flex.", "data" => "");
        $data = $this->web_services_model->get_flex_comments($flexid);
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        }
        echo json_encode($res);
        die();
    }

    function follow_user() {
        $uid = $this->input->get('userid');
        $fid = $this->input->get('followerid');

        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        $follow_data = array(
            'UserID' => $uid,
            'FollowersID' => $fid,
            'CreatedBy' => $fid,
            'CreatedOn' => date("Y-m-d H:i:s"),
        );
        $follow = $this->web_services_model->insert_follow_user($follow_data);

        $data['IsFollow'] = $this->web_services_model->get_isfollow($uid, $fid);
        $data['Followers'] = $this->web_services_model->get_followers($uid);
        //var_dump($data);die;
        if (!empty($follow)) {
            
            $user = $this->user_model->user($fid);
            $date = date("Y-m-d H:i:s");
            $img = $user->image;
            $desc = '<a href="'.base_url().'user/user_activity/'.$user->id.'">'.$user->username.'</a> Started following you.';
            $userID = $uid;
            $icon = 'rss';
            $notification = $user->username.' Started following you.';;
            
            
            $res = array("status" => TRUE, "message" => "You have succesfully Followed.", "data" => $data);
        } else {
            
            $user = $this->user_model->user($fid);
            $date = date("Y-m-d H:i:s");
            $img = $user->image;
            $desc = '<a href="'.base_url().'user/user_activity/'.$user->id.'">'.$user->username.'</a>  Unfollows you.';
            $userID = $uid;
            $icon = 'eye-slash'; 
            $notification = $user->username.' Unfollows you.';
            
            $res = array("status" => TRUE, "message" => "You have succesfully Unfollowed.", "data" => $data);
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
        if($userID != $fid){
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

    function create_flex_api() {
        
        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");

        if ($this->input->post()) {
            $FlexUserID = $this->input->post('userid');
            $flex_name = $this->input->post('flex_name');
            $flex_cat = $this->input->post('flex_cat');
            $flex_desc = $this->input->post('flex_desc');
            //$flex_image = $this->input->post('image');
            $amount_type = $this->input->post('amount_type');
            $amount = $this->input->post('amount');
            $maxqty = $this->input->post('maxqty');
            $goalqty = $this->input->post('goalqty');
            $flex_type = $this->input->post('flex_type');
            $ischarged = $this->input->post('ischarged');
            $ispublished = $this->input->post('ispublished');
            $published_date = $this->input->post('published_date');
            $end_on = $this->input->post('end_on');
            
            
            if($maxqty == ''){
                $maxqty = 99999;
            }
            /* if($flex_image == ''){
              $res = array("status" => FALSE, "message" => "Flex Banner required !");
              }else */
            if ($flex_name == '') {
                $res = array("status" => FALSE, "message" => "FlexName required !");
            } else if ($flex_desc == '') {
                $res = array("status" => FALSE, "message" => "Flex Description required !");
            } else if ($flex_cat == '') {
                $res = array("status" => FALSE, "message" => "Flex Type required !");
            } else if ($amount_type == '') {
                $res = array("status" => FALSE, "message" => "Amount Type required !");
            } else if ($amount_type != 1 && $amount == '') {
                $res = array("status" => FALSE, "message" => "Flex Amount required !");
            } /*else if ($maxqty == '') {
                $res = array("status" => FALSE, "message" => "Maximum Quantity Available required !");
            } */else if ($end_on == '') {
                $res = array("status" => FALSE, "message" => "Flex End Date required !");
            } else {

                $config['upload_path'] = FLEX_IMG_VIEW_PATH;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 0;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);
                $image = "";

                $thumb_path = FLEX_IMG_THUMB_PATH;
                if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {
                    if ($this->upload->do_upload('image')) {

                        $upload_data = $this->upload->data();
                        $image = $upload_data["file_name"];
                        $flex_image = $image;
                        $img_name = explode('.', $image);

                        image_resize_upload('image',$thumb_path,$img_name[0],TRUE,$thumb_path,360,155); 
                    } else {
                        $response['heading'] = 'Upload File Not Valid !';
                        $response['message'] = $this->upload->display_errors();
                        echo json_encode($response);
                        die;
                    }
                } else {
                 // $flex_image = '';
                    $response['heading'] = 'Please select Flex Banner.';
                    $response['message'] = $this->upload->display_errors();
                    echo json_encode($response);
                    die;
                } 
                $flex_name = urldecode($flex_name);
                $flex_desc = urldecode($flex_desc);
                $flex_data = array(
                    "FlexUserID" => $FlexUserID,
                    "FlexName" => $flex_name,
                    "FlexCat" => $flex_cat,
                    "FlexDesc" => $flex_desc,
                    "FlexImageURL" => $flex_image,
                    "AmountType" => $amount_type,
                    "Amount" => $amount,
                    "MaxQty" => $maxqty,
                    "GoalQty" => $goalqty,
                    "FlexType" => $flex_type,
                    "isCharged" => $ischarged,
                    "isPublished" => $ispublished,
                    "PublishedDate" => $published_date,
                    "EndsOn" => $end_on,
                    "CreatedOn" => date("Y-m-d H:i:s"),
                    "CreatedBy" => $FlexUserID,
                );
                
                if ($id = $this->web_services_model->create_flex_api($flex_data)) {

                    $this->flex_model->add_question($id, $FlexUserID);
                    $this->home_model->clear_temp($FlexUserID);

                    $res = array("status" => TRUE, "message" => "Flex Detail Saved Succesfully.", "data" => $id);
                    //return true;
                } else {
                    $res = array("status" => TRUE, "message" => "There was an unknown error that occurred. Flex Detail not Saved Succesfully.");
                }
            }
            echo json_encode($res);
            die();
        }
    }

    function get_notification() {
        $userid = $this->input->get('userid');
        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        $data = $this->web_services_model->get_notification($userid);
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        }
        echo json_encode($res);
        die();
    }

    function my_following() {
        $id = $this->input->get('userid');

        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        $data = $this->web_services_model->get_my_followig($id);
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        }
        echo json_encode($res);
        die();
    }
	
	 function my_followers() {
        $id = $this->input->get('userid');

        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        $data = $this->web_services_model->get_my_followers($id);
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        }
        echo json_encode($res);
        die();
    }

    function user_details() {
        $id = $this->input->get('flexuserid');
        $uid = $this->input->get('userid');
        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        $data = $this->web_services_model->get_userdtl($id, $uid);
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        }
        echo json_encode($res);
        die();
    }

    function unfollow_user() {
        $uid = $this->input->get('userid');
        $id = $this->input->get('myid');

        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");

        $data = $this->web_services_model->delunfollow_user($uid, $id);
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "You have succesfully Unfollowed.", "data" => $data);
        }
        echo json_encode($res);
        die();
    }

    function join_list() {
        $fid = $this->input->get('flexid');

        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");

        $data = $this->web_services_model->join_user_list($fid);
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        } else {
            $res = array("status" => FALSE, "message" => "No Join User Found.", "data" => '');
        }
        echo json_encode($res);
        die();
    }

    function invitee_list() {
        $fid = $this->input->get('flexid');

        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");

        $data = $this->web_services_model->invitee_user_list($fid);
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        } else {
            $res = array("status" => FALSE, "message" => "No Invited User Found.", "data" => '');
        }
        echo json_encode($res);
        die();
    }

    function response($res) {
        echo json_encode($res);
    }

    function add_flex_comment() {
        $fid = $this->input->get('flexid');
        $uid = $this->input->get('userid');
        $comment = $this->input->get('comment');

        $date = date("Y-m-d H:i:s");

        $comment_data = array(
            'UserID' => $uid,
            'FlexID' => $fid,
            'Comment' => $comment,
            'CommentDate' => $date,
            'CreatedBy' => $fid,
            'CreatedOn' => $date
        );

        if ($id = $this->web_services_model->flex_user_comment($comment_data)) {
            
            $flex = $this->flex_model->flex($fid);
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
                    
            $res = array("status" => TRUE, "message" => "", "data" => $id);
        } else {
            $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        }

        echo json_encode($res);
        die;
    }

    function create_join() {
        $fid = $this->input->get('flexid');
        $uid = $this->input->get('userid');

        $data["flex_info"] = $this->flex_model->get_flex_joindtl($fid);
        $que_info = $this->web_services_model->get_question($fid);
        $data["que_info"] = ($que_info != NULL) ? $que_info : array();
        $payment_info = $this->flex_model->get_user_paymentdtl($uid);
        $data["payment_info"] = ($payment_info != NULL) ? $payment_info : new stdClass();
        $card_dtl = $this->web_services_model->get_user_carddtl($uid);
        $data["card_info"] = ($card_dtl != NULL) ? $card_dtl : array();


        $res = array("status" => TRUE, "message" => "", "data" => $data);
        echo json_encode($res);
        die;
    }

    function add_temp_question() {
        $UserID = $this->input->get('userid');
        $Question = $this->input->get('question');
        $Qtype = $this->input->get('qtype');
        $isRequired = $this->input->get('isrequired');
        $Qorder = $this->input->get('qorder');
        $QOption = $this->input->get('qoption');
        $Oorder = $this->input->get('oorder');

        $que_data = array(
            "UserID" => $UserID,
            "Question" => $Question,
            "Qtype" => $Qtype,
            "isRequired" => $isRequired,
            "Qorder" => $Qorder,
            "QOption" => $QOption,
            "Oorder" => $Oorder
        );

        if ($this->web_services_model->add_temp_que($que_data)) {
            $data = $this->home_model->get_new_que($UserID);
            if ($data == null) {
                $data = 0;
            }
            $res = array("status" => TRUE, "message" => "Question Added.", "data" => $data);
            //return true;
        } else {
            $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        }

        echo json_encode($res);
        die;
    }

    function clear_temp() {
        $UserID = $this->input->get('userid');
        if ($this->home_model->clear_temp($UserID)) {
            $res = array("status" => TRUE, "message" => "Clear Success.", "data" => "");
        } else {
            $res = array("status" => TRUE);
        }
        echo json_encode($res);
        die;
    }

    function user_activity() {
        $uid = $this->input->get('userid');

        if ($data = $this->web_services_model->get_user_activity($uid)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        } else {
            $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        }

        echo json_encode($res);
        die;
    }

    function social_login() {

        $response = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");

        if ($this->input->get('email')) {

            $email = $this->input->get('email');

            if ($user_data = $this->web_services_model->check_app_social_login($email)) {
                unset($user_data->Password);
                //var_dump($user_data);die;
                $user_dtl = $this->web_services_model->user_dtl($user_data->id);
                $user_data->Following = $user_dtl->Following;
                $user_data->Followers = $user_dtl->Followers;
                $user_data->CreatFlex = $user_dtl->CreatFlex;
                $response = array("status" => TRUE, "message" => "", "data" => $user_data);
            } else {
                $default_password = random_string('alnum', 16);
                $hasher = new PasswordHash(
                        $this->config->item('phpass_hash_strength', 'tank_auth'), $this->config->item('phpass_hash_portable', 'tank_auth'));
                $hashed_password = $hasher->HashPassword($default_password);
                if ($this->web_services_model->check_email_id($this->input->get('email'))) {
                    $response['message'] = $this->lang->line('auth_email_in_use');
                } else {
                    $data = array(
                        'username' => $this->input->get('username'),
                        'email' => $this->input->get('email'),
                        //'phone' => $this->input->get('phone'),
                        'password' => $hashed_password,
                        'image' => $this->input->get('image'),
                        'created' => date("Y-m-d H:i:s"),
                    );
                    if (!is_null($res = $this->web_services_model->app_client($data))) {
                        $data = $this->web_services_model->get_user_data($res);
                        $user_dtl = $this->web_services_model->user_dtl($res);
                        $data->Following = $user_dtl->Following;
                        $data->Followers = $user_dtl->Followers;
                        $data->CreatFlex = $user_dtl->CreatFlex;
                        $response = array("status" => TRUE, "message" => "", "data" => $data);
                    }
                }
            }
        }
        echo json_encode($response);
        die;
    }

    function confirm_join() {

        $FlexID = $this->input->post('flexid');
        $UserID = $this->input->post('userid');
        $JoinDate = $this->input->post('joindate');
        $FlexAmt = $this->input->post('flexamt');
        $Qty = $this->input->post('qty');
        $UserpaymentDtlID = $this->input->post('userpaymentdtlid');
        //$TransactionID = $this->input->post('transactionid');
        //$isTransactionSuccess = $this->input->post('istransactionsuccess');
        $que_info = $this->input->post('que_info');
        $PayType = $this->input->post('pay_type');
        $CardNo = $this->input->post('cardno');
        $ex_date = $this->input->post('ex_date');
        $cvc = $this->input->post('cvv');
        $flex_name = $this->input->post('flexname');
        $amt = $this->input->post('new_amount');
        
        
         $date=explode('/',$ex_date);
            
            $exp_month = $date[0];
            $exp_year =  $date[1];
        //var_dump($this->input->post());die;
        $user_email = $this->user_model->get_user_email($UserID);
        $flex_userid =$this->flex_model->get_flex_userid($FlexID);
        $stripe_account = $this->flex_model->get_stripe_account($flex_userid);
        //$amt = $this->flex_model->get_flexamt($FlexID);
        $new_amt = $amt * $Qty;
        
        require_once(APPPATH.'libraries/Stripe/init.php');//or you

        \Stripe\Stripe::setApiKey(STRIPE_KEY);
            
    try {
            $token = \Stripe\Token::create(array(
                "card" => array(
                  'number' => $CardNo,
                  'cvc' => $cvc,
                  'exp_month' => $exp_month,
                  'exp_year' => $exp_year,
                  'name' => $user_email,
                )
            ));


            $dollars = ($FlexAmt*100);
            $stripeToken = $token->id;
            $dec = 'Charge For '.$flex_name;


            $Charge=\Stripe\Charge::create(array(
              "amount" => $dollars,
              "currency" => "usd",
              "source" => $stripeToken, // obtained with Stripe.js
              "description" => $dec,
            ),array("stripe_account" => $stripe_account));

            $TransactionID = $Charge->id;
            $isTransactionSuccess = 1;
            //$this->session->set_userdata('TransactionID',$TransactionID);
            }
            catch (Exception $e) {
                $isTransactionSuccess = 0;
                $body = $e->getJsonBody();
                $err  = $body['error'];
               $response = array("status" => False, "heading" => "Not Saved successfully...", "message" => $err['message']);                           
           echo json_encode($response);
           die;
         }
        
        
        
        
        if ($UserpaymentDtlID == 0) {
            if ($PayType == 2) {
                $cardname = 'Credit Card';
            } else {
                $cardname = 'Debit Card';
            }
            $date = date("Y-m-d H:i:s");
            $user_payment_dtl = array(
                "UserID" => $UserID,
                "PayType" => $PayType,
                "CardName" => $cardname,
                "CardNo" => $CardNo,
                "ExpiryMonth" => date('m', strtotime($ex_date)),
                "ExpiryYear" => date('Y', strtotime($ex_date)),
                "isDefault" => 1, //$this->input->post('isdefault'),
                "CreatedOn" => $date,
                "CreatedBy" => $UserID,
                "ModifiedOn" => $date,
                "ModifiedBy" => $UserID,
            );
            //var_dump($user_payment_dtl);die;
            $UserpaymentDtlID = $this->flex_model->add_new_paydtl($UserID, $user_payment_dtl);
        }
        $flex_join_data = array(
            "FlexID" => $FlexID,
            "UserID" => $UserID,
            "JoinDate" => $JoinDate,
            "FlexAmt" => $new_amt,
            "TxAmt" => $FlexAmt,
            "Qty" => $Qty,
            "UserpaymentDtlID" => $UserpaymentDtlID,
            "TransactionID" => $TransactionID,
            "isTransactionSuccess" => $isTransactionSuccess,
            "CreatedOn" => date("Y-m-d H:i:s"),
            "CreatedBy" => $UserID,
            "ModifiedBy" => $UserID,
        );
        if ($joinid =$this->flex_model->add_user_join($flex_join_data)) {
            
            $que_info = json_decode($que_info);
                //print_r($que_info);die;
                foreach ($que_info as $que) {
                    $date = date("Y-m-d H:i:s");
                    if ($que->Qtype == 1) {
                        $que_data = array(
                            "UserFlexID" => $UserID,
                            "JoinID" => $joinid,
                            "FlexQID" => $que->FlexQID,
                            "Answer" => $que->Ans,
                            "FlexOID" => '',
                            "CreatedOn" => $date,
                            "CreatedBy" => $UserID,
                            "ModifiedBy" => $UserID,
                        );
                        if ($que->Ans != '') {
                            $this->flex_model->add_que_ans($que_data);
                        }
                    } else {
                        $que_data = array(
                            "UserFlexID" => $UserID,
                            "JoinID" => $joinid,
                            "FlexQID" => $que->FlexQID,
                            "Answer" => '',
                            "FlexOID" => $que->Ans,
                            "CreatedOn" => $date,
                            "CreatedBy" => $UserID,
                            "ModifiedBy" => $UserID,
                        );
                        if ($que->Ans != 0) {
                            $this->flex_model->add_que_ans($que_data);
                        }
                    }
                }
        
            $uid = $UserID;
            $flex = $this->flex_model->flex($FlexID);
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
            $response = array("status" => TRUE, "heading" => "Saved successfully...", "message" => "You Joined Flex Succesfully.","TransactionID" => $TransactionID);
        } else {
            $response = array("status" => FALSE, "heading" => "Not Saved successfully...", "message" => "Error.");
        }
        echo json_encode($response);
        die;
        //var_dump($que_info);die;
    }

    function add_paymentdtl() {
        //var_dump($this->input->get());die;
        $UserID = $this->input->get('userid');
        $PayType = $this->input->get('pay_type');
        $CardNo = $this->input->get('cardno');
        $ex_date = $this->input->get('ex_date');
        $date = date("Y-m-d H:i:s");
        if ($PayType == 2) {
            $cardname = 'Credit Card';
        } else {
            $cardname = 'Debit Card';
        }
        
        $ex_date = explode('/', $ex_date);
        $payment_data = array(
            "UserID" => $UserID,
            "PayType" => $PayType,
            "CardName" => $cardname,
            "CardNo" => $CardNo,
            "ExpiryMonth" => $ex_date[0],
            "ExpiryYear" => $ex_date[1],
            "isDefault" => 1, //$this->input->post('isdefault'),
            "CreatedOn" => $date,
            "CreatedBy" => $UserID,
            "ModifiedOn" => $date,
            "ModifiedBy" => $UserID,
        );
        if ($this->flex_model->add_new_paydtl($UserID, $payment_data)) {

            $this->session->set_flashdata('success_msg', 'Detail Saved Succesfully.');
            $response = array("status" => TRUE, "heading" => "Saved successfully...", "message" => "Payment Details Saved Succesfully.");
        } else {
            $response = array("status" => FALSE, "heading" => "Not Saved successfully...", "message" => "Error.");
        }
        echo json_encode($response);
        die;
    }

    function get_flex_details() {
        $flex_id = $this->input->get('flex_id');
        $user_id = $this->input->get('userid');
        $res = array("status" => FALSE, "message" => "No Data Avilable.", "data" => "");
        $data = $this->web_services_model->get_flex_details($flex_id, $user_id);
        if (!empty($data)) {
            $res = array("status" => TRUE, "message" => "", "data" => $data);
        }
        echo json_encode($res);
        die();
    }

    function del_temp_que() {
        $id = $this->input->get('que_id');
        $uid = $this->input->get('userid');
        if ($this->flex_model->del_que($id)) {
            $que = $this->home_model->get_new_que($this->tank_auth->get_user_id());
            $data = $this->home_model->get_new_que($uid);
            if ($data == null) {
                $data = array();
            }
            $response = array("status" => TRUE, "message" => "Question Deleted successfully", "data" => $data);
        } else {
            $response = array("status" => FALSE);
        }
        echo json_encode($response);
        die();
    }
    
    function get_temp_que(){
        $uid = $this->input->get('userid');
        $data = $this->home_model->get_new_que($uid);
        if ($data != null) {
            $response = array("status" => TRUE, "data" => $data);
        } else {
            $data = array();
            $response = array("status" => FALSE, "data" => $data);
        }
        echo json_encode($response);
        die();
    }
    
    function get_invite_userlist(){
        $uid = $this->input->get('userid');
        $fid = $this->input->get('flexid');
        
        $data = $this->web_services_model->invite_user($uid,$fid);
        if ($data != null) {
            $response = array("status" => TRUE, "data" => $data);
        } else {
            $data = array();
            $response = array("status" => FALSE, "data" => $data);
        }
        echo json_encode($response);
        die();
    }
    
    function get_share_link(){
        $fid = $this->input->get('flexid');
        if($fid != ''){
            $flex_url = base_url().'flex/flex_details/'.$fid;
        }else{
            $flex_url = base_url();
        }
        $new_url = base64_encode($flex_url);
        $url = base_url().'flex/share_link/?link='.$new_url;
        
        if ($url != null) {
            $response = array("status" => TRUE, "url" => $url);
        }
        echo json_encode($response);
        die();
    }
    
    function flex_invite_user(){
        if($this->input->post()){
            $FlexID = $this->input->post('flexid');
            $InviteByID = $this->input->post('userid');
            $users = $this->input->post('ids_arr');
            $Invitee = json_decode($users);
            $date = date("Y-m-d H:i:s");
            foreach ($Invitee as $inv){
                $Inv_data = array(
                    'FlexID' => $FlexID,
                    'InviteByID' => $InviteByID,
                    'InviteeID' => $inv->uid,
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
                $userID = $inv->uid;
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
            $response = array("status" => true,"message"=>"Invitation Send successfully.","heading"=>"Success");
            
        }else{
            $response = array("status" => false,"message"=>"Invitation Not Send successfully.");
        }
        echo json_encode($response);
        die;
    }
    
    function add_user_accountdtl(){
        $user_id = $this->input->post('userid');
        $email = $this->input->post('email');
        $account_holder_name = $this->input->post('account_holder_name');
        $account_holder_type = "individual";//$this->input->post('account_holder_type');   
        $bank_name = $this->input->post('bank_name');
        $account_number = $this->input->post('account_number');

        require_once(APPPATH.'libraries/Stripe/init.php');//or you
        \Stripe\Stripe::setApiKey(STRIPE_KEY);
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
                $body = $e->getJsonBody();
                $err  = $body['error'];
               $response = array("status" => FALSE, "heading" => "Not Saved successfully...", "message" => $err['message']);                           
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
        $data->IsPayAdd = $this->web_services_model->is_account_add($user_id);
        
            if($Account_dtlid != ''){
                
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
                
                $data->account_info = $this->user_model->get_account_details($user_id);
                $this->session->set_flashdata('success_msg', 'Detail Saved Succesfully.');
                $response = array("status" => TRUE, "heading" => "Saved successfully...", "message" => "Your Account Details Saved Succesfully.","data" => $data);
            } else {
                $response = array("status" => FALSE, "heading" => "Not Saved successfully...", "message" => "Error.");
            }
        echo json_encode($response);
        die;    
    }
    
    function is_account_added(){
        $uid = $this->input->get('userid');
        $data = $this->web_services_model->is_account_add($uid);
        if ($data == 1) {
            $response = array("status" => TRUE, "data" => $data);
        }else{
            $response = array("status" => False, "data" => $data);
        } 
        echo json_encode($response);
        die();
    }
    
    function money_out(){
        $uid = $this->input->get('userid');
        $data = $this->web_services_model->get_money_out($uid);
        if ($data != null) {
            $response = array("status" => TRUE, "data" => $data);
        }else{
            $data = new stdClass();
            $response = array("status" => False, "data"=> $data);
        } 
        echo json_encode($response);
        die();
    }
    
    function money_in(){
        $uid = $this->input->get('userid');
        $data = $this->web_services_model->get_money_in($uid);
        if ($data != null) {
            $response = array("status" => TRUE, "data" => $data);
        }else{
            $data = new stdClass();
            $response = array("status" => False, "data"=> $data);
        } 
        echo json_encode($response);
        die();
    }
    
    function joiner_dtl(){
        $jid = $this->input->get('joinid');
        if($jid != ''){
            $data['joiner_info'] = $this->flex_model->get_joiner_dtl($jid); 
            $data['que_info'] = $this->flex_model->get_que_ans($jid); 
            if($data['joiner_info'] == NULL){
                $data['joiner_info'] = new stdClass();
            }
            if($data['que_info'] == NULL){
                $data['que_info'] = array();
            }

            if($data){
                $response = array("status" => TRUE,"data"=>$data);
            }
        }else{
            $response = array("status" => False,"message"=>'No data avilable !');
        }    
        echo json_encode($response);
        die;
    }
    
    function get_money_info(){
        $uid = $this->input->get('userid');
        $data = $this->web_services_model->get_all_money($uid);
        if ($data != null) {
            $response = array("status" => TRUE, "data" => $data);
        }else{
            $data = new stdClass();
            $response = array("status" => False, "data"=> $data);
        } 
        echo json_encode($response);
        die();
    }
    
    function refund_request(){
        $uid = $this->input->get('userid');
        $jid = $this->input->get('joinid');
        $fid = $this->input->get('flexid');
        //$fuid = $this->input->get('flexuserid');
        $fuid = $this->user_model->get_userid_byflex($fid);
        
        $flexname = $this->user_model->get_flexname($fid);
        $joindtl = $this->user_model->get_joindtl($jid);
        
        $date = date("Y-m-d H:i:s");
        $request_data = array(
            "JoinID" => $jid,
            "UserID" => $uid,
            "FlexID" => $fid,
            "TransactionID" => $joindtl->TransactionID,
            "RequestDate" => $date,
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
            $response = array("status" => TRUE,"message"=>"Your request successfully sent.");
        }
        else
        {
            $response = array("status" => False,"message" => "Your Refund Request is not sent Try again later.");
        }
        echo json_encode($response);
        die;
    }
    
    function request_money(){
        $uid = $this->input->get('userid');
        $fid = $this->input->get('flexid');
        
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
                $response = array("status" => TRUE,"message" => "Your request successfully sent.");
            }
            else
            {
                $response = array("status" => false,"message"=>"Your Request is not sent try again later.");
            }
        }else{
            $response = array("status" => false,"message"=>"You have no money for Transfer.");
        }    
        echo json_encode($response);
        die;
    }
    
        function contact_mail(){
        $uid = $this->input->get('userid');
        $msg = $this->input->get('message');
        if($msg != ''){
        $data['user'] = $this->user_model->user($uid);
        $data['site_name'] = $this->config->item('website_name', 'tank_auth');
        $data['message'] = $msg;
        
        $admin_email = $this->config->item('webmaster_email', 'tank_auth');
        $from_email = $admin_email;//$this->user_model->get_user_email($uid);
        $type ='contact';
        
        $this->load->library('email');
            $this->email->from($from_email);
            $this->email->reply_to($from_email);
            $this->email->to('anil.onesourcewebs@gmail.com');
            $this->email->subject(sprintf("FlexCash Contact Support", $this->config->item('website_name', 'tank_auth')));
            $this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
            $this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
            if($this->email->send())
            {
                $response = array("status" => TRUE,"message" => "Your Message send Successfully.");
            }
            else
            {
                $response = array("status" => false,"message"=>"Your Message is not send try again later.");
            }
        }else{
            $response = array("status" => false,"message"=>"Please Enter Message to send.");
        }   
        echo json_encode($response);
        die;
    }
    
    
    function get_user_carddtl(){
        $uid = $this->input->get('userid');
        $card_dtl = $this->web_services_model->get_user_carddtl($uid);
        
        $data["card_info"] = ($card_dtl != NULL) ? $card_dtl : array();
        $res = array("status" => TRUE, "message" => "", "data" => $data);
        echo json_encode($res);
        die;
    }
    
    function make_defult_payment(){
        $uid = $this->input->get('userid');
        $pid = $this->input->get('payid');
        if($this->user_model->set_defult_payment($pid,$uid)){
            $res = array("status" => TRUE);
        }else{
            $res = array("status" => FALSE);
        }
        echo json_encode($res);
        die;
    }
    
    function del_user_paydtl(){
        $id = $this->input->get('payid');
        $data = $this->user_model->del_paydtl($id);
        if($data == 1){
            $res = array("status" => TRUE);
        }else{
            $res = array("status" => FALSE,"message" => "you can't delete defult card !");
        }
        echo json_encode($res);
        die;
    }
    
    function _send_email($type, $email, &$data)
    {
            $this->load->library('email');
            $this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
            $this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
            $this->email->to($email);
            $this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
            $this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
            $this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
            $this->email->send();
    }
    
    
    
    
   
    

}
