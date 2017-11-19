<?php
class outbound_model extends CI_Model {
    function selectToday($today, $nextDate){
        $query = $this->db->select(array('purchase_orders.*', 'customers.name'))
                          ->from('purchase_orders')->join('customers','customers.id = purchase_orders.customer_id')
                          ->where('purchase_orders.promised_delivery_date >=', $today)
                          ->where('purchase_orders.promised_delivery_date <', $nextDate)
                          ->order_by('customers.name', 'asc')->get();
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }
    function selectAllOutboundDelivery(){
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