<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Flexmst_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function add_flex($data) {
        $this->db->insert(TBL_FLEXMST, $data);
        return $this->db->insert_id();
    }
    
    function update_flex($data, $id) {
        $this->db->where('FlexID', $id);
        $this->db->update(TBL_FLEXMST, $data);
        return $id;
    }
    
    function get_flex($id) {
        $this->db->select('*');
        $this->db->where('FlexID', $id);

        $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    function remove($id) {
        $this->db->where('FlexID', $id);
        $this->db->delete(TBL_FLEXMST);

        return $id;
    }
    
    function get_question($id){
        $this->db->select('*');
        $this->db->where('FlexID', $id);
        $this->db->order_by("Qorder", "asc");
        $query = $this->db->get(TBL_FLEX_QUESTION);
        if ($query->num_rows() > 0) {
            
            return $query->result();
        }
        return NULL;
    }
    
    function get_flexname($id){
        $this->db->select('FlexName');
        $this->db->where('FlexID', $id);

        $query = $this->db->get(TBL_FLEXMST);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    function get_flex_joiner($id){
        $this->db->select('j.*,u.*');
        $this->db->where('j.FlexID', $id)
             ->join(TBL_USERS.' u', 'j.UserID = u.id');
        $this->db->order_by("j.JoinDate", "asc");
        $query = $this->db->get(TBL_USER_FLEXJOIN.' j');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_flex_joinerdtl($id,$uid){
        $this->db->select('j.*,u.*,d.*');
        $this->db->where('j.FlexID', $id)
             ->where('j.UserID', $uid)
             ->join(TBL_USERS.' u', 'j.UserID = u.id')
             ->join(TBL_PAYMENT_DTL.' d', 'j.UserPaymentDtlID = d.UserpaymentDtlID');
        $this->db->order_by("j.JoinDate", "asc");
        $query = $this->db->get(TBL_USER_FLEXJOIN.' j');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function flex_joiner_count($id){
        $this->db->select('SUM("jo.Qty")');
        $this->db->where('jo.FlexID', $id);
        $query = $this->db->get(TBL_USER_FLEXJOIN.' jo');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_user_comment($id){
        $this->db->select('c.*,u.*');
        $this->db->where('c.FlexID', $id)
             ->join(TBL_USERS.' u', 'c.UserID = u.id');
        $this->db->order_by("c.CommentDate", "asc");
        $query = $this->db->get(TBL_USER_COMMENTS.' c');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_user_invitee($id){
        //SELECT fi.*,(u.username) as InviteBy ,(us.username) as Invitee FROM `flex_invitees` as fi LEFT JOIN users as u on fi.InviteByID=u.id LEFT JOIN users as us on fi.InviteeID=us.id
                
        $this->db->select('fi.*,(u.username) as InviteBy ,(us.username) as Invitee');  
        $this->db->where('fi.FlexID', $id)
             ->join(TBL_USERS.' u', 'fi.InviteByID = u.id')
             ->join(TBL_USERS.' us', 'fi.InviteeID = us.id');
        $this->db->order_by("fi.InvitationDate", "asc");
        $query = $this->db->get(TBL_FLEX_INVITEES.' fi');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
}
?>