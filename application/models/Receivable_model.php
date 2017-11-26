<?php
class receivable_model extends CI_Model {
    function selectToday($today, $nextDate){
        $query = $this->db->select(array('receivables.*', 'customers.name'))->from('receivables')
                           ->join('customers','customers.id = receivables.customer_id')
                           ->where('receivables.due_date >=', $today)
                           ->where('receivables.due_date <', $nextDate)
                           ->where('done =', 0)
                           ->order_by('customers.name', 'asc')->get();
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }
    function selectAllReceivable(){

        $query = $this->db->select(array('receivables.*', 'customers.name'))->from('receivables')
                           ->join('customers','customers.id = receivables.customer_id')
                           ->where('receivables.done =', 0)
                           ->order_by('customers.name', 'asc')->get();
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function insertReceivable($arrReceivableDetail){
        $query = $this->db->insert('receivables', $arrReceivableDetail);

        return $this->db->insert_id();
    }

    function updateReceivable($arrReceivableDetail){
        $query = $this->db->where('id', $arrReceivableDetail['id'])
                          ->update(
                                'receivables', 
                                array(
                                    'customer_id'=> $arrReceivableDetail['customer_id'], 
                                    'po_id' => $arrReceivableDetail['po_id'], 
                                    'delivery_date' => $arrReceivableDetail['delivery_date'],
                                    'invoice_id' => $arrReceivableDetail['invoice_id'],
                                    'terms' => $arrReceivableDetail['terms'],
                                    'remarks' => $arrReceivableDetail['remarks']
                                )
                            );
        return $this->db->affected_rows();
    }

    function deleteReceivable($arrReceivableDetail){
        $query = $this->db->where('id', $arrReceivableDetail['id'])->delete('receivables');

        return $this->db->affected_rows();
    }

    function toggleReceivableDone($arrReceivableDetail){
        $query = $this->db->where('id', $arrReceivableDetail['id'])
                          ->update(
                                'receivables', 
                                array(
                                    'done'=> 1
                                )
                            );
        return $this->db->affected_rows();
    }
}
?>