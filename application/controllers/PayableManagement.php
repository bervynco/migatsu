<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PayableManagement extends CI_Controller
{
    public function getTransactions(){
        $today = new DateTime(date("Y-m-d"));
        $date = new DateTime(date("Y-m-d"));
        $date->modify('+7 day');
        $nextDate = new DateTime($date->format('Y-m-d'));

        $transactions = $this->payable_model->selectToday($today->format('Y-m-d'), $date->format('Y-m-d'));

        echo json_encode($transactions);
    }
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function getAllPayable(){
        $arrPayable = $this->payable_model->selectAllPayable();

        foreach($arrPayable as $index => $payable){
            $currDateTime = new DateTime();
            $dueDateTime = new DateTime($payable['due_date']);
            $diff = $dueDateTime->diff($currDateTime);
            $interval = $diff->format('%a');
            $arrPayable[$index]['overdue_days'] = $interval;
        }
        echo json_encode($arrPayable);
    }

    public function addNewPayable(){
        $arrColumns = array('supplier_id', 'po_id', 'delivery_date', 'supplier_dr_id', 'terms', 'due_date',
                            'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrPayableDetail =  $this->assignDataToArray($postData, $arrColumns);
        $payable = $this->payable_model->insertPayable($arrPayableDetail);
        if($payable > 0){
            echo "Successful";
        }
        else{
            echo "Error";
        };
    }

    public function editPayable(){
        $arrColumns = array('id', 'supplier_id', 'po_id', 'delivery_date', 'supplier_dr_id', 'terms', 'due_date',
                            'remarks');

        $postData = json_decode(file_get_contents('php://input'), true);
        $arrPayableDetail =  $this->assignDataToArray($postData, $arrColumns);
        $payable = $this->payable_model->updatePayable($arrPayableDetail);
        if($payable > 0){
            echo "Successful";
        }
        else{
            echo "Error";
        };
    }

    public function deletePayable(){
        $arrColumns = array('id', 'supplier_id', 'po_id', 'delivery_date', 'supplier_dr_id', 'terms', 'due_date',
                            'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrPayableDetail = $this->assignDataToArray($postData, $arrColumns);
        $payable = $this->payable_model->deletePayable($arrPayableDetail);

        echo "Successful";
    }

    public function togglePayableDone(){
        $arrColumns = array('id', 'supplier_id', 'po_id', 'delivery_date', 'supplier_dr_id', 'terms', 'due_date',
                            'remarks');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrPayableDetail = $this->assignDataToArray($postData, $arrColumns);
        $payable = $this->payable_model->togglePayableDone($arrPayableDetail);
        echo "Successful";
    }
}

?>