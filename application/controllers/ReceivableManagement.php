<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ReceivableManagement extends CI_Controller
{
    public function getTransactions(){
        $today = new DateTime(date("Y-m-d"));
        $date = new DateTime(date("Y-m-d"));
        $date->modify('+7 day');
        $nextDate = new DateTime($date->format('Y-m-d'));

        $transactions = $this->receivable_model->selectToday($today->format('Y-m-d'), $date->format('Y-m-d'));

        echo json_encode($transactions);
    }
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function getAllReceivable(){
        $arrReceivable = $this->receivable_model->selectAllReceivable();

        foreach($arrReceivable as $index => $row){
            $currDateTime = new DateTime();
            $dueDateTime = new DateTime($row['due_date']);
            $diff = $dueDateTime->diff($currDateTime);
            $interval = $diff->format('%a');
            $arrReceivable[$index]['overdue_days'] = $interval;

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

    public function toggleReceivableDone(){
        $arrColumns = array('id', 'supplier_id', 'po_id', 'delivery_date', 'supplier_dr_id', 'terms', 'due_date',
                            'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrReceivableDetail = $this->assignDataToArray($postData, $arrColumns);
        $receivable = $this->receivable_model->toggleReceivableDone($arrReceivableDetail);
        echo "Successful";
    }
}

?>