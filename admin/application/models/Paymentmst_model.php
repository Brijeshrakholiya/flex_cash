<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paymentmst_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_pay($id) {
        $this->db->select('*');
        $this->db->where('UserpaymentMstID', $id);

        $query = $this->db->get(TBL_PAYMENT_MST);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    function get_dtl($id) {
        $this->db->select('*');
        $this->db->where('UserpaymentMstID', $id);

        $query = $this->db->get(TBL_PAYMENT_DTL);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    
    
    function remove($id) {
        $this->db->where('UserpaymentMstID', $id);
        $this->db->delete(TBL_PAYMENT_MST);

        return $id;
    }
}
?>