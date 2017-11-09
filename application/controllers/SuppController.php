<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Supplier;
class SuppController extends Controller
{
    public function getSupplierList(){
        $supplier = Supplier::get();
        echo json_encode($supplier);

    }
    public function addNewSupplier(Request $request){
        $supplier = $request->all();
        
        $supplierModel = Supplier::create($supplier);
        $supplierModel->save();

        if(!$supplierModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully insert data to DB."), 200);
        }
    }

    public function editSupplier(Request $request){
        $supplierData = $request->all();
        $supplierModel = Supplier::find($request->id);
        $supplierModel['name'] = ($supplierData['name']);
        $supplierModel['phone_number'] = ($supplierData['phone_number']);

        $supplierModel->save();

        if(!$supplierModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully edit data to DB."), 200);
        }
    }

    public function deleteSupplier(Request $request){
        $deletedRows = Supplier::where('id', $request->id)->delete();

        if($deletedRows == 1){
            return "Successful";
        }
        else{
            return "Error";
        }
        echo json_encode($deletedRows);
    }
}
