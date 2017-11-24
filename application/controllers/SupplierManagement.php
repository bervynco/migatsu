<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SupplierManagement extends CI_Controller
{
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function getAllSuppliers(){
        $arrSuppliers = $this->supplier_model->selectAllSuppliers();
        echo json_encode($arrSuppliers);
    }

    public function addNewSupplier(){
        $arrColumns = array('name', 'phone_number', 'tin', 'address');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrSupplierDetail = $this->assignDataToArray($postData, $arrColumns);
        $supplier = $this->supplier_model->insertSupplier($arrSupplierDetail);
        if($supplier > 0){
            echo "Successful";
        }
        else{
            echo "Error";
        }
    }

    public function editSupplier(){
        $arrColumns = array('id', 'name', 'address', 'phone_number', 'tin');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrSupplierDetail = $this->assignDataToArray($postData, $arrColumns);
        $supplier = $this->supplier_model->updateSupplier($arrSupplierDetail);
        echo "Successful";
    }

    public function deleteSupplier(){
        $arrColumns = array('id', 'name', 'address', 'phone_number', 'tin');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrSupplierDetail = $this->assignDataToArray($postData, $arrColumns);
        $supplier = $this->supplier_model->deleteSupplier($arrSupplierDetail);
        echo "Successful";
    }
}
