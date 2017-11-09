<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Payables;
use DateTime;
class PayableController extends Controller
{
    private $today;
    public function __construct() 
    {
        // Fetch the Site Settings object
        $this->today = new DateTime();

    }

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
    public function getPayableList(){
    	$payables = Payables::with('supplier')->with('po')->get();
        
        foreach($payables as $index => $row){
            $payables[$index]['supplier_id'] = $row['supplier']['id'];
            $payables[$index]['supplier_name'] = $row['supplier']['name']; 
            $payables[$index]['po_id'] = $row['po']['customer_po_id'];
        }
    	echo json_encode($payables);
    }

    public function addNewPayable(Request $request){
        $payable = $request->all();
        
        $payableModel = Payables::create($payable);
        $payableModel->save();

        if(!$payableModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully insert data to DB."), 200);
        }
    }

    public function editPayable(Request $request){
        $payableData = $request->all();
        $payableModel = Payables::find($request->id);
        $payableModel['supplier_id'] = $payableData['supplier_id'];
        $payableModel['po_id'] = $payableData['po_id'];
        $payableModel['delivery_date'] = $payableData['delivery_date'];
        $payableModel['due_date'] = $payableData['due_date'];
        $payableModel['supplier_dr_id'] = $payableData['supplier_dr_id'];
        $payableModel['terms'] = $payableData['terms'];
        $payableModel['remarks'] = $payableData['remarks'];

        $payableModel->save();

        if(!$payableModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully edit data to DB."), 200);
        }
    }

    public function deletePayable(Request $request){
        $deletedRows = Payables::where('id', $request->id)->delete();

        if($deletedRows == 1){
            return "Successful";
        }
        else{
            return "Error";
        }
        echo json_encode($deletedRows);
    }
}
