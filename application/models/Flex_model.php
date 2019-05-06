<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Flex_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function flex($fid){
        $this->db->select('f.FlexID,f.FlexUserID,f.FlexName,f.FlexImageURL,f.GoalQty,(SELECT IFNULL(SUM(`j`.`Qty`),0) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.Status = 1 AND j.FlexID = f.FlexID) As Joiner');
        $this->db->where('FlexID', $fid);
        $query = $this->db->get(TBL_FLEXMST.' f');
        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }
    
    function get_flexamt($fid){
        $this->db->select('Amount');
        $this->db->where('FlexID', $fid);
        $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
            return $query->row()->Amount;
        }
    }
    
    function add_temp_question($data){
        $this->db->insert(TBL_TEMP_QUESTION, $data);
        return $this->db->insert_id();
    }
    
    function add_question($id,$uid){
        $this->db->select('*');
        $this->db->where('UserID', $uid);
        $query = $this->db->get(TBL_TEMP_QUESTION);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)
            {
                $data['FlexID'] = $id;  
                $data['Qtype'] = $row->Qtype;
                $data['QuestionText'] = $row->Question;
                $data['Qorder'] = $row->Qorder;
                $data['isRequired'] = $row->isRequired;
                $data['CreatedBy'] = $uid;
                $data['CreatedOn'] = date("Y-m-d H:i:s");
                $QID = $this->insert_question($data);
                $odata['FlexQueID'] = $QID; 
                $odata['FlexOption'] = $row->QOption; 
                $odata['OptOrder'] = $row->Oorder;
                $odata['CreatedBy'] = $uid; 
                $odata['CreatedOn'] = date("Y-m-d H:i:s");
                if($row->Qtype == 2){
                    $OID = $this->insert_option($odata);
                }
            }
        }
    }
    
    function insert_question($data){
        $this->db->insert(TBL_FLEX_QUESTION, $data);
        return $this->db->insert_id();
    }
    
    function insert_option($data){
        $flex_option = explode(',',$data['FlexOption']);
        $opt_order = explode(',',$data['OptOrder']);
        $qid = $data['FlexQueID'];
        $uid = $data['CreatedBy'];
        $date = $data['CreatedOn'];
        $opt_with_order = array_combine($flex_option, $opt_order);
        
        //foreach ($opt_with_order as $opt => $ord){
        $cnt = 1;
        foreach ($flex_option as $opt){
            $opt_data['FlexQueID'] = $qid;
            $opt_data['FlexOption'] = $opt;
            $opt_data['OptOrder'] = $cnt;
            $opt_data['CreatedBy'] = $uid;
            $opt_data['CreatedOn'] = $date;
            
            $this->db->insert(TBL_FLEX_OPTION, $opt_data);
            //return $this->db->insert_id();
            $cnt++;
        }
    }
    
    function get_flex_details($id){
        $this->db->select('f.*,u.*,(SELECT SUM(`j`.`Qty`) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.Status = 1 AND j.FlexID = f.FlexID) As Joiner,(SELECT SUM(`j`.`FlexAmt`) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.Status = 1 AND j.FlexID = f.FlexID) As TotalAmount,(SELECT COUNT(`c`.`CommentID`) from '.TBL_USER_COMMENTS.' c where c.FlexID = f.FlexID) As Comments');
        //$this->db->where('f.Status', 1)
        $this->db->join(TBL_USERS.' u', 'f.FlexUserID = u.id');
        $this->db->where('f.FlexID', $id);
        $query = $this->db->get(TBL_FLEXMST.' f');
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    function get_flex_comments($id){
        $this->db->select('c.*,u.*');
        $this->db->where('c.FlexID', $id)
             ->join(TBL_USERS.' u', 'c.UserID = u.id');
        $this->db->order_by("c.CommentDate", "desc");
        $query = $this->db->get(TBL_USER_COMMENTS.' c');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_flex_joindtl($id){
        $this->db->select('FlexID,FlexName,FlexCat,AmountType,Amount,MaxQty,(SELECT IFNULL(SUM(`j`.`Qty`),0) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.Status = 1 AND j.FlexID = '.$id.') As Joiner');
        $this->db->where('FlexID', $id);
        $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    function get_question($id){
        $this->db->select('*');
        $this->db->where('FlexID', $id);
        $this->db->order_by("Qorder", "asc");
        $query = $this->db->get(TBL_FLEX_QUESTION);
        if ($query->num_rows() > 0) {
            $cnt = 1;
            foreach($query->result() as $row){
                $result[$cnt] = $row;
                if($row->Qtype == 2){
                    $option = $this->get_option($row->FlexQID);
                    $result[$cnt]->sub = $option;
                }
                $cnt++;
            }
            return $result;
        }
        return NULL;
    }
    
    function get_option($id){
         $this->db->select('*');
         $this->db->where('FlexQueID', $id);
         $this->db->order_by("OptOrder", "asc");
         $query = $this->db->get(TBL_FLEX_OPTION);
         if ($query->num_rows() > 0) {
            return $query->result();
         }
         return NULL; 
    }
    
    function get_user_paymentdtl($id){
        $this->db->select('*');
         $this->db->where('UserID', $id);
         $this->db->where('IsDefault', 1);
         $this->db->where('PayType!=',1);
         $query = $this->db->get(TBL_PAYMENT_DTL);
         if ($query->num_rows() > 0) {
            return $query->row();
         }
         return NULL; 
    }
    
    function add_new_paydtl($id,$row){
        if($row['isDefault'] == 1){
            $data = array("isDefault" => 0);
            $this->db->where('UserID',$id);    
            $this->db->update(TBL_PAYMENT_DTL,$data);
        }
        $this->db->insert(TBL_PAYMENT_DTL, $row);
        return $this->db->insert_id();
    }
    
    function add_comment($data){
        $this->db->insert(TBL_USER_COMMENTS, $data);
        return $this->db->insert_id();
    }
    
    function add_que_ans($data){
        $this->db->insert(TBL_USER_FLEXQUESTION, $data);
        return $this->db->insert_id();
    }
    
    function add_user_join($data){
        $this->db->insert(TBL_USER_FLEXJOIN, $data);
        return $this->db->insert_id();
    }
    
    function get_user_join($id){
        $this->db->select('j.*,u.*');
        $this->db->where('j.FlexID', $id);
        $this->db->where('j.Status', 1)
             ->join(TBL_USERS.' u', 'j.UserID = u.id');
        $this->db->order_by("j.JoinDate", "desc");
        $query = $this->db->get(TBL_USER_FLEXJOIN.' j');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_user_invitee($id){
        $this->db->select('i.*,u.*');
        $this->db->where('i.FlexID', $id)
             ->join(TBL_USERS.' u', 'i.InviteeID = u.id');
        $this->db->order_by("i.InvitationDate", "desc");
        $query = $this->db->get(TBL_FLEX_INVITEES.' i');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function del_que($id){
        $this->db->where('QID',$id);
        $query = $this->db->delete(TBL_TEMP_QUESTION);
        return true;
    }
    
    function get_card_no($type,$uid){
        $this->db->select('CardNo');
        $this->db->where('UserID', $uid);
        $this->db->where('PayType', $type);
        $query = $this->db->get(TBL_PAYMENT_DTL);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_ex_date($no,$uid){
        $this->db->select('UserpaymentDtlID,ExpiryMonth,ExpiryYear');
        $this->db->where('UserID', $uid);
        $this->db->where('CardNo', $no);
        $query = $this->db->get(TBL_PAYMENT_DTL);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_flex_userid($id){
        $this->db->select('FlexUserID');
        $this->db->where('FlexID', $id);
        $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
            return $query->row()->FlexUserID;
        }
        return NULL;
    }
    
    function get_stripe_account($id){
        $this->db->select('StripeAcID');
        $this->db->where('UserID', $id);
        $query = $this->db->get(TBL_USER_ACCOUNT);
        if ($query->num_rows() > 0) {
            return $query->row()->StripeAcID;
        }
        return NULL;
    }
    
    function invite_user($id,$fid){
        $final_query ="SELECT `u`.* FROM `users` `u` WHERE (`id` IN (SELECT DISTINCT f.UserID FROM user_followers f WHERE `f`.`FollowersID` = $id ) OR `id` IN (SELECT DISTINCT f.FollowersID FROM user_followers f WHERE `f`.`UserID` = $id )) AND `id` NOT IN (SELECT UserID from user_flexjoin where FlexID = $fid) ORDER BY username ASC";
        $query = $this->db->query($final_query);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function add_invite_user($data){
        $this->db->select('FlexInviteeID');
        $this->db->where('FlexID', $data['FlexID']);
        $this->db->where('InviteeID', $data['InviteeID']);
        $this->db->where('InviteByID', $data['InviteByID']);
        $query = $this->db->get(TBL_FLEX_INVITEES);
        if ($query->num_rows() > 0) {
            return;
        }else{
            $this->db->insert(TBL_FLEX_INVITEES, $data);
            return $this->db->insert_id();
        }    
    }
    
    function get_joiner_dtl($id){
        $user_url = IMG_URL.USER_IMG_THUMB_PATH;
        $this->db->select('j.FlexID,j.UserID,DATE_FORMAT(j.JoinDate,"%d %b %Y")as JoinDate,j.FlexAmt,j.Qty,u.username,CONCAT("'.$user_url.'",u.image)as UserImage');
        $this->db->where('j.UserFlexID', $id)
             ->join(TBL_USERS.' u', 'j.UserID = u.id');
        $query = $this->db->get(TBL_USER_FLEXJOIN.' j');
        if ($query->num_rows() > 0) {
            
            return $query->row();
        }
        return NULL;
    }
    
    function get_que_ans($id){
        $this->db->select('*');
        $this->db->where('JoinID', $id);
        $query = $this->db->get(TBL_USER_FLEXQUESTION);
        if ($query->num_rows() > 0) {
            $result = array();
            foreach($query->result() as $single){
                $single->Question = $this->get_question_byid($single->FlexQID);
                if($single->Answer == ''){
                    $single->Answer = $this->get_option_byid($single->FlexOID);
                }    
                $result[] = $single;
            }
            return $result;
        }
        return NULL;
    }
    
    function get_question_byid($id){
        $this->db->select('QuestionText');
        $this->db->where('FlexQID', $id);
        $query = $this->db->get(TBL_FLEX_QUESTION);
        if ($query->num_rows() > 0) {
            return $query->row()->QuestionText;
        }
    }
    
    function get_option_byid($id){
        $this->db->select('FlexOption');
        $this->db->where('FlexOptID', $id);
        $query = $this->db->get(TBL_FLEX_OPTION);
        if ($query->num_rows() > 0) {
            return $query->row()->FlexOption;
        }
    }
    
    function join_follow_user($data){
        $this->db->select('UserFollowersID as Id');
        $this->db->where('UserID', $data['UserID']);
        $this->db->where('FollowersID', $data['FollowersID']);
        $query = $this->db->get(TBL_USER_FOLLOWERS);
        if ($query->num_rows() > 0) {
            return ;
        }else{
            $this->db->insert(TBL_USER_FOLLOWERS, $data);
            return $this->db->insert_id();
        }  
    }
    
    function add_pay_data($data){
        $this->db->insert(TBL_PAYMENT_INFO, $data);
        return $this->db->insert_id();
    }
    
    function is_goal_reached($fid){
        $this->db->select('GoalQty');
        $this->db->where('FlexID', $fid);
        $query1 = $this->db->get(TBL_FLEXMST);
        $Goal = $query1->row()->GoalQty;
        
        $this->db->select('count(UserFlexID) as Joiner');
        $this->db->where('Status', 1);
        $this->db->where('FlexID', $fid);
        $query2 = $this->db->get(TBL_USER_FLEXJOIN);
        $Joiner = $query2->row()->Joiner; 
        if($Goal <= $Joiner){
            $result = array('Status' => 1,'Joiner'=>$Joiner);
        }else{
            $result = array('Status' => 0,'Joiner'=>$Joiner);
        }
        return $result;
    }
    
    function is_chargeable($fid){
        $this->db->select('isCharged');
        $this->db->where('FlexID', $fid);
        $query = $this->db->get(TBL_FLEXMST);
        return $query->row()->isCharged;
    }
   
}   