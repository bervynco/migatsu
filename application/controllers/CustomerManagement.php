<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerManagement extends CI_Controller
{
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function getAllCustomers(){
        $arrCustomers = $this->customer_model->selectAllCustomers();
        echo json_encode($arrCustomers);
    }

    public function addNewCustomer(){
        $arrColumns = array('name', 'phone_number', 'tin', 'address');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrCustomerDetail = $this->assignDataToArray($postData, $arrColumns);
        $customer = $this->customer_model->insertCustomer($arrCustomerDetail);
        if($customer > 0){
            echo "Successful";
        }
        else{
            echo "Error";
        }
        
    }

    public function editCustomer(){
        $arrColumns = array('id', 'name', 'address', 'phone_number', 'tin');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrCustomerDetail = $this->assignDataToArray($postData, $arrColumns);
        $customer = $this->customer_model->updateCustomer($arrCustomerDetail);
        echo "Successful";
        
    }

    public function deleteCustomer(){
        $arrColumns = array('id', 'name', 'address', 'phone_number', 'tin');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrCustomerDetail = $this->assignDataToArray($postData, $arrColumns);
        $customer = $this->customer_model->deleteCustomer($arrCustomerDetail);
        echo "Successful";
    }

}
