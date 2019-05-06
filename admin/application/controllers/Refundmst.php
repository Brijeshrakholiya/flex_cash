<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Refundmst extends CI_Controller {

    function __construct() {
        parent::__construct();

        require_once(APPPATH . 'libraries/Stripe/init.php'); //or you
        \Stripe\Stripe::setApiKey(STRIPE_KEY);

        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->load->model('refundmst_model');
        $this->load->model('common_model');
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login/');
        } else {
            $data["extra_js"] = array('refundmst');
            $data['page_title'] = "Manage Refund Request";
            $data['page'] = "refund";
            $data['main_content'] = 'refundmst/manage_refundmst';
            $this->load->view('main_content', $data);
        }
    }

    function manage() {
        $this->datatables->select('r.RequestID,r.JoinID,f.FlexName,u.username,r.TransactionID,r.RequestDate,r.Status');


        if ($this->input->post('status') && $this->input->post('status') > 0) {
            $this->datatables->where('r.Status', $this->input->post('status'));
        }

        $this->datatables->join(TBL_USERS . ' u ', 'u.id = r.UserID', 'left');
        $this->datatables->join(TBL_FLEXMST . ' f ', 'f.FlexID = r.FlexID', 'left');
        $this->datatables->from(TBL_REFUND_REQUEST . ' r')
                ->add_column('action', $this->action_row_patient('$1'), 'r.RequestID');
        $this->datatables->edit_column('r.RequestDate', '$1', 'change_date_formate(r.RequestDate)');
        $this->datatables->edit_column('r.Status', '$1', 'change_status_formate(r.Status)');
        $this->datatables->unset_column('r.RequestID');
        $this->datatables->unset_column('r.JoinID');
        echo $this->datatables->generate();
    }

    function action_row_patient($id) {
        $action = <<<EOF
            <div class="tooltip-top">
               <a data-original-title="Request Details" data-placement="top" data-toggle="tooltip" href="javascript:;" data-id="{$id}" class="btn btn-xs btn-warning btn-equal btn-mini view_details"><i class="fa fa-undo"></i></a>
            </div>
EOF;
        return $action;
    }

    function requestdtl() {
        $rid = $this->input->post("id");
        if ($rid > 0) {
            $data = $this->refundmst_model->get_requestdtl($rid);
            $join = $this->refundmst_model->get_joindtl($data->JoinID);
        }
        //var_dump($join);die;
        $response = array("status" => "ok", "req_info" => $data, "join_info" => $join);
        echo json_encode($response);
        die();
    }

    function update_refund_request() {
        if ($this->input->post("type") == 1) {
            if ($this->input->post('pass') && ($this->input->post('pass') != '')) {
                if (!$this->check_pass($this->input->post('pass'))) {
                    $response = array('status' => 'error', 'message' => 'Password not matched.');
                } else {
                    $rid = $this->input->post("id");
                    $type = $this->input->post("type");

                    $Request = $this->refundmst_model->get_requestdtl($rid);
                    try {
                        $charge = $Request->TransactionID;
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
                        "UserID" => $Request->UserID,
                        "FlexID" => $Request->FlexID,
                        "ChargeID" => $refund->id,
                        "ChargeAmount" => $refund->amount,
                        "ChargeTransaction" => $refund->balance_transaction,
                        "FlexChargeID" => $refund->charge,
                        "CreatedOn" => $date
                    );

                    if ($id = $this->refundmst_model->add_refund_data($refund_data)) {
                        $this->refundmst_model->update_refund_request($rid, $type,$id);
                        $this->refundmst_model->refund_done($Request->JoinID);

                        $date = date("Y-m-d H:i:s");
                        $desc = 'Your Payment for <a href="' . base_url() . 'flex/flex_details/' . $Request->FlexID . '">' . $Request->FlexName . '</a> has Refunded.';
                        $userID = $Request->UserID;
                        $icon = 'undo';
                        $notification = 'Your Payment for ' . $Request->FlexName . ' has Refunded.';
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
            $this->refundmst_model->update_refund_request($rid, $type,0);
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
