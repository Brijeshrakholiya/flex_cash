<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Refundmst_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_requestdtl($rid){
        $this->db->select('r.RequestID,r.JoinID,r.UserID,r.FlexID,r.TransactionID,DATE_FORMAT(r.RequestDate, "%d %b %Y") as RequestDate,r.Status,DATE_FORMAT(r.ModifiedOn, "%d %b %Y") as ModifiedOn,u.username,f.FlexName');
        $this->db->where('r.RequestID', $rid)
             ->join(TBL_USERS.' u', 'r.UserID = u.id')
             ->join(TBL_FLEXMST.' f', 'r.FlexID = f.FlexID');
        $query = $this->db->get(TBL_REFUND_REQUEST.' r');
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    function get_joindtl($jid){
        $this->db->select('DATE_FORMAT(JoinDate, "%d %b %Y") as JoinDate,TxAmt,Qty');
        $this->db->where('UserFlexID', $jid);
        $query = $this->db->get(TBL_USER_FLEXJOIN);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    function update_refund_request($rid,$type,$id){
        $date = date('Y-m-d H:i:s');
        $ndata = array("Status" => $type,"RefundID"=>$id,"ModifiedOn" => $date);
        $this->db->where('RequestID',$rid);    
        $this->db->update(TBL_REFUND_REQUEST,$ndata);
        return true;
    }
    
    function add_refund_data($data){
       $this->db->insert(TBL_REFUND_INFO, $data);
       return $this->db->insert_id();
   }
   
   function refund_done($jid){
       $ndata = array("Status" => 0);
       $this->db->where('UserFlexID',$jid);    
       $this->db->update(TBL_USER_FLEXJOIN,$ndata);
       return true;
   }
}    