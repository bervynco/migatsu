<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseOrderManagement extends CI_Controller
{
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function getAllPurchaseOrder(){
        $arrPayable = $this->po_model->selectAllPurchaseOrders();

        // foreach($arrInventory as $index => $row){
        //     $row['status'] = 'bad';
        //     $computedBalance = $row['balance'] / $row['threshold'];
        //     if($computedBalance > 2){
        //         $arrInventory[$index]['status'] = 'good';
        //     }
        //     else if($computedBalance > 1 && $computedBalance < 1.5){
        //         $arrInventory[$index]['status'] = 'warning';
        //     }
        //     else{
        //         $arrInventory[$index]['status'] = 'bad';
        //     }

        //     $arrInventory[$index]['threshold'] = floatval($arrInventory[$index]['threshold']);
        //     $arrInventory[$index]['balance'] = floatval($arrInventory[$index]['balance']);
        // }
        echo json_encode($arrPayable);
    }

    public function addNewPurchaseOrder(){

    }

    public function editPurchaseOrder(){

    }

    public function deletePurchaseOrder(){

    }
}
?>