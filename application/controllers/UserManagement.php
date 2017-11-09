<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserManagement extends CI_Controller
{
    public function assignDataToArray($postData, $arrColumns){
        foreach($arrColumns as $col){
            $insertArray[$col] = (!empty($postData[$col])) ? $postData[$col] : null;
        }

        return $insertArray;
    }
    public function login(){
        $arrColumns = array('username', 'password');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrLogin = $this->assignDataToArray($postData, $arrColumns);
        $user = $this->user_model->login($arrLogin['username'], $arrLogin['password']);
        // $loginCredentials = $request->all();
        // $user = array();

        // if(Auth::attempt(['username'=>$loginCredentials['username'], 'password'=>$loginCredentials['password']])){
        //     $user = User::where('username', $loginCredentials['username'])->get(array('name', 'username', 'role'));
        // }
        
        echo json_encode($user);
    }
}
