<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function add_notification($data){
       $this->db->insert(TBL_NOTIFICATION, $data);
   }
   
   function get_tokenid($id){
        $this->db->select('TokenID');
        $this->db->where('id', $id);
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->row()->TokenID;
        }
    }
    
    
    
}
?>