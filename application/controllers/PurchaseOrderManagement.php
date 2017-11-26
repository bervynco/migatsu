<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseOrderManagement extends CI_Controller
{
    // transactions the next 7 days
    public function getTransactions(){
        $today = new DateTime(date("Y-m-d"));
        $date = new DateTime(date("Y-m-d"));
        $date->modify('+7 day');
        $nextDate = new DateTime($date->format('Y-m-d'));

        $transactions = $this->po_model->selectToday($today->format('Y-m-d'), $date->format('Y-m-d'));

        echo json_encode($transactions);
    }
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function getAllPurchaseOrder(){
        $arrPurchaseOrder = $this->po_model->selectAllPurchaseOrders();

        foreach($arrPurchaseOrder as $index => $row){
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

            $arrPurchaseOrder[$index]['amount'] = floatval($arrPurchaseOrder[$index]['amount']);
        }
        echo json_encode($arrPurchaseOrder);
    }

    public function addNewPurchaseOrder(){
        $arrColumns = array('customer_id', 'customer_po_id', 'order_list', 'promised_delivery_date', 'actual_delivery_date', 'invoice_id', 'amount', 'dr_id', 'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrPurchaseOrderDetail = $this->assignDataToArray($postData, $arrColumns);
        $arrPurchaseOrderDetail['order_list'] = json_encode($arrPurchaseOrderDetail['order_list']);
        $purchaseOrder = $this->po_model->insertPurchaseOrder($arrPurchaseOrderDetail);
        if($purchaseOrder > 0){
            echo "Successful";
        }
        else{
            echo "Error";
        }
    }

    public function editPurchaseOrder(){
        $arrColumns = array('id', 'customer_id', 'customer_po_id', 'order_list', 'promised_delivery_date', 'actual_delivery_date', 'invoice_id', 'amount', 'dr_id', 'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrPurchaseOrderDetail = $this->assignDataToArray($postData, $arrColumns);
        $arrPurchaseOrderDetail['order_list'] = json_encode($arrPurchaseOrderDetail['order_list']);
        $purchaseOrder = $this->po_model->updatePurchaseOrder($arrPurchaseOrderDetail);
        echo "Successful";
    }

    public function deletePurchaseOrder(){
        $arrColumns = array('id', 'customer_id', 'customer_po_id', 'order_list', 'promised_delivery_date', 'actual_delivery_date', 'invoice_id', 'amount', 'dr_id', 'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrPurchaseOrderDetail = $this->assignDataToArray($postData, $arrColumns);
        $arrPurchaseOrderDetail['order_list'] = json_encode($arrPurchaseOrderDetail['order_list']);
        $purchaseOrder = $this->po_model->deletePurchaseOrder($arrPurchaseOrderDetail);
        echo "Successful";
    }

    public function applyInventoryChanges(){
        $arrColumns = array('id', 'customer_id', 'customer_po_id', 'order_list', 'quantity', 'amount', 'promised_delivery_date'
        , 'invoice_id', 'dr_id', 'actual_delivery_date', 'days', 'remarks', 'inventory_saved');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrPurchaseOrderDetail = $this->assignDataToArray($postData, $arrColumns);
        $arrPurchaseOrderDetail['order_list'] = json_encode($arrPurchaseOrderDetail['order_list']);
        $orderList = json_decode($postData['order_list']);
        $inventory = $this->inventory_model->updateInventoryItemCount($orderList);

        if($inventory == true){
            $purchaseOrder = $this->po_model->updateInventorySaved($arrPurchaseOrderDetail);

            echo "Successful";
        }
        else {
            echo "Error";
        }
    }

    public function togglePurchaseOrderDone(){
        $arrColumns = array('id', 'customer_id', 'customer_po_id', 'order_list', 'quantity', 'amount', 'promised_delivery_date'
        , 'invoice_id', 'dr_id', 'actual_delivery_date', 'days', 'remarks', 'inventory_saved');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrPurchaseOrderDetail = $this->assignDataToArray($postData, $arrColumns);

        if($arrPurchaseOrderDetail['inventory_saved'] == 0){
            $orderList = json_decode($postData['order_list']);
            $inventory = $this->inventory_model->updateInventoryItemCount($orderList);

            if($inventory == true){
                $purchaseOrder = $this->po_model->updateInventorySaved($arrPurchaseOrderDetail);
            }
        }
        $purchaseOrder = $this->po_model->togglePurchaseOrderDone($arrPurchaseOrderDetail);
        echo "Successful";
    }
}
?>