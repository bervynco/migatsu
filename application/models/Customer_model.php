<?php
class customer_model extends CI_Model {
    function selectAllCustomers(){
        $query = $this->db->select(array('id', 'name', 'address', 'tin', 'phone_number'))->order_by("name", "asc")->get('customers');
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function insertCustomer($arrCustomerDetail){
        $query = $this->db->insert('customers', $arrCustomerDetail);

        return $this->db->insert_id();
    }

    function updateCustomer($arrCustomerDetail){
        $query = $this->db->where('id', $arrCustomerDetail['id'])
                          ->update(
                                'customers', 
                                array(
                                    'name'=> $arrCustomerDetail['name'], 
                                    'address' => $arrCustomerDetail['address'], 
                                    'tin' => $arrCustomerDetail['tin'],
                                    'phone_number' => $arrCustomerDetail['phone_number']
                                )
                            );
        return $this->db->affected_rows();
    }

    function deleteCustomer($arrCustomerDetail){
        $query = $this->db->where('id', $arrCustomerDetail['id'])->delete('customers');

        return $this->db->affected_rows();
    }
}
?>