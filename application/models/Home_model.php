<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function add_flex($data) {
        $this->db->insert(TBL_FLEXMST, $data);
        return $this->db->insert_id();
    }
    
    function get_flex_123(){
        $date = date('Y-m-d H:i:s');
        $this->db->select('f.*,u.*,(SELECT SUM(`j`.`Qty`) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.FlexID = f.FlexID) As Joiner,(SELECT SUM(`j`.`FlexAmt`) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.FlexID = f.FlexID) As Amount,(SELECT COUNT(`c`.`CommentID`) from '.TBL_USER_COMMENTS.' c where c.FlexID = f.FlexID) As Comments');
        $this->db->where('f.FlexType', 1);
            $this->db->join(TBL_USERS.' u', 'f.FlexUserID = u.id');
            $this->db->where('EndsOn >=',$date);
        $this->db->order_by("f.EndsOn", "aes");
        $query = $this->db->get(TBL_FLEXMST.' f');
//        echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_flex($id){
        $date = date('Y-m-d H:i:s');
        $final_query ="SELECT `f`.*, `u`.*, (SELECT SUM(`j`.`Qty`) as Joiner from user_flexjoin j where j.Status = 1 AND j.FlexID = f.FlexID) As Joiner, (SELECT SUM(`j`.`FlexAmt`) as Amount from user_flexjoin j where j.Status = 1 AND j.FlexID = f.FlexID) As Amount, (SELECT COUNT(`c`.`CommentID`) from user_comment c where c.FlexID = f.FlexID) As Comments FROM `flex_mst` `f` JOIN `users` `u` ON `f`.`FlexUserID` = `u`.`id` WHERE `f`.`FlexType` = 1 AND `f`.`EndsOn` >= '$date' UNION SELECT `f`.*, `u`.*, (SELECT SUM(`j`.`Qty`) as Joiner from user_flexjoin j where j.Status = 1 AND j.FlexID = f.FlexID) As Joiner, (SELECT SUM(`j`.`FlexAmt`) as Amount from user_flexjoin j where j.Status = 1 AND j.FlexID = f.FlexID)As Amount, (SELECT COUNT(`c`.`CommentID`) from user_comment c where c.FlexID = f.FlexID) As Comments FROM `flex_mst` `f` JOIN `users` `u` ON `f`.`FlexUserID` = `u`.`id` WHERE `f`.`FlexType` = 2 AND `f`.`FlexID` IN (SELECT FlexID from flex_invitees WHERE InviteeID = '$id')  OR `f`.`FlexUserID` = '$id' AND `f`.`EndsOn` >= '$date' ORDER BY `EndsOn` ";
       $query = $this->db->query($final_query);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function clear_temp($id){
        $this->db->where('UserID', $id);
        $this->db->delete(TBL_TEMP_QUESTION); 
    }
    
    /*function get_paydtl($id){
        $this->db->select('*');
        $this->db->where('UserID',$id);
        $query = $this->db->get(TBL_PAYMENT_DTL);
        //return $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }*/
    
    function get_ACdtl($id){
        $this->db->select('ID');
        $this->db->where('UserID',$id);
        $query = $this->db->get(TBL_USER_ACCOUNT);
        //return $this->db->last_query();
        if ($query->num_rows() > 0) {
            return 1;
        }
        return 0;
    }
    
    function add_payment_dtl($data){
        $this->db->insert(TBL_PAYMENT_DTL, $data);
        return $this->db->insert_id();
    }
    
    function get_new_que($id){
        $this->db->select('*');
        $this->db->where('UserID',$id);
        $query = $this->db->get(TBL_TEMP_QUESTION);
        if ($query->num_rows() > 0) {
            /*$result = array();
            foreach($query->result() as $opt){
                if($opt->Qtype == 2){    
                    $option = explode(',', $query->row()->QOption);
                    $opt->options = $option;
                }
                $result[] = $opt;
            }
            return $result;*/
            return $query->result();
        }
        return NULL;
    }
    
   function get_ispay($id){
       $this->db->select('id');
        $this->db->where('id',$id);
        $this->db->where('isShowPay',1);
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return 1;
        }
        return 0;
   }
   
   function set_show_pay($id){
       $data = array("isShowPay" => 1);
       $this->db->where('id',$id);
       $this->db->update(TBL_USERS,$data);
   }
   
   function get_nofification($id){
       $this->db->select('*');
       $this->db->where('UserID',$id);
       $this->db->order_by("NotificationDate", "desc");
       $query = $this->db->get(TBL_NOTIFICATION);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
   }
   
   function get_noti_cnt($id){
       $this->db->select('NotificationID');
       $this->db->where('UserID',$id);
       $this->db->where('IsViewed',0);     
       $query = $this->db->get(TBL_NOTIFICATION);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return 0;
   }
   
   function update_noti($id){
       $ndata = array("IsViewed" => 1);
       $this->db->where('UserID',$id);    
       $this->db->update(TBL_NOTIFICATION,$ndata);
       return true;
   }
   
   
   function add_notification($data){
       $this->db->insert(TBL_NOTIFICATION, $data);
       //return $this->db->insert_id();
   }
   function get_flex_enddtl(){
       $curr_date = date('Y-m-d');
       $next_date = date('Y-m-d', strtotime($curr_date .' +1 day'));
       $this->db->select('FlexID,FlexUserID,FlexName,EndsOn');
       $this->db->where('date(EndsOn) = ',$next_date);
       $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
   }
   
   function get_flex_end(){
       $time1 = date('Y-m-d H:i:s');
       $time2 = date('Y-m-d H:i:s',strtotime('-1 hour'));    
       
       $this->db->select('FlexID,FlexUserID,FlexName,EndsOn');
       $this->db->where('EndsOn <= ',$time1);
       $this->db->where('EndsOn > ',$time2);
       $query = $this->db->get(TBL_FLEXMST);
       //echo $this->db->last_query().'<br/>';die;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
   }
   
   function get_payment_info($fid){
       $this->db->select('*');
       $this->db->where('FlexID',$fid);
       $query = $this->db->get(TBL_PAYMENT_INFO);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
   }
   
   function get_payamt_account($fid){
       $this->db->select('SUM(FlexAmt) as PayableAmt,FlexUserAccountID');
       $this->db->where('FlexID',$fid);
       $this->db->where('IsFlexActive',1);
       $query = $this->db->get(TBL_PAYMENT_INFO);
       //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
   }
   
   function add_transfer_data($data){
       $this->db->insert(TBL_TRANSFER_INFO, $data);
       return $this->db->insert_id();
   }
   
   function add_refund_data($data){
       $this->db->insert(TBL_REFUND_INFO, $data);
       return $this->db->insert_id();
   }
   
   function payment_done($fid){
       $ndata = array("IsFlexActive" => 0);
       $this->db->where('FlexID',$fid);    
       $this->db->update(TBL_PAYMENT_INFO,$ndata);
       return true;
   }
   
   function refund_done($fid){
       $ndata = array("Status" => 0);
       $this->db->where('FlexID',$fid);    
       $this->db->update(TBL_USER_FLEXJOIN,$ndata);
       return true;
   }
   
}
