<?php
class report_model extends CI_Model {
    function selectReportData($name, $type, $param = null){
        if($name == 'users'){
            $queryParams = array('name', 'role');
        }
        else{
            $queryParams = "*";
        }
        $query = $this->db->select($queryParams)->order_by("created_at", "asc");
        if($param != null){
            if($type == 'Current Month'){
                $query = $this->db->where('month(created_at)', $param);
            }
            else if($type == 'Current Year'){
                $query = $this->db->where('year(created_at)', $param);
            }
        }
        $query = $this->db->get($name);
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }
}
?>