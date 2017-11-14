<?php
class payable_model extends CI_Model {
    function selectAllPayable(){

        $query = $this->db->select(array('payables.*', 'suppliers.name'))->from('payables')
                           ->join('suppliers','suppliers.id = payables.supplier_id')->order_by('suppliers.name', 'asc')->get();
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function insertPayable($arrPayableDetail){
        $query = $this->db->insert('payables', $arrPayableDetail);

        return $this->db->insert_id();
    }

    function updatePayable($arrPayableDetail){
        $query = $this->db->where('id', $arrPayableDetail['id'])
                          ->update(
                                'payables', 
                                array(
                                    'supplier_id'=> $arrPayableDetail['supplier_id'], 
                                    'po_id' => $arrPayableDetail['po_id'], 
                                    'delivery_date' => $arrPayableDetail['delivery_date'],
                                    'supplier_dr_id' => $arrPayableDetail['supplier_dr_id'],
                                    'terms' => $arrPayableDetail['terms'],
                                    'remarks' => $arrPayableDetail['remarks'],
                                )
                            );
        return $this->db->affected_rows();
    }

    function deletePayable($arrPayableDetail){
        $query = $this->db->where('id', $arrPayableDetail['id'])->delete('payables');

        return $this->db->affected_rows();
    }
}
?>