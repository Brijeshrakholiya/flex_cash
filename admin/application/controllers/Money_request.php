<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Money_request extends CI_Controller {

    function __construct() {
        parent::__construct();

        require_once(APPPATH . 'libraries/Stripe/init.php'); //or you
        \Stripe\Stripe::setApiKey(STRIPE_KEY);

        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('money_request_model');
        $this->load->model('common_model');
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login/');
        } else {
            $data["extra_js"] = array('money_request');
            $data['page_title'] = "Manage Money Request";
            $data['page'] = "money";
            $data['main_content'] = 'money_request/manage_money_request';
            $this->load->view('main_content', $data);
        }
    }

    function manage() {
        $this->datatables->select('m.MoneyReqID,f.FlexName,u.username,m.AccountID,m.RequestDate,m.Status');


        if ($this->input->post('status') && $this->input->post('status') > 0) {
            $this->datatables->where('m.Status', $this->input->post('status'));
        }

        $this->datatables->join(TBL_USERS . ' u ', 'u.id = m.UserID', 'left');
        $this->datatables->join(TBL_FLEXMST . ' f ', 'f.FlexID = m.FlexID', 'left');
        $this->datatables->from(TBL_MONEY_REQUEST . ' m')
                ->add_column('action', $this->action_row_patient('$1'), 'm.MoneyReqID');
        $this->datatables->edit_column('m.RequestDate', '$1', 'change_date_formate(m.RequestDate)');
        $this->datatables->edit_column('m.Status', '$1', 'change_status_formate(m.Status)');
        $this->datatables->unset_column('m.MoneyReqID');
        $this->datatables->unset_column('m.JoinID');
        echo $this->datatables->generate();
    }

    function action_row_patient($id) {
        $action = <<<EOF
            <div class="tooltip-top">
               <a data-original-title="Request Details" data-placement="top" data-toggle="tooltip" href="javascript:;" data-id="{$id}" class="btn btn-xs btn-warning btn-equal btn-mini view_details"><i class="fa fa-eye"></i></a>
            </div>
EOF;
        return $action;
    }

    function requestdtl() {
        $rid = $this->input->post("id");
        if ($rid > 0) {
            $data = $this->money_request_model->get_requestdtl($rid);
            $Amount = $this->money_request_model->get_transferable_money($data->FlexID);
            $NewAmt = ($Amount * 3) / 100;
            $PayableAmt = $Amount - $NewAmt;
        }
        //var_dump($join);die;
        $response = array("status" => "ok", "req_info" => $data,"amt"=>$PayableAmt);
        echo json_encode($response);
        die();
    }

    function update_money_request() {
        if ($this->input->post("type") == 1) {
            if ($this->input->post('pass') && ($this->input->post('pass') != '')) {
                if (!$this->check_pass($this->input->post('pass'))) {
                    $response = array('status' => 'error', 'message' => 'Password not matched.');
                } else {
                    $rid = $this->input->post("id");
                    $type = $this->input->post("type");
                    $amt = $this->input->post("amt");

                    $Request = $this->money_request_model->get_requestdtl($rid);
                    //$Amount = $amt;
                    //$NewAmt = ($Amount * 3) / 100;
                    //$PayableAmt = $Amount - $NewAmt;
                    $PayableAmt = $amt;
                    $PayableAmt = number_format($PayableAmt, 2);  
                    //echo $PayableAmt;die;
                    try {
                        $Account = $Request->AccountID;
                        $transfer = \Stripe\Transfer::create(array(
                                    "amount" => $PayableAmt*100,
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
                        "FlexID" => $Request->FlexID,
                        "TransferID" => $TransferID,
                        "TransferAmt" => $TransferAmt,
                        "TransferDestination" => $TransferDestination,
                        "TransferDestinationPay" => $TransferDestinationPay,
                        "CreatedOn" => $date,
                    );

                    if ($id = $this->money_request_model->add_transfer_data($transfer_data)) {
                        $this->money_request_model->update_money_request($rid, $type,$id);
                        $this->money_request_model->transfer_done($Request->FlexID);

                        $date = date("Y-m-d H:i:s");
                        $desc = 'Your Payment for <a href="' . base_url() . 'flex/flex_details/' . $Request->FlexID . '">' . $Request->FlexName . '</a> has Transfer to Your Stripe Account.';
                        $userID = $Request->UserID;
                        $icon = 'send';
                        $notification = 'Your Payment for ' . $Request->FlexName . ' has Transfer to Your Stripe Account.';
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
                            $TokenID = $this->common_model->get_tokenid($userID);
                            $Notification = $notification;
                            if ($TokenID != '') {
                                if (one_singal_notification($TokenID, $Notification)) {
                                    
                                }
                            }
                            $this->common_model->add_notification($notification_data);
                        }
                    }
                    $response = array("status" => "ok", "type" => $type);
                }
            } else {
                $response = array('status' => 'error', 'message' => 'Password enter valid password.');
            }
        } else if ($this->input->post("type") == 2) {
            $rid = $this->input->post("id");
            $type = $this->input->post("type");
            $this->money_request_model->update_money_request($rid, $type,0);
            $response = array("status" => "ok", "type" => $type);
        }
        echo json_encode($response);
        die();
    }

    function check_pass($password) {
        $user = $this->users->get_user_by_username($this->tank_auth->get_username());
        if (count($user) > 0):
            $hasher = new PasswordHash(
                    $this->config->item('phpass_hash_strength', 'tank_auth'), $this->config->item('phpass_hash_portable', 'tank_auth'));
            if ($hasher->CheckPassword($password, $user->password)):
                return TRUE;
            endif;
        endif;

        return FALSE;
    }

}
