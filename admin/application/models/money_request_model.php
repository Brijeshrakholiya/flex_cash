<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Money_request_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_requestdtl($rid){
        $this->db->select('m.MoneyReqID,m.UserID,m.FlexID,m.AccountID,DATE_FORMAT(m.RequestDate, "%d %b %Y") as RequestDate,m.Status,DATE_FORMAT(m.ModifiedOn, "%d %b %Y") as ModifiedOn,u.username,f.FlexName');
        $this->db->where('m.MoneyReqID', $rid)
             ->join(TBL_USERS.' u', 'm.UserID = u.id')
             ->join(TBL_FLEXMST.' f', 'm.FlexID = f.FlexID');
        $query = $this->db->get(TBL_MONEY_REQUEST.' m');
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    function get_transferable_money($fid){
        $this->db->select('SUM(FlexAmt) as PayableAmt');
       $this->db->where('FlexID',$fid);
       $this->db->where('IsFlexActive',1);
       $query = $this->db->get(TBL_PAYMENT_INFO);
       //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row()->PayableAmt;
        }
        return NULL;
    }
    
    function add_transfer_data($data){
       $this->db->insert(TBL_TRANSFER_INFO, $data);
       return $this->db->insert_id();
    }
    
    function update_money_request($rid,$type,$id){
        $date = date('Y-m-d H:i:s');
        $ndata = array("Status" => $type,"TransferID"=>$id,"ModifiedOn" => $date);
        $this->db->where('MoneyReqID',$rid);    
        $this->db->update(TBL_MONEY_REQUEST,$ndata);
        return true;
    }
    
    function transfer_done($fid){
       $ndata = array("IsFlexActive" => 0);
       $this->db->where('FlexID',$fid);    
       $this->db->update(TBL_PAYMENT_INFO,$ndata);
       return true;
    }
}    