<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Appuser_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_user($id) {
        $this->db->select('*');
        $this->db->where('id', $id);

        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete(TBL_USERS);

        return $id;
    }
    
    function get_payment($id){
        $this->db->select('*');
        $this->db->where('UserID', $id);
        //$this->db->where('IsDefault', 1);
        $query = $this->db->get(TBL_PAYMENT_DTL);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function user_activation($id,$val){
        if($val == 1){
            $this->db->set('activated', 2);
        }
        else{
             $this->db->set('activated', 1);
        }
        $this->db->where('id', $id); 
        $this->db->update(TBL_USERS); 
    }
}
?>