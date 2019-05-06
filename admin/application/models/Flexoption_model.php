<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Flexoption_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function add_flex($data) {
        $this->db->insert(TBL_FLEX_OPTION, $data);
        return $this->db->insert_id();
    }
    
    function update_flex($data, $id) {
        $this->db->where('FlexOptID', $id);
        $this->db->update(TBL_FLEX_OPTION, $data);
        return $id;
    }
    
    function get_flex($id) {
        $this->db->select('*');
        $this->db->where('FlexOptID', $id);

        $query = $this->db->get(TBL_FLEX_OPTION);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return NULL;
    }
    
    function remove($id) {
        $this->db->where('FlexOptID', $id);
        $this->db->delete('flex_option');

        return $id;
    }
}
?>