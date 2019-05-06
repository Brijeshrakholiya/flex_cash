<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();

        require_once(APPPATH . 'libraries/Stripe/init.php'); //or you
        \Stripe\Stripe::setApiKey(STRIPE_KEY);

        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('home_model');
        $this->load->model('flex_model');
        $this->load->model('user_model');
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            //redirect('/auth/login/');
            $data['page_title'] = 'HOME';
            $data['main_content'] = 'home/home';
            $this->load->view('main_content', $data);
        } else {
            $uid = $this->tank_auth->get_user_id();
            $flex = $this->home_model->get_flex($uid);
            $payment = $this->home_model->get_ACdtl($uid);
            $ispay = $this->home_model->get_ispay($uid);

            //var_dump($ispay);die;
            if ($ispay == 1) {
                $data['skip'] = 'yes';
            } else {
                $data['skip'] = 'no';
            }
            if ($payment == 1) {
                $data['pay_dtl'] = 'yes';
                //$this->session->set_userdata('skip','yes');
            } else {
                $data['pay_dtl'] = 'no';
            }
            /* if ($this->session->userdata('skip') != ''){
              $data['skip'] = 'yes';
              }else{
              $data['skip'] = 'no';
              } */
            //$this->sessions();   
            $this->home_model->set_show_pay($uid);
            $data["extra_js"] = array('homepage');
            $data["flex_info"] = $flex;
            $data['page_title'] = 'All Flexes';
            $data['main_content'] = 'flex/flex_list';
            $this->load->view('main_content', $data);
        }
    }

    function sessions() {
        $this->session->set_userdata('skip', 'yes');
    }

    function add_paymentdtl() {
        if ($this->input->post()) {
            $date = date("Y-m-d H:i:s");
            $post_data = array(
                "UserID" => $this->tank_auth->get_user_id(),
                "PayType" => $this->input->post('amount_type'),
                "CardNo" => $this->input->post('card_no'),
                "ExpiryMonth" => date('m', strtotime($this->input->post('ex_date'))),
                "ExpiryYear" => date('Y', strtotime($this->input->post('ex_date'))),
                "isDefault" => $this->input->post('isdefault'),
                "CreatedOn" => $date,
                "CreatedBy" => $this->tank_auth->get_user_id(),
                "ModifiedOn" => $date,
                "ModifiedBy" => $this->tank_auth->get_user_id(),
            );
            //var_dump($post_data);die;
            //$this->home_model->add_payment_dtl($post_data);
            if ($this->home_model->add_payment_dtl($post_data)) {

                $this->session->set_flashdata('success_msg', 'Payment Detail Saved Succesfully.');
                $response = array("status" => "ok", "heading" => "Saved successfully...", "message" => "Payment Detail Saved Succesfully.");
            } else {
                $response = array("status" => "error", "heading" => "Not Saved successfully...", "message" => "Payment Detail Not Saved Succesfully.");
            }
            echo json_encode($response);
            die;
        }
    }

    function create_flex() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            $uid = $this->tank_auth->get_user_id();
            $payment = $this->home_model->get_ACdtl($uid);
            if ($payment == 1) {

                $this->home_model->clear_temp($this->tank_auth->get_user_id());
                $que = $this->flex_model->get_question($this->tank_auth->get_user_id());
                //
                $data["extra_js"] = array('flexmst');
                $data['page_title'] = 'Create Flex';
                $data['que_info'] = $que;
                $data['main_content'] = 'flex/create_flex';
                $this->load->view('main_content', $data);
            } else {
                $this->index();
            }
        }
    }

    function flexbanner() {
        //var_dump($this->input->post());
        $uid = $this->tank_auth->get_user_id();
        $this->load->helper('profile');
        $post = isset($_POST) ? $_POST : array();

        switch ($post['action']) {
            case 'save' :
                saveAvatarTmp();
                break;
            default:
                changeAvatar($uid);
        }
    }

    function about() {
        $data['page_title'] = 'About Us';
        $data['main_content'] = 'home/aboutpage';
        $this->load->view('main_content', $data);
    }

    function privacy() {
        $data['page_title'] = 'Privacy Policy';
        $data['main_content'] = 'home/privacypage';
        $this->load->view('main_content', $data);
    }

    function terms_conditions() {
        $data['page_title'] = 'Terms & Conditions';
        $data['main_content'] = 'home/termpage';
        $this->load->view('main_content', $data);
    }

    function contact() {
        $data["extra_js"] = array('homepage');
        $data['page_title'] = 'Contact Support';
        $data['main_content'] = 'home/contactpage';
        $this->load->view('main_content', $data);
    }

    function flex_list() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            $uid = $this->tank_auth->get_user_id();
            $flex = $this->home_model->get_flex($uid);
            $data["flex_info"] = $flex;
            $data['page_title'] = 'All Flexes';
            $data['main_content'] = 'flex/flex_list';
            $this->load->view('main_content', $data);
        }
    }

    function submit_form() {
        //var_dump($this->input->post());die;  
        $uid = $this->tank_auth->get_user_id();
        if ($this->input->post()) {
            $data["extra_js"] = array('flexmst');
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $error_element = error_elements();

            $this->form_validation
                    ->set_rules('flex_name', 'Flex Name', 'required')
                    ->set_rules('flex_cat', 'Flex Type', 'required')
                    ->set_rules('flex_desc', 'Flex Description', 'required')
                    ->set_rules('amount_type', 'Amount Type', 'required')
                    ///->set_rules('amount', 'Amount', 'required')
                    ///->set_rules('maxqty', 'MaxQty', 'required|numeric')
                    ///->set_rules('goalqty', 'GoalQty', 'required|numeric')
                    ///->set_rules('published_date', 'PublishedDate', 'required')
                    ->set_rules('end_on', 'Flex end date', 'required')
                    ->set_error_delimiters($error_element[0], $error_element[1]);
            $date = date("Y-m-d H:i:s");
            if ($this->input->post('amount_type') != 1) {
                $this->form_validation->set_rules('amount', 'Amount', 'required');
            }
            if ($this->input->post('maxqty') == '') {
                $maxqty = 99999;
            } else {
                $maxqty = $this->input->post('maxqty');
            }
            $IsCharged = ($this->input->post('ischarged')) ? $this->input->post('ischarged') : 0;
            if ($this->form_validation->run()) {
                $post_data = array(
                    "FlexUserID" => $this->tank_auth->get_user_id(),
                    "FlexName" => $this->input->post('flex_name'),
                    "FlexCat" => $this->input->post('flex_cat'),
                    "FlexDesc" => $this->input->post('flex_desc'),
                    //"FlexImageURL" => '1',//$this->input->post('flex_image'),
                    "AmountType" => $this->input->post('amount_type'),
                    "Amount" => $this->input->post('amount'),
                    "MaxQty" => $maxqty,
                    "GoalQty" => $this->input->post('goalqty'),
                    "FlexType" => $this->input->post('flex_type'),
                    "isCharged" => $IsCharged,
                    "isPublished" => 1,
                    "Status" => $this->input->post('status'),
                    "PublishedDate" => $date,
                    "EndsOn" => $this->input->post('end_on'),
                    "CreatedOn" => $date,
                    "CreatedBy" => $this->tank_auth->get_user_id(),
                    "ModifiedOn" => $date,
                    "ModifiedBy" => $this->tank_auth->get_user_id(),
                );

                $flex_img = $this->input->post('flex_image');
                $thumb_path = FLEX_IMG_THUMB_PATH;
                $image_id = random_string('alnum', 25);
                //$image_id = base64_encode($image_id);

                list($type, $flex_img) = explode(';', $flex_img);
                list(, $flex_img) = explode(',', $flex_img);
                $flex_img = base64_decode($flex_img);
                $Img_name = $image_id . '.jpg';
                file_put_contents(FLEX_IMG_VIEW_PATH . $Img_name, $flex_img);

                $img = base_url() . FLEX_IMG_VIEW_PATH . $Img_name;
                $temp = FLEX_IMG_TEMP_PATH . $Img_name;
                //copy($img,$temp);

                Thumbnail($img, FLEX_IMG_THUMB_PATH, $Img_name, 320, 150);
                Thumbnail($img, FLEX_IMG_MOBILE_THUMB_PATH, $Img_name, 150, 150);

                //createThumbs(FLEX_IMG_TEMP_PATH,FLEX_IMG_THUMB_PATH,360);
                // createThumbs(FLEX_IMG_TEMP_PATH,FLEX_IMG_MOBILE_THUMB_PATH,150);
                //unlink(FLEX_IMG_TEMP_PATH.$Img_name); 

                $post_data['FlexImageURL'] = $Img_name;


                if ($id = $this->home_model->add_flex($post_data)) {

                    $this->flex_model->add_question($id, $this->tank_auth->get_user_id());

                    $this->session->set_flashdata('success_msg', 'Flex Detail Saved Succesfully.');
                    $response = array("status" => "ok", "heading" => "Saved successfully...", "message" => "You have Successfully created your Flex.", "id" => $id);
                } else {
                    $response = array("status" => "error", "heading" => "Not Saved successfully...", "message" => "Flex Detail Not Saved Succesfully.");
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
    }

    function notification() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            $uid = $this->tank_auth->get_user_id();
            $data["extra_js"] = array('notification');
            $data['page_title'] = 'Notification';
            $data['main_content'] = 'home/notification';
            $data['not_info'] = $this->home_model->get_nofification($uid);
            $this->load->view('main_content', $data);
        }
    }

    function get_notification_cnt() {
        $uid = $this->tank_auth->get_user_id();

        $cnt = $this->home_model->get_noti_cnt($uid);
        $response = array("cnt" => $cnt);
        echo json_encode($response);
        die;
    }

    function update_notification() {
        $uid = $this->tank_auth->get_user_id();
        if ($this->home_model->update_noti($uid)) {
            $response = array("status" => "ok");
        }
        echo json_encode($response);
        die;
    }

    function contact_form() {
        $uid = $this->tank_auth->get_user_id();
        $msg = $this->input->post('message');
        if ($msg != '') {
            $data['user'] = $this->user_model->user($uid);
            $data['site_name'] = $this->config->item('website_name', 'tank_auth');
            $data['message'] = $msg;

            $admin_email = $this->config->item('webmaster_email', 'tank_auth');
            $from_email = $admin_email; //$this->user_model->get_user_email($uid);
            $type = 'contact';

            $this->load->library('email');
            $this->email->from($from_email);
            $this->email->reply_to($from_email);
            $this->email->to('anil.onesourcewebs@gmail.com');
            $this->email->subject(sprintf("FlexCash Contact Support", $this->config->item('website_name', 'tank_auth')));
            $this->email->message($this->load->view('email/' . $type . '-html', $data, TRUE));
            $this->email->set_alt_message($this->load->view('email/' . $type . '-txt', $data, TRUE));
            if ($this->email->send()) {
                $response = array("status" => "ok", "message" => "Your Message send Successfully.");
            } else {
                $response = array("status" => "error", "message" => "Your Message is not send try again later.");
            }
        } else {
            $response = array("status" => "error", "message" => "Please Enter Message to send.");
        }
        echo json_encode($response);
        die;
    }

    function defult_notification() {
        $data = $this->home_model->get_flex_enddtl();

        foreach ($data as $row) {
            $hours = get_remaing_days($row->EndsOn, 1);
//            echo $hours;die;
            if ($hours == 24) {
                $date = date("Y-m-d H:i:s");
                $desc = 'Your Flex <a href="' . base_url() . 'flex/flex_details/' . $row->FlexID . '">' . $row->FlexName . '</a> Ends in 24 Houres.';
                $userID = $row->FlexUserID;
                $icon = 'hourglass-end';
                $notification = 'Your Flex ' . $row->FlexName . ' Ends in 24 Houres.';
                $img = 'notification.jpg';

                $notification_data = array(
                    "UserID" => $userID,
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
                if ($userID) {
                    $TokenID = $this->user_model->get_tokenid($userID);
                    $Notification = $notification;
                    if ($TokenID != '') {
                        if (one_singal_notification($TokenID, $Notification)) {
                            
                        }
                    }
                    $this->home_model->add_notification($notification_data);
                }
            }
        }
        $this->flex_end_notification();
        echo 'ok';
        die;
    }

    function flex_end_notification() {
        $data = $this->home_model->get_flex_end();
        if ($data != null) {
            foreach ($data as $row) {
                $FlexID = $row->FlexID;
                $Flex_Goal = $this->flex_model->is_goal_reached($FlexID);
                $IsCharged = $this->flex_model->is_chargeable($FlexID);
                if ($Flex_Goal->Joiner > 0) {
                    if ($Flex_Goal->Status == 1 || $IsCharged == 0) {
                        $data = $this->home_model->get_payamt_account($FlexID);
                        $Amount = $data->PayableAmt;
                        $NewAmt = ($Amount * 3) / 100;
                        $PayableAmt = $Amount - $NewAmt;
                        $PayableAmt = number_format($PayableAmt, 2);
                        //echo $Amount;
                        $Account = $data->FlexUserAccountID;
                        if ($data != NULL) {
                            try {
                                $transfer = \Stripe\Transfer::create(array(
                                            "amount" => $PayableAmt * 100,
                                            "currency" => "usd",
                                            "destination" => $Account,
                                ));
                            } catch (Exception $e) {
                                $body = $e->getJsonBody();
                                $err = $body['error'];
                                $response = array("status" => "error", "heading" => "Not Saved successfully...", "message" => $err['message']);
                                echo json_encode($response);
                                die;
                            }
                            $TransferID = $transfer->id;
                            $TransferAmt = $transfer->amount;
                            $TransferDestination = $transfer->destination;
                            $TransferDestinationPay = $transfer->destination_payment;

                            $date = date("Y-m-d H:i:s");
                            $transfer_data = array(
                                "FlexID" => $FlexID,
                                "TransferID" => $TransferID,
                                "TransferAmt" => $TransferAmt,
                                "TransferDestination" => $TransferDestination,
                                "TransferDestinationPay" => $TransferDestinationPay,
                                "CreatedOn" => $date,
                            );

                            $this->home_model->add_transfer_data($transfer_data);
                            $this->home_model->payment_done($FlexID);

                            $date = date("Y-m-d H:i:s");
                            $desc = 'Your Flex <a href="' . base_url() . 'flex/flex_details/' . $row->FlexID . '">' . $row->FlexName . '</a> has endad and your payment is on its way.';
                            $userID = $row->FlexUserID;
                            $icon = 'send';
                            $notification = 'Your Flex ' . $row->FlexName . ' has endad and your payment is on its way.';
                            $img = 'notification.jpg';
                        }
                    } else {
                        if ($payment_info = $this->home_model->get_payment_info($FlexID)) {
                            foreach ($payment_info as $payment) {
                                try {
                                    $charge = $payment->FlexChargeID;
                                    $refund = \Stripe\Refund::create(array(
                                                "charge" => $charge
                                    ));
                                } catch (Exception $e) {
                                    $body = $e->getJsonBody();
                                    $err = $body['error'];
                                    $response = array("status" => "error", "heading" => "Not Saved successfully...", "message" => $err['message']);
                                    echo json_encode($response);
                                    die;
                                }

                                $date = date("Y-m-d H:i:s");
                                $refund_data = array(
                                    "UserID" => $payment->UserID,
                                    "FlexID" => $payment->FlexID,
                                    "ChargeID" => $refund->id,
                                    "ChargeAmount" => $refund->amount,
                                    "ChargeTransaction" => $refund->balance_transaction,
                                    "FlexChargeID" => $refund->charge,
                                    "CreatedOn" => $date
                                );

                                if ($id = $this->home_model->add_refund_data($refund_data)) {

                                    $date = date("Y-m-d H:i:s");
                                    $desc = 'Your Payment for <a href="' . base_url() . 'flex/flex_details/' . $row->FlexID . '">' . $row->FlexName . '</a> has Refunded due to Flex Goal is Not Reached.';
                                    $userID = $payment->UserID;
                                    $icon = 'undo';
                                    $notification = 'Your Payment for ' . $row->FlexName . ' has Refunded due to Flex Goal is Not Reached.';
                                    $img = 'notification.jpg';

                                    $notification_data = array(
                                        "UserID" => $userID,
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
                                    if ($userID) {
                                        $TokenID = $this->user_model->get_tokenid($userID);
                                        $Notification = $notification;
                                        if ($TokenID != '') {
                                            if (one_singal_notification($TokenID, $Notification)) {
                                                
                                            }
                                        }
                                        $this->home_model->add_notification($notification_data);
                                    }
                                }
                            }
                            $this->home_model->refund_done($FlexID);
                            $date = date("Y-m-d H:i:s");
                            $desc = 'Your Flex <a href="' . base_url() . 'flex/flex_details/' . $row->FlexID . '">' . $row->FlexName . '</a> has endad but Flex Goal is Not Reached so payment Refund to Customer.';
                            $userID = $row->FlexUserID;
                            $icon = 'random';
                            $notification = 'Your Flex ' . $row->FlexName . ' has endad but Flex Goal is Not Reached so Payment Refund to Customer.';
                            $img = 'notification.jpg';
                        }
                    }


                    $notification_data = array(
                        "UserID" => $userID,
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
                    if ($userID) {
                        $TokenID = $this->user_model->get_tokenid($userID);
                        $Notification = $notification;
                        if ($TokenID != '') {
                            if (one_singal_notification($TokenID, $Notification)) {
                                
                            }
                        }
                        $this->home_model->add_notification($notification_data);
                    }
                }
            }
        }
        echo 'ok';
        die;
    }

    function test() {
        $FlexID = 67;
        $data = $this->home_model->count_payable_amt($FlexID);
        var_dump($data->FlexUserAccountID);
    }

    function date() {
        echo $date = date("Y-m-d H:i:s");
    }

}
