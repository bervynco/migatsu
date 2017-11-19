<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OutboundDeliveryManagement extends CI_Controller
{
    // transactions the next 7 days
    public function getTransactions(){
        $today = new DateTime(date("Y-m-d"));
        $date = new DateTime(date("Y-m-d"));
        $date->modify('+7 day');
        $nextDate = new DateTime($date->format('Y-m-d'));

        $transactions = $this->outbound_model->selectToday($today->format('Y-m-d'), $date->format('Y-m-d'));

        echo json_encode($transactions);
    }
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function getAllOutboundDelivery(){
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
}
?>