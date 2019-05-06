<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->tableName = 'users';
	$this->primaryKey = 'id';
    }
    
    function user($id){
        $this->db->select('id,username,image');
        $this->db->where('id', $id);
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }
    
    function get_tokenid($id){
        $this->db->select('TokenID');
        $this->db->where('id', $id);
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->row()->TokenID;
        }
    }
    
    function get_user_email($id){
        $this->db->select('email');
        $this->db->where('id', $id);
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->row()->email;
        }
        return NULL;
    }
    
    function profile_dtl($id,$uid){
        $this->db->select('u.*,(SELECT SUM( j.FlexAmt ) AS TotalEarning FROM '.TBL_USER_FLEXJOIN.' j JOIN '.TBL_FLEXMST.' f ON f.FlexID = j.FlexID AND j.Status = 1 JOIN '.TBL_USERS.' u ON u.id = f.FlexUserID AND u.id ='.$id.') as TotalEarning,(SELECT Count(UserID) from '.TBL_USER_FOLLOWERS.' where UserID = '.$id.') as Followers ,(SELECT Count(FollowersID) from '.TBL_USER_FOLLOWERS.' where FollowersID = '.$id.') as Following, (SELECT count(FlexID) from '.TBL_FLEXMST.' where FlexUserID = '.$id.') as CreatFlex, (SELECT UserFollowersID from '.TBL_USER_FOLLOWERS.' where UserID = '.$id.' and FollowersID = '.$uid.') As IsFollow');
        $this->db->where('u.id',$id);
        $query = $this->db->get(TBL_USERS.' u');
        if ($query->num_rows() > 0) {
            
            if($query->row()->TotalEarning == null){
                $query->row()->TotalEarning = "0";
            }
            if($query->row()->IsFollow == null)
            {
                $query->row()->IsFollow = "0";
            }else{
                $query->row()->IsFollow = "1";
            }
            return $query->row();
        }
        return NULL;
    }
    
    function my_flex($id){
        $this->db->select('f.*,(SELECT SUM(`j`.`Qty`) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.Status = 1 AND j.FlexID = f.FlexID) As Joiner,(SELECT SUM(`j`.`FlexAmt`) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.Status = 1 AND j.FlexID = f.FlexID) As Amount,(SELECT COUNT(`c`.`CommentID`) from '.TBL_USER_COMMENTS.' c where c.FlexID = f.FlexID) As Comments');
        $this->db->where('f.FlexUserID',$id);
        $this->db->order_by("f.EndsOn", "desc");
        $query = $this->db->get(TBL_FLEXMST.' f');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function my_join($id){
        $this->db->select('f.*,j.*,(SELECT SUM(`j`.`Qty`) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.Status = "1" AND j.FlexID = f.FlexID) As Joiner,(SELECT SUM(`j`.`FlexAmt`) as Joiner from '.TBL_USER_FLEXJOIN.' j where j.Status = "1" AND j.FlexID = f.FlexID) As Amount,(SELECT COUNT(`c`.`CommentID`) from '.TBL_USER_COMMENTS.' c where c.FlexID = f.FlexID) As Comments');
        $this->db->join(TBL_USER_FLEXJOIN.' j', 'f.FlexID = j.FlexID');
        $this->db->where('j.UserID',$id);
        $this->db->where('j.Status',1);
        $this->db->order_by("f.EndsOn", "asc");
        $query = $this->db->get(TBL_FLEXMST.' f');
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function update_user($id,$data){
        $this->db->where('id',$id);
        $query = $this->db->update(TBL_USERS,$data);
        return true;
    }
    
    function get_user_all_paymentdtl($id){
        $this->db->select('*');
         $this->db->where('UserID', $id);
         $query = $this->db->get(TBL_PAYMENT_DTL);
         if ($query->num_rows() > 0) {
            return $query->result();
         }
         return NULL;
    }
    
    function del_paydtl($id){
        $this->db->select('*');
         $this->db->where('UserpaymentDtlID', $id);
         $query = $this->db->get(TBL_PAYMENT_DTL);
         if ($query->num_rows() > 0) {
             if($query->row()->isDefault == 1){
                 return 0;
             }else{
                $this->db->where('UserpaymentDtlID',$id);
                $query = $this->db->delete(TBL_PAYMENT_DTL);
                return 1;
             }
         }
        
    }
    
    function set_defult_payment($id,$uid){
        $data = array("isDefault" => 0);
        $this->db->where('UserID',$uid);    
        $this->db->update(TBL_PAYMENT_DTL,$data);
        
        $ndata = array("isDefault" => 1);
        $this->db->where('UserpaymentDtlID',$id);    
        $this->db->update(TBL_PAYMENT_DTL,$ndata);
        return true;
    }
    
    function user_act_dtl($id){
        
        $final_query ="(SELECT f.FlexName, u.username, f.CreatedOn,f.FlexImageURL,'Create' as act_type FROM flex_mst f JOIN ".TBL_USERS." u ON f.FlexUserID = u.id WHERE u.id = ".$id." ORDER by f.FlexID desc) union all (SELECT f.FlexName, u.username, uf.CreatedOn, f.FlexImageURL,'Join' as act_type FROM user_flexjoin uf JOIN ".TBL_USERS." u ON uf.UserID = u.id join flex_mst f ON uf.FlexID = f.FlexID WHERE u.id = ".$id." ORDER BY uf.UserFlexID desc) UNION all (SELECT f.FlexName, u.username, uc.CreatedOn, f.FlexImageURL,'Comment' as act_type FROM user_comment uc JOIN ".TBL_USERS." u ON uc.UserID = u.id join flex_mst f ON uc.FlexID = f.FlexID WHERE u.id = ".$id.") ORDER BY `CreatedOn` DESC";
        $query = $this->db->query($final_query);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function web_follow_user($data){
        $this->db->select('UserFollowersID as Id');
        $this->db->where('UserID', $data['UserID']);
        $this->db->where('FollowersID', $data['FollowersID']);
        $query = $this->db->get(TBL_USER_FOLLOWERS);
        if ($query->num_rows() > 0) {
            foreach($query->result() as $row){
                $this->db->where('UserFollowersID', $row->Id);
                $this->db->delete(TBL_USER_FOLLOWERS);
                return ;
            }
        }else{
            $this->db->insert(TBL_USER_FOLLOWERS, $data);
            return $this->db->insert_id();
        }    
    }
    
    function add_account_dtl($data){
        $this->db->insert(TBL_USER_ACCOUNT, $data);
        return $this->db->insert_id();
    }
    
    function get_follow_cnt($id){
        $final_query = "SELECT Count(UserID) as Followers from ".TBL_USER_FOLLOWERS." where UserID = ".$id;
        $query = $this->db->query($final_query);
        if ($query->num_rows() > 0) {
            return $query->row()->Followers;
        }
        return NULL;
    }
	
	function get_user_follower($id){
        $this->db->select('f.*, u.id,u.username,, u.image');
        $this->db->join(TBL_USERS.' u', 'f.FollowersID = u.id');
        $this->db->where('f.UserID', $id);
        $this->db->order_by("f.CreatedOn", "desc");
        $query = $this->db->get(TBL_USER_FOLLOWERS.' f');
        if ($query->num_rows() > 0) {
            $result = array();

            foreach($query->result() as $single){
                $single->IsFollow = $this->get_is_follow($single->FollowersID,$id);
                $result[] = $single;
            }
            return $result;
        }
        return NULL;
	}
        
        function get_is_follow($fid,$uid){
            $this->db->select('UserFollowersID');
            $this->db->where('UserID', $fid);
            $this->db->where('FollowersID', $uid);
            $query = $this->db->get(TBL_USER_FOLLOWERS);
            if ($query->num_rows() > 0) {
                return 1;
            }else{
                return 0;
            }    
        }
	
	function get_user_following($id){
         $this->db->select('f.*, u.id,u.username,, u.image');
        $this->db->join(TBL_USERS.' u', 'f.UserID = u.id');
        $this->db->where('f.FollowersID', $id);
        $this->db->order_by("f.CreatedOn", "desc");
        $query = $this->db->get(TBL_USER_FOLLOWERS.' f');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
	}
        
    function get_user($id){
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where('id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }
    
    function checkUser($data = array()){
        
        $this->db->select($this->primaryKey);
        $this->db->from($this->tableName);
        $this->db->where(array('oauth_uid'=>$data['oauth_uid']));
        $query = $this->db->get();
        $check = $query->num_rows();

        if($check > 0){
                $result = $query->row_array();
                $data['modified'] = date("Y-m-d H:i:s");
                $update = $this->db->update($this->tableName,$data,array('id'=>$result['id']));
                $userID = $result['id'];
        }else{
                $data['created'] = date("Y-m-d H:i:s");
                $data['modified'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert($this->tableName,$data);
                $userID = $this->db->insert_id();
        }
        return $userID;
    }
    
    function get_account_details($id){
        $this->db->select('*');
         $this->db->where('UserID', $id);
         $query = $this->db->get(TBL_USER_ACCOUNT);
         if ($query->num_rows() > 0) {
            return $query->row();
         }
         return NULL;
    }
    
    function get_money_out($id){
        $this->db->select('FlexID,UserID,JoinDate,FlexAmt,TxAmt,Qty,TransactionID,Status');
        $this->db->where('UserID', $id);
        $this->db->order_by("JoinDate", "desc");
        $query = $this->db->get(TBL_USER_FLEXJOIN);
        if ($query->num_rows() > 0) {
            $result = array();
            foreach($query->result() as $row){
                $row->FlexName = $this->get_flexname($row->FlexID);
                $row->Image = $this->get_fleximage($row->FlexID);
                $result[] = $row;
            }
            return $result;
        }
        return NULL;
    }
    
    function get_money_in($id){
        $this->db->select('FlexID');
        $this->db->where('FlexUserID', $id);
        $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
            
            $result = array();
            foreach($query->result() as $row){
                $new = $this->money_in_dtl($row->FlexID);
                foreach($new as $single){
                    $result[] = $single;
                }
            }
            usort($result, "cmp");
            return $result;
        }
        return NULL;
    }    
    
    function money_in_dtl($id){
        $this->db->select('FlexID,UserID,JoinDate,FlexAmt,Qty,TransactionID,Status');
        $this->db->where('FlexID', $id);
        $this->db->order_by("JoinDate", "desc");
        $query = $this->db->get(TBL_USER_FLEXJOIN);
        if ($query->num_rows() > 0) {
            $result = array();
            foreach($query->result() as $row){
                $row->FlexName = $this->get_flexname($row->FlexID);
                $row->Image = $this->get_fleximage($row->FlexID);
                $result[] = $row;
            }
            return $result;
        }
        return NULL;
    }
    
    function get_flexname($id){
        $this->db->select('FlexName');
        $this->db->where('FlexID', $id);
        $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
           return $query->row()->FlexName;
        }
    }
    
    function get_fleximage($id){
        $this->db->select('FlexImageURL');
        $this->db->where('FlexID', $id);
        $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
           return $query->row()->FlexImageURL;
        }
    }
    
    function get_money($id){
        $row[0] = $this->get_money_in($id);
        $row[1] = $this->get_money_out($id);
        $new = $row;
        foreach($new[0] as $single){
            $single->type = 1;
            $result[] = $single;
        }
        foreach($new[1] as $single){
            $single->type = 2;
            $result[] = $single;
        }
        
       usort($result, "cmp");
    
       return $result;
    }
    
    function get_joindtl($id){
        $this->db->select('*');
        $this->db->where('UserFlexID', $id);
        $query = $this->db->get(TBL_USER_FLEXJOIN);
        if ($query->num_rows() > 0) {
           return $query->row();
        }
    }
    
    function add_refund_request($data){
        $this->db->select('JoinID');
        $this->db->where('JoinID', $data['JoinID']);
        $query = $this->db->get(TBL_REFUND_REQUEST);
        if ($query->num_rows() > 0) {
            $ndata = array("Status" => 0);
            $this->db->where('JoinID',$data['JoinID']);    
            $this->db->update(TBL_REFUND_REQUEST,$ndata);
            return TRUE;
        }else{
            $this->db->insert(TBL_REFUND_REQUEST, $data);
            return $this->db->insert_id();
        }    
    }
    
    function add_money_request($data){
        $this->db->insert(TBL_MONEY_REQUEST, $data);
        return $this->db->insert_id();
    }
    
    function get_userid_byflex($id){
        $this->db->select('FlexUserID');
        $this->db->where('FlexID', $id);
        $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
           return $query->row()->FlexUserID;
        }
    }

}