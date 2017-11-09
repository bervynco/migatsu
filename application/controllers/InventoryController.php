<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Inventory;
class InventoryController extends Controller
{
    public function getTransactionsToday(){
        $inventory = Inventory::with('supplier')
                ->whereRaw('Date(created_at) = CURDATE()')->get();

        foreach($inventory as $index => $row){
            $inventory[$index]['supplier_id'] = $row['supplier']['id'];
            $inventory[$index]['supplier_name'] = $row['supplier']['name'];
        }
    	echo json_encode($inventory);
    }

    public function getInventoryItems(){
        $inventory = Inventory::with('supplier')->get();
        
        foreach($inventory as $index => $row){
            $inventory[$index]['supplier_id'] = $row['supplier']['id'];
            $inventory[$index]['supplier_name'] = $row['supplier']['name'];
        }
    	echo json_encode($inventory);

    }

    public function addNewInventoryItem(Request $request){
        $inventory = $request->all();
        $inventoryModel = Inventory::create($inventory);
        if(!$inventoryModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully insert data to DB."), 200);
        }
    }

    public function editInventoryItem(Request $request){
        $payableData = $request->all();
        $payableModel = Inventory::find($request->id);
        $payableModel['supplier_id'] = $payableData['supplier_id'];
        $payableModel['product_id'] = $payableData['product_id'];
        $payableModel['product_description'] = $payableData['product_description'];
        $payableModel['location'] = $payableData['location'];
        $payableModel['balance'] = $payableData['balance'];
        $payableModel['purchase_price'] = $payableData['purchase_price'];
        $payableModel['threshold'] = $payableData['threshold'];
        $payableModel['remarks'] = $payableData['remarks'];
        $payableModel->save();

        if(!$payableModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully edit data to DB."), 200);
        }
    }

    public function deleteInventoryItem(Request $request){
        $deletedRows = Inventory::where('id', $request->id)->delete();

        if($deletedRows == 1){
            return "Successful";
        }
        else{
            return "Error";
        }
        echo json_encode($deletedRows);
    }
}
