<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Supplier;
use App\Customers;
use App\PO;
use App\Receivables;
use App\Inventory;
use App\Logs;
use App\Users;
use Excel;
use DateTime;

class ReportsController extends Controller
{
    private $today;
    public function __construct() 
    {
        // Fetch the Site Settings object
        $this->today = new DateTime();

    }

    public function getAllData($report){
        if($report['name'] == 'System Logs'){
            $reportData = Logs::get();
        }
        else if($report['name'] == 'Customers'){
            $reportData = Customers::get();
        }
        else if($report['name'] == 'Suppliers'){
            $reportData = Supplier::get();
        }
        else if($report['name'] == 'Payables'){
            $reportData = Payables::with('supplier')->get();

            foreach($reportData as $index => $row){
                $reportData[$index]['supplier_name'] = $row['supplier']['name'];
                unset($reportData[$index]['supplier']);
            }
        }
        else if($report['name'] == 'Receivables'){
            $reportData = Receivables::with('customer')->get();
            
            foreach($reportData as $index => $row){
                $reportData[$index]['customer_name'] = $row['customer']['name'];
                unset($reportData[$index]['customer']);
            }
        }
        else if($report['name'] == 'Users'){
            $reportData = Users::get();
        }
        else if($report['name'] == 'Purchase Order'){
            $reportData = PO::with('customer')->get();
        
            foreach($reportData as $index => $row){
                $reportData[$index]['customer_name'] = $row['customer']['name'];
                 unset($reportData[$index]['customer']);
            }
        }
        else if($report['name'] == 'Inventory'){
            $reportData = Inventory::with('supplier')->get();
        
            foreach($reportData as $index => $row){
                $reportData[$index]['supplier_name'] = $row['supplier']['name'];
                 unset($reportData[$index]['supplier']);
            }
        }
        else;

        return $reportData;
    }

    public function getCurrentMonth($report){
        $month = $this->today->format("m");
         if($report['name'] == 'System Logs'){
            $reportData = Logs::whereMonth('created_at', $month)->get();
        }
        else if($report['name'] == 'Customers'){
            $reportData = Customers::whereMonth('created_at', $month)->get();
        }
        else if($report['name'] == 'Suppliers'){
            $reportData = Supplier::whereMonth('created_at', $month)->get();
        }
        else if($report['name'] == 'Payables'){
            $reportData = Payables::with('supplier')->whereMonth('created_at', $month)->get();

            foreach($reportData as $index => $row){
                $reportData[$index]['supplier_name'] = $row['supplier']['name'];
                unset($reportData[$index]['supplier']);
            }
        }
        else if($report['name'] == 'Receivables'){
            $reportData = Receivables::with('customer')->whereMonth('created_at', $month)->get();
            
            foreach($reportData as $index => $row){
                $reportData[$index]['customer_name'] = $row['customer']['name'];
                unset($reportData[$index]['customer']);
            }
        }
        else if($report['name'] == 'Users'){
            $reportData = Users::whereMonth('created_at', $month)->get();
        }
        else if($report['name'] == 'Purchase Order'){
            $reportData = PO::with('customer')->whereMonth('created_at', $month)->get();
        
            foreach($reportData as $index => $row){
                $reportData[$index]['customer_name'] = $row['customer']['name'];
                 unset($reportData[$index]['customer']);
            }
        }
        else if($report['name'] == 'Inventory'){
            $reportData = Inventory::with('supplier')->whereMonth('created_at', $month)->get();
        
            foreach($reportData as $index => $row){
                $reportData[$index]['supplier_name'] = $row['supplier']['name'];
                 unset($reportData[$index]['supplier']);
            }
        }
        else;

        return $reportData;
    }

