<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ReceivableManagement extends CI_Controller
{
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function getAllReceivable(){
        $arrReceivable = $this->receivable_model->selectAllReceivable();

        foreach($arrReceivable as $index => $row){
            // $row['status'] = 'bad';
            // $computedBalance = $row['balance'] / $row['threshold'];
            // if($computedBalance > 2){
            //     $arrInventory[$index]['status'] = 'good';
            // }
            // else if($computedBalance > 1 && $computedBalance < 1.5){
            //     $arrInventory[$index]['status'] = 'warning';
            // }
            // else{
            //     $arrInventory[$index]['status'] = 'bad';
            // }

            $arrReceivable[$index]['amount'] = floatval($arrReceivable[$index]['amount']);
            $arrReceivable[$index]['terms'] = intval($arrReceivable[$index]['terms']);
        }
        echo json_encode($arrReceivable);
    }

    public function addNewReceivable(){
        $arrColumns = array('customer_id', 'po_id', 'delivery_date', 'amount', 'invoice_id', 'terms', 'due_date',
                            'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrReceivableDetail =  $this->assignDataToArray($postData, $arrColumns);
        $receivable = $this->receivable_model->insertReceivable($arrReceivableDetail);
        if($receivable > 0){
            echo "Successful";
        }
        else{
            echo "Error";
        };
    }

    public function editReceivable(){
        $arrColumns = array('id', 'customer_id', 'po_id', 'delivery_date', 'amount', 'invoice_id', 'terms', 'due_date',
                            'remarks');

        $postData = json_decode(file_get_contents('php://input'), true);
        $arrReceivableDetail =  $this->assignDataToArray($postData, $arrColumns);
        $receivable = $this->receivable_model->updateReceivable($arrReceivableDetail);
        if($receivable > 0){
            echo "Successful";
        }
        else{
            echo "Error";
        };
    }

    public function deleteReceivable(){
        $arrColumns = array('id', 'supplier_id', 'po_id', 'delivery_date', 'supplier_dr_id', 'terms', 'due_date',
                            'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrReceivableDetail = $this->assignDataToArray($postData, $arrColumns);
        $receivable = $this->receivable_model->deleteReceivable($arrReceivableDetail);

        echo "Successful";
    }
}

?>