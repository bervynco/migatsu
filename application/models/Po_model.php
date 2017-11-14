<?php
class po_model extends CI_Model {
    function selectAllPurchaseOrders(){
        $query = $this->db->select(array('purchase_orders.*', 'customers.name'))
                          ->from('purchase_orders')->join('customers','customers.id = purchase_orders.customer_id')
                          ->order_by('customers.name', 'asc')->get();
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function insertLog($arrLog){
        $query = $this->db->insert('logs', $arrLog);

        return $this->db->insert_id();
    }
}

?>