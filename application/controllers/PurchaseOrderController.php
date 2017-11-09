<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\PO;
use App\Inventory;

class PurchaseOrderController extends Controller
{
    public function getTransactionsToday(){
        $purchaseOrder = PO::with('customer')
                ->whereRaw('Date(created_at) = CURDATE()')->get();

        foreach($purchaseOrder as $index => $row){
            $purchaseOrder[$index]['customer_id'] = $row['customer']['id'];
            $purchaseOrder[$index]['customer_name'] = $row['customer']['name'];
            $purchaseOrder[$index]['invoice_id'] = (int)$row['invoice_id'];
            $purchaseOrder[$index]['dr_id'] = (int)$row['dr_id'];
            $purchaseOrder[$index]['order_list'] = json_decode($row['order_list']);
        }
    	echo json_encode($purchaseOrder);
    }

    public function getPurchaseOrderList(){
    	$purchaseOrder = PO::with('customer')->get();
        
        foreach($purchaseOrder as $index => $row){
            $purchaseOrder[$index]['customer_id'] = $row['customer']['id'];
            $purchaseOrder[$index]['customer_name'] = $row['customer']['name'];
            $purchaseOrder[$index]['invoice_id'] = (int)$row['invoice_id'];
            $purchaseOrder[$index]['dr_id'] = (int)$row['dr_id'];
            $purchaseOrder[$index]['order_list'] = json_decode($row['order_list']);
        }
    	echo json_encode($purchaseOrder);
    }

    public function addNewPurchaseOrder(Request $request){
        $purchaseOrder = $request->all();
        $purchaseOrder['order_list'] = json_encode($purchaseOrder['orderList']);
        unset($purchaseOrder['orderList']);
        print_r($purchaseOrder);
        $purchaseOrderModel = PO::create($purchaseOrder);
        $purchaseOrderModel->save();

        if(!$purchaseOrderModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully insert data to DB."), 200);
        }
    }

    public function editPurchaseOrder(Request $request){
        $purchaseOrderData = $request->all();
        $purchaseOrderModel = PO::find($request->id);
        $purchaseOrderModel['customer_id'] = $purchaseOrderData['customer_id'];
        $purchaseOrderModel['customer_po_id'] = $purchaseOrderData['customer_po_id'];
        //order list
        $purchaseOrderModel['dr_id'] = $purchaseOrderData['dr_id'];
        $purchaseOrderModel['invoice_id'] = $purchaseOrderData['invoice_id'];
        $purchaseOrderModel['promised_delivery_date'] = $purchaseOrderData['promised_delivery_date'];
        $purchaseOrderModel['actual_delivery_date'] = $purchaseOrderData['actual_delivery_date'];
        $purchaseOrderModel['remarks'] = $purchaseOrderData['remarks'];
        
        if(!$purchaseOrderModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully edit data to DB."), 200);
        }
    }
    public function applyInventoryChanges(Request $request){
        $purchaseOrder = $request->all();
        $orderList = json_decode($purchaseOrder['order_list']);

        foreach($orderList as $index => $row){
            $inventoryModel = Inventory::find($row->product_id);

            $inventoryModel['balance'] = $inventoryModel['balance'] - $row->quantity;
            
            if($inventoryModel['balance'] < 0){
                echo "Warning";
            }
            else {
                $inventoryModel->save();
                $purchaseOrderModel = PO::find($purchaseOrder['id']);
                $purchaseOrderModel['inventory_saved'] = 1;
                $purchaseOrderModel->save();

                if($inventoryModel['balance'] == 0){
                    echo "Conditional Success";
                }
                else{
                    echo "Successful";
                }
            }
        }
    }
}
