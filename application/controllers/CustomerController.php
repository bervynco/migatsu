<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerController extends CI_Controller
{
    public function getCustomerList(){
        $customer = Customers::get();
        echo json_encode($customer);

    }
    public function addNewCustomer(Request $request){
        $customer = $request->all();
        
        $customerModel = Customers::create($customer);
        $customerModel->save();

        if(!$customerModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully insert data to DB."), 200);
        }
    }

    public function editCustomer(Request $request){
        $customerData = $request->all();
        $customerModel = Customers::find($request->id);
        $customerModel['name'] = ($customerData['name']);
        $customerModel['phone_number'] = ($customerData['phone_number']);
        $customerModel['tin'] = ($customerData['tin']);

        $customerModel->save();

        if(!$customerModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully edit data to DB."), 200);
        }
    }

    public function deleteCustomer(Request $request){
        $deletedRows = Customers::where('id', $request->id)->delete();

        if($deletedRows == 1){
            return "Successful";
        }
        else{
            return "Error";
        }
        echo json_encode($deletedRows);
    }
}
