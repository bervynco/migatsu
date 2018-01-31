<?php
class inventory_model extends CI_Model {
    function selectAllInventory(){
        $query = $this->db->select(array('inventory.*', 'suppliers.name'))->from('inventory')->join('suppliers','suppliers.id = inventory.supplier_id')->order_by('product_id', 'asc')->get();
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function selectInventoryItem($id){
        $query = $this->db->select(array('inventory.*', 'suppliers.name'))->from('inventory')->join('suppliers','suppliers.id = inventory.supplier_id')->where('inventory.id', $id)->get();
        return($query->num_rows() > 0) ? $query->first_row(): null;
    }
    function insertInventory($arrInventoryDetail){
        $query = $this->db->insert('inventory', $arrInventoryDetail);

        return $this->db->insert_id();
    }

    function updateInventory($arrInventoryDetail){
        $query = $this->db->where('id', $arrInventoryDetail['id'])
                          ->update(
                                'inventory', 
                                array(
                                    'product_id'=> $arrInventoryDetail['product_id'], 
                                    'product_description' => $arrInventoryDetail['product_description'], 
                                    'purchase_price' => $arrInventoryDetail['purchase_price'],
                                    'location' => $arrInventoryDetail['location'],
                                    'remarks' => $arrInventoryDetail['remarks'],
                                    'supplier_id' => $arrInventoryDetail['supplier_id'],
                                    'balance'=> $arrInventoryDetail['balance'],
                                    'threshold'=> $arrInventoryDetail['threshold']
                                )
                            );
        return $this->db->affected_rows();
    }

    function deleteInventory($arrInventoryDetail){
        $query = $this->db->where('id', $arrInventoryDetail['id'])->delete('inventory');

        return $this->db->affected_rows();
    }

    function updateInventoryItemCount($arrOrderList){
        foreach($arrOrderList as $index => $arrItem){
            $query = $this->db->select(array('id', 'balance'))->from('inventory')->where('id', $arrItem->id)->get();
            $item = $query->result_array();

            foreach($item as $indexItem => $arrInventoryItem){
                $queryInventory = $this->db->where('id', $arrInventoryItem['id'])
                                    ->update(
                                        'inventory', 
                                        array(
                                            'balance'=> $arrInventoryItem['balance'] - $arrItem->quantity
                                        )
                                    );
            }
        }

        return true;
    }
}
?>