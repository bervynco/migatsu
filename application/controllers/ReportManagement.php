<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once "application/libraries/xlswriter.class.php";
class ReportManagement extends CI_Controller
{
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function generateReport(){
        $today = new DateTime();
        // $today->setTimezone(new DateTimeZone('Asia/Taipei'));
        // print_r($today);
        $postData = json_decode(file_get_contents('php://input'), true);
        
        if($postData['type'] == 'All Dates'){
            $param = null;
        }
        else if($postData['type'] == 'Current Month'){
            $param = $today->format("m");
        }
        else if($postData['type'] == 'Current Year'){
            $param = $today->format("Y");
        }
        else;

        $reportData = $this->report_model->selectReportData($postData['name'], $postData['type'], $param);
        if(count($reportData) > 0){
            $titles = array_keys($reportData[0]);
        
            if($postData['name'] == 'payables' || $postData['name'] == 'receivables'){
                array_push($titles, 'overdue_days');
                foreach($reportData as $index => $report){
                    $currDateTime = new DateTime();
                    $dueDateTime = new DateTime($report['due_date']);
                    if($dueDateTime > $currDateTime){
                        $interval = 0;
                    }
                    else {
                        $diff = $dueDateTime->diff($currDateTime);
                        $interval = $diff->format('%a');
                    }
                    $reportData[$index]['overdue_days'] = $interval;
                }
            }
            $writer = new XLSXWriter();
            array_unshift($reportData, $titles);
            $writer->writeSheet($reportData);
            $now = strtotime("now");
            $fileLocation = "reports/".$now.".xlsx";
            $writer->writeToFile($fileLocation);

            echo $fileLocation;
        }
        else {
            echo 'Error';
        }
    }
}