    public function getCurrentYear($report){
        $year = $this->today->format("Y");
         if($report['name'] == 'System Logs'){
            $reportData = Logs::whereYear('created_at', $year)->get();
        }
        else if($report['name'] == 'Customers'){
            $reportData = Customers::whereYear('created_at', $year)->get();
        }
        else if($report['name'] == 'Suppliers'){
            $reportData = Supplier::whereYear('created_at', $year)->get();
        }
        else if($report['name'] == 'Payables'){
            $reportData = Payables::with('supplier')->whereYear('created_at', $year)->get();

            foreach($reportData as $index => $row){
                $reportData[$index]['supplier_name'] = $row['supplier']['name'];
                unset($reportData[$index]['supplier']);
            }
        }
        else if($report['name'] == 'Receivables'){
            $reportData = Receivables::with('customer')->whereYear('created_at', $year)->get();
            
            foreach($reportData as $index => $row){
                $reportData[$index]['customer_name'] = $row['customer']['name'];
                unset($reportData[$index]['customer']);
            }
        }
        else if($report['name'] == 'Users'){
            $reportData = Users::whereYear('created_at', $year)->get();
        }
        else if($report['name'] == 'Purchase Order'){
            $reportData = PO::with('customer')->get();
        
            foreach($reportData as $index => $row){
                $reportData[$index]['customer_name'] = $row['customer']['name'];
                 unset($reportData[$index]['customer']);
            }
        }
        else if($report['name'] == 'Inventory'){
            $reportData = Inventory::with('supplier')->whereYear('created_at', $year)->get();
        
            foreach($reportData as $index => $row){
                $reportData[$index]['supplier_name'] = $row['supplier']['name'];
                 unset($reportData[$index]['supplier']);
            }
        }
        else;

        return $reportData;
    }

    public function getCustomDates($report){
        
        if($report['name'] == 'System Logs'){
            $reportData = Logs::whereBetween('created_at', [$report['start_date'], $report['end_date']])->get();
        }
        else if($report['name'] == 'Customers'){
            $reportData = Customers::whereBetween('created_at', [$report['start_date'], $report['end_date']])->get();
        }
        else if($report['name'] == 'Suppliers'){
            $reportData = Supplier::whereBetween('created_at', [$report['start_date'], $report['end_date']])->get();
        }
        else if($report['name'] == 'Payables'){
            $reportData = Payables::with('supplier')->whereBetween('created_at', [$report['start_date'], $report['end_date']])->get();

            foreach($reportData as $index => $row){
                $reportData[$index]['supplier_name'] = $row['supplier']['name'];
                unset($reportData[$index]['supplier']);
            }
        }
        else if($report['name'] == 'Receivables'){
            $reportData = Receivables::with('customer')->whereBetween('created_at', [$report['start_date'], $report['end_date']])->get();
            
            foreach($reportData as $index => $row){
                $reportData[$index]['customer_name'] = $row['customer']['name'];
                unset($reportData[$index]['customer']);
            }
        }
        else if($report['name'] == 'Users'){
            $reportData = Users::whereBetween('created_at', [$report['start_date'], $report['end_date']])->get();
        }
        else if($report['name'] == 'Purchase Order'){
            $reportData = PO::with('customer')->whereBetween('created_at', [$report['start_date'], $report['end_date']])->get();
        
            foreach($reportData as $index => $row){
                $reportData[$index]['customer_name'] = $row['customer']['name'];
                 unset($reportData[$index]['customer']);
            }
        }
        else if($report['name'] == 'Inventory'){
            $reportData = Inventory::with('supplier')->whereBetween('created_at', [$report['start_date'], $report['end_date']])->get();
        
            foreach($reportData as $index => $row){
                $reportData[$index]['supplier_name'] = $row['supplier']['name'];
                 unset($reportData[$index]['supplier']);
            }
        }
        else;

        return $reportData;
    }
    public function generateReport(Request $request){
        $report = $request->all();
        $reportData = null;
        
        if($report['type'] == "All Dates"){
            $reportData = $this->getAllData($report);
        }
        else if($report['type'] == "Current Month"){
            $reportData = $this->getCurrentMonth($report);
        }
        else if($report['type'] == "Current Year"){
            $reportData = $this->getCurrentYear($report);
        }
        else if($report['type'] == "Custom"){
            $reportData = $this->getCustomDates($report);
        }
        else;
        
        $this->generateExcelFile($reportData, $report);
    }
    public function generateExcelFile($reportData, $report){
        $dateToday = new DateTime();
        $file = Excel::create($report['name'].'-'.$report['type'].'-'.strtotime("now"), function($excel) use ($reportData, $report) {
			
            $excel->sheet('exported-data', function($sheet) use ($reportData, $report)
	        {
				$sheet->fromArray($reportData);
                print_r($report['name'].'-'.$report['type'].'-'.strtotime("now"));
	        });
            
		})->store('xls', storage_path('excel/exports'));

        
        
    }
}
