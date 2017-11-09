<?php
    class log_model extends CI_Model {
        function selectAllLogs(){
            $query = $this->db->get('logs');
            return($query->num_rows() > 0) ? $query->result_array(): array();
        }
    }

?>