<?php
class log_model extends CI_Model {
    function selectAllLogs(){
        $query = $this->db->order_by("timestamp", "desc")->get('logs');
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function insertLog($arrLog){
        $query = $this->db->insert('logs', $arrLog);

        return $this->db->insert_id();
    }
}

?>