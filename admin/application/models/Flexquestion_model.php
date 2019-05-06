<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Flexquestion_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function add_flex($data) {
        $this->db->insert(TBL_FLEX_QUESTION, $data);
        return $this->db->insert_id();
    }
    
    function update_flex($data, $id) {
        $this->db->where('FlexQID', $id);
        $this->db->update(TBL_FLEX_QUESTION, $data);
        return $id;
    }
    
    function get_flex($id) {
        $this->db->select('*');
        $this->db->where('FlexQID', $id);

        $query = $this->db->get(TBL_FLEX_QUESTION);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_opt($id){
         $this->db->select('*');
         $this->db->where('FlexQueID', $id);
         $this->db->order_by("OptOrder", "asc");
         $query = $this->db->get(TBL_FLEX_OPTION);
         if ($query->num_rows() > 0) {
            
            return $query->result();
         }
         return NULL; 
    }
    
    function remove($id) {
        $this->db->where('FlexQID', $id);
        $this->db->delete(TBL_FLEX_QUESTION);

        return $id;
    }
}
?>