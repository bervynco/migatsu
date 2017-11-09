<?php
class LogManagement extends CI_Controller
{   
    public function __construct(){
        parent::__construct();
    }

    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }
        return $insertArray;
    }

    public function returnArray($status, $message){
        return array('status' => $status, 'message' => $message);
    }
    public function getPageLogs(){
    	$arrLogs = $this->log_model->selectAllLogs();
        echo json_encode($arrLogs);
    }

    public function setPageLog(){
        $arrColumns = array('name', 'page', 'action');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrLog = $this->assignDataToArray($postData, $arrColumns);
        $logID = $this->log_model->insertLog($arrLog);
        $arrReturn  = $this->returnArray("success", "Successfully inserted log");
        $arrReturn = array_merge($arrReturn, array('logId' => $logID));

        echo json_encode($arrReturn);
    }
    // public function setPageLog(Request $request){
    //     $log = $request->all();
    //     $logModel = Logs::create($log);
    //     $logModel->save();

    //     if(!$logModel->save()){
    //         Log::abort(500, 'Error');
    //     }
    //     else{
    //         return Response::json(array('success' => true, 'message' => "Successfully insert data to DB."), 200);
    //     }
    // }
}
