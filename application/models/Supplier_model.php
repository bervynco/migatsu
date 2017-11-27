<?php
class supplier_model extends CI_Model {
    function selectAllSuppliers(){
        $query = $this->db->select(array('id', 'name', 'address', 'tin', 'phone_number'))->order_by("name", "asc")->get('suppliers');
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function insertSupplier($arrSupplierDetail){
        $query = $this->db->insert('suppliers', $arrSupplierDetail);

        return $this->db->insert_id();
    }

    function updateSupplier($arrSupplierDetail){ 
        $query = $this->db->where('id', $arrSupplierDetail['id'])
                          ->update(
                                'suppliers', 
                                array(
                                    'name'=> $arrSupplierDetail['name'], 
                                    'address' => $arrSupplierDetail['address'], 
                                    'tin' => $arrSupplierDetail['tin'],
                                    'phone_number' => $arrSupplierDetail['phone_number']
                                )
                            );
        return $this->db->affected_rows();
    }

    function deleteSupplier($arrSupplierDetail){
        $query = $this->db->where('id', $arrSupplierDetail['id'])->delete('suppliers');

        return $this->db->affected_rows();
    }
}
?>