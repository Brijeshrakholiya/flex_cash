<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paymentdtl_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function remove($id) {
        $this->db->where('UserpaymentDtlID', $id);
        $this->db->delete(TBL_PAYMENT_DTL);

        return $id;
    }
}
?>