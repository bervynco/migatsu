<?php
class report_model extends CI_Model {
    function selectReportData($name, $type, $param = null){
        if($name == 'users'){
            $query = $this->db->select(array('name', 'role'))->order_by("created_at", "asc");
        }
        else if($name == 'payables'){
            $query = $this->db->select(array('payables.*', 'suppliers.name'))->from('payables')
                           ->join('suppliers','suppliers.id = payables.supplier_id')
                           ->order_by('payables.due_date', 'desc');
        }
        else if($name == 'receivables'){
            $query = $this->db->select(array('receivables.*', 'customers.name'))->from('receivables')
                           ->join('customers','customers.id = receivables.customer_id')
                           ->order_by('customers.name', 'asc');
        }
        else if($name == 'inventory'){
            $query = $this->db->select(array('inventory.*', 'suppliers.name'))->from('inventory')
                           ->join('suppliers','suppliers.id = inventory.supplier_id')
                           ->order_by('product_id', 'asc');

        }
        else if($name == 'purchase_orders'){
            $query = $this->db->select(array('purchase_orders.*', 'customers.name'))
                          ->from('purchase_orders')->join('customers','customers.id = purchase_orders.customer_id')
                          ->order_by('customers.name', 'asc');
        }
        else {
            $query = $this->db->select("*")->order_by("created_at", "asc");
        }
        if($param != null){
            if($type == 'Current Month'){
                $query = $this->db->where('month('.$name.'.created_at)', $param);
            }
            else if($type == 'Current Year'){
                $query = $this->db->where('year('.$name.'.created_at)', $param);
            }
        }
        if($name == 'payables' || $name == 'receivables' || $name == 'inventory' || $name == 'purchase_orders'){
            $query = $this->db->get();
        }
        else{
            $query = $this->db->get($name);
        }
        
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }
}
?>