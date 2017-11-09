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

    public function getAllUsers(){
        $arrUsers = $this->user_model->selectAllUsers();
        echo json_encode($arrUsers);
    }

    public function addNewUser(){

    }

    public function editUser(){

    }

    public function deleteUser(){

    }

    public function changePassword(){
        
    }
    public function login(){
        $arrColumns = array('username', 'password');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrLogin = $this->assignDataToArray($postData, $arrColumns);
        $user = $this->user_model->login($arrLogin['username'], $arrLogin['password']);
        
        echo json_encode($user);
    }
}
