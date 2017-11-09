<?php
class PageLogController extends CI_Controller
{   
    public function __construct(){
        parent::__construct();
    }
    public function getPageLog(){
    	$arrLogs = $this->log_model->selectAllLogs();
        echo json_encode($arrLogs);
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
