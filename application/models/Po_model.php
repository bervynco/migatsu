<?php
class po_model extends CI_Model {
    function selectToday($today, $nextDate){
        $query = $this->db->select(array('purchase_orders.*', 'customers.name'))
                          ->from('purchase_orders')->join('customers','customers.id = purchase_orders.customer_id')
                          ->where('purchase_orders.promised_delivery_date >=', $today)
                          ->where('purchase_orders.promised_delivery_date <', $nextDate)
                          ->where('purchase_orders.done =', 0)
                          ->order_by('customers.name', 'asc')->get();
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function selectPurchaseOrderItem($id){
        $query = $this->db->select(array('purchase_orders.*', 'customers.name'))->from('purchase_orders')
                           ->join('customers','customers.id = purchase_orders.customer_id')
                           ->where('purchase_orders.id', $id)
                           ->get();
                           
        return($query->num_rows() > 0) ? $query->first_row(): null;
    }

    function selectAllPurchaseOrders(){
        $query = $this->db->select(array('purchase_orders.*', 'customers.name'))
                          ->from('purchase_orders')->join('customers','customers.id = purchase_orders.customer_id')
                          ->where('purchase_orders.done =', 0)
                          ->order_by('customers.name', 'asc')->get();
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function insertPurchaseOrder($arrPurchaseOrderDetail){
        $query = $this->db->insert('purchase_orders', $arrPurchaseOrderDetail);

        return $this->db->insert_id();
    }

    function updatePurchaseOrder($arrPurchaseOrderDetail){
        /*$arrColumns = array('id', 'customer_id', 'customer_po_id', 'order_list', 'promised_delivery_date', 'actual_delivery_date', 'invoice_id', 'amount', 'dr_id', 'remarks');*/
        $query = $this->db->where('id', $arrPurchaseOrderDetail['id'])
                          ->update(
                                'purchase_orders', 
                                array(
                                    'customer_id'=> $arrPurchaseOrderDetail['customer_id'], 
                                    'customer_po_id' => $arrPurchaseOrderDetail['customer_po_id'], 
                                    'order_list' => $arrPurchaseOrderDetail['order_list'],
                                    'promised_delivery_date' => $arrPurchaseOrderDetail['promised_delivery_date'],
                                    'actual_delivery_date' => $arrPurchaseOrderDetail['actual_delivery_date'],
                                    'invoice_id' => $arrPurchaseOrderDetail['invoice_id'],
                                    'amount' => $arrPurchaseOrderDetail['amount'],
                                    'dr_id' => $arrPurchaseOrderDetail['dr_id'],
                                    'remarks' => $arrPurchaseOrderDetail['remarks'],
                                )
                            );
        return $this->db->affected_rows();
    }

    function deletePurchaseOrder($arrPurchaseOrderDetail){
        $query = $this->db->where('id', $arrPurchaseOrderDetail['id'])->delete('purchase_orders');

        return $this->db->affected_rows();
    }

    function updateInventorySaved($arrPurchaseOrderDetail){
        $query = $this->db->where('id', $arrPurchaseOrderDetail['id'])
                                    ->update(
                                        'purchase_orders', 
                                        array(
                                            'inventory_saved'=> 1
                                        )
                                    );
        return $this->db->affected_rows();
    }

    function togglePurchaseOrderDone($arrPurchaseOrderDetail){
        $query = $this->db->where('id', $arrPurchaseOrderDetail['id'])
                          ->update(
                                'purchase_orders', 
                                array(
                                    'done'=> 1
                                )
                            );
        return $this->db->affected_rows();
    }
}

?>