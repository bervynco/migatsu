<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PayableManagement extends CI_Controller
{
    /*
        public function getTransactionsToday(){
        $today = new DateTime(date("Y-m-d"));
        $date = new DateTime(date("Y-m-d"));
        $date->modify('+7 day');
        $nextDate = new DateTime($date->format('Y-m-d'));

        $reportData = Payables::with('supplier')
                    ->whereBetween('due_date', array($today, $nextDate))
                    ->get();
    
        foreach($reportData as $index => $row){
            $reportData[$index]['supplier_name'] = $row['supplier']['name'];
            unset($reportData[$index]['supplier']);
        }

        echo json_encode($reportData);
    }
    */
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function getAllPayable(){
        $arrPayable = $this->payable_model->selectAllPayable();

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
        $user = $this->payable_model->deletePayable($arrPayableDetail);

        echo "Successful";
    }
}

?>