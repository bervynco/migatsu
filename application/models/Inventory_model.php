<?php
class inventory_model extends CI_Model {
    function selectAllInventory(){
        // $query = $this->db->select(array('inventory.*', 'suppliers.name'))->from('inventory')->join('suppliers','suppliers.id = inventory.supplier_id')->order_by('product_id', 'asc')->get();
        $query = $this->db->from('inventory')->order_by('product_id', 'asc')->get();
        return($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function selectPOInventory(){
        $query = $this->db->from('inventory')->where("inventory.balance > 0")->order_by('product_id', 'asc')->get();
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
    
    function getInventoryFromProductId($productId) {
        $query = $this->db->from("inventory")->where('product_id', $productId)->get();
        return($query->num_rows() > 0) ? $query->result_array(): null;
    }
    function insertInventoryFromPayable($list){
        $query = $this->db->insert('inventory', array(
                'balance' => $list['quantity'],
                'uom' => $list['uom'],
                'product_description' => $list['description'],
                'product_id' => $list['product_id']
            )         
        );

        return $this->db->insert_id();
    }
    function updateInventory($arrInventoryDetail){
        $query = $this->db->where('id', $arrInventoryDetail['id'])
                          ->update(
                                'inventory', 
                                array(
                                    'product_id'=> $arrInventoryDetail['product_id'], 
                                    'product_description' => $arrInventoryDetail['product_description'], 
                                    'uom' => $arrInventoryDetail['uom'],
                                    'purchase_price' => $arrInventoryDetail['purchase_price'],
                                    'location' => $arrInventoryDetail['location'],
                                    'remarks' => $arrInventoryDetail['remarks'],
                                    'balance'=> $arrInventoryDetail['balance'],
                                    'threshold'=> $arrInventoryDetail['threshold']
                                )
                            );
        return $this->db->affected_rows();
    }

    function updateInventoryFromPayable($arrInventoryDetail){
        $query = $this->db->where('id', $arrInventoryDetail['id'])
                          ->update(
                                'inventory', 
                                array(
                                    'product_id'=> $arrInventoryDetail['product_id'], 
                                    'product_description' => $arrInventoryDetail['product_description'], 
                                    'uom' => $arrInventoryDetail['uom'],
                                    'purchase_price' => $arrInventoryDetail['purchase_price'],
                                    'location' => $arrInventoryDetail['location'],
                                    'remarks' => $arrInventoryDetail['remarks'],
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
        $balanceFlag = 0;
        foreach($arrOrderList as $index => $arrItem){
            $query = $this->db->select(array('id', 'balance', 'threshold'))->from('inventory')->where('id', $arrItem->id)->get();
            $item = $query->result_array();

            foreach($item as $indexItem => $arrInventoryItem){
                // $currBalance = $arrInventoryItem['balance'];
                $proposedBalance = $arrInventoryItem['balance'] - $arrItem->quantity;
                if($proposedBalance >= 0){
                    $queryInventory = $this->db->where('id', $arrInventoryItem['id'])
                        ->update(
                            'inventory', 
                            array(
                                'balance'=> $proposedBalance
                            )
                        );
                }
                else{
                    $balanceFlag = 1;
                    break;
                }
                
            }
        }

        return $balanceFlag;
    }
}
?>