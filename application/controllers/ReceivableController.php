<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use DateTime;
use App\Receivables;
class ReceivableController extends Controller
{
    public function getTransactionsToday(){
        $today = new DateTime(date("Y-m-d"));
        $date = new DateTime(date("Y-m-d"));
        $date->modify('+7 day');
        $nextDate = new DateTime($date->format('Y-m-d'));

        $receivables = Receivables::with('customer')
                ->whereBetween('due_date', array($today, $nextDate))
                ->get();

        foreach($receivables as $index => $row){
            $receivables[$index]['customer_id'] = $row['customer']['id'];
            $receivables[$index]['customer_name'] = $row['customer']['name'];
        }

        echo json_encode($receivables);
    }

    public function getReceivableList(){
    	$receivables = Receivables::with('customer')->get();
        
        foreach($receivables as $index => $row){
            $receivables[$index]['customer_id'] = $row['customer']['id'];
            $receivables[$index]['customer_name'] = $row['customer']['name'];
        }
    	echo json_encode($receivables);
    }

    public function addNewReceivable(Request $request){
        $receivable = $request->all();

        print_r($receivable);
        // print_r($receivable['delivery_date']);
        // $receivable['delivery_date'] = DateTime::createFromFormat('Y-m-d',  $receivable['delivery_date']);
        // $receivable['due_date'] = DateTime::createFromFormat('Y-m-d',  $receivable['due_date']);
        $receivableModel = Receivables::create($receivable);
        $receivableModel->save();

        if(!$receivableModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully insert data to DB."), 200);
        }
    }

    public function editReceivable(Request $request){
        $receivableData = $request->all();

        print_r($receivableData);
        $receivableModel = Receivables::find($request->id);
        $receivableModel['po_id'] = $receivableData['po_id'];
        $receivableModel['delivery_date'] = $receivableData['delivery_date'];
        $receivableModel['amount'] = $receivableData['amount'];
        $receivableModel['invoice_id'] = $receivableData['invoice_id'];
        $receivableModel['terms'] = $receivableModel['terms'];
        $receivableModel['due_date'] = $receivableData['due_date'];
        $receivableModel['remarks'] = $receivableData['remarks'];
        $receivableModel->save();

        if(!$receivableModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully edit data to DB."), 200);
        }
    }

    public function deleteReceivable(Request $request){
        $deletedRows = Receivables::where('id', $request->id)->delete();

        if($deletedRows == 1){
            return "Successful";
        }
        else{
            return "Error";
        }
        echo json_encode($deletedRows);
    }
}
