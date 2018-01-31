<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InventoryManagement extends CI_Controller
{
    public function getTransactions(){
        $arrInventory = $this->inventory_model->selectAllInventory();

        foreach($arrInventory as $index => $row){
            if($row['threshold'] != 0){
                $computedBalance = $row['balance'] / $row['threshold'];
                if($computedBalance > 2){
                    unset($arrInventory[$index]);
                }
                else{
                    if($computedBalance > 1 && $computedBalance < 1.5){
                        $arrInventory[$index]['status'] = 'warning';
                    }
                    else{
                        $arrInventory[$index]['status'] = 'bad';
                    }
                }
            }
            else {
                $arrInventory[$index]['status'] = 'good';
            }
        }
        echo json_encode($arrInventory);
    }
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function getAllInventory(){
        $arrInventory = $this->inventory_model->selectAllInventory();

        foreach($arrInventory as $index => $row){
            $row['status'] = 'bad';
            if($row['threshold'] != 0){
                $computedBalance = $row['balance'] / $row['threshold'];
                if($computedBalance > 2){
                    $arrInventory[$index]['status'] = 'good';
                }
                else if($computedBalance > 1 && $computedBalance < 1.5){
                    $arrInventory[$index]['status'] = 'warning';
                }
                else{
                    $arrInventory[$index]['status'] = 'bad';
                }
            }
            else{
                $arrInventory[$index]['status'] = 'good';
            }
            $arrInventory[$index]['threshold'] = floatval($arrInventory[$index]['threshold']);
            $arrInventory[$index]['balance'] = floatval($arrInventory[$index]['balance']);
        }
        echo json_encode($arrInventory);
    }

    public function addNewInventory(){
        $arrColumns = array('product_id', 'product_description', 'location', 'balance', 'purchase_price', 
            'threshold', 'supplier_id', 'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrInventoryDetail =  $this->assignDataToArray($postData, $arrColumns);
        $inventory = $this->inventory_model->insertInventory($arrInventoryDetail);
        if($inventory > 0){
            echo json_encode($this->inventory_model->selectInventoryItem($inventory));
            //echo "Successful";
        }
        else{
            echo "Error";
        }
        
    }

    public function editInventory(){
        $arrColumns = array('id', 'product_id', 'product_description', 'location', 'balance', 'purchase_price', 
            'threshold', 'supplier_id', 'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrInventoryDetail = $this->assignDataToArray($postData, $arrColumns);
        $inventory = $this->inventory_model->updateInventory($arrInventoryDetail);
        echo "Successful";
        
    }

    public function deleteInventory(){
        $arrColumns = array('id', 'product_id', 'product_description', 'location', 'balance', 'purchase_price', 
            'threshold', 'supplier_id', 'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrInventoryDetail = $this->assignDataToArray($postData, $arrColumns);
        $inventory = $this->inventory_model->deleteInventory($arrInventoryDetail);
        echo "Successful";
    }

}
