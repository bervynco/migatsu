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
        $arrColumns = array('name', 'username', 'role', 'password');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrUserDetail = $this->assignDataToArray($postData, $arrColumns);
        $existing = $this->user_model->checkExisting("add", $arrUserDetail);
         if($existing == 0){
            $user = $this->user_model->insertUser($arrUserDetail);
            echo "Successful";
        }
        else
            echo "Existing user with username";
        
    }

    public function editUser(){
        $arrColumns = array('id', 'name', 'username', 'role');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrUserDetail = $this->assignDataToArray($postData, $arrColumns);

        $existing = $this->user_model->checkExisting("update", $arrUserDetail);
        if($existing == 0){
            $user = $this->user_model->updateUser($arrUserDetail);
            echo "Successful";
        }
        else
            echo "Existing user with that username";
        
    }

    public function deleteUser(){
        $arrColumns = array('id', 'name', 'username', 'role');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrUserDetail = $this->assignDataToArray($postData, $arrColumns);
        $user = $this->user_model->deleteUser($arrUserDetail);

        echo "Successful";
    }

    public function changePassword(){
        $arrColumns = array('id', 'name', 'password', 'confirmPassword');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrUserDetail = $this->assignDataToArray($postData, $arrColumns);

        $password = $this->user_model->updatePassword($arrUserDetail);

        echo "Successful";

    }
    public function login(){
        $arrColumns = array('username', 'password');
        $postData = json_decode(file_get_contents('php://input'), true);
        $arrLogin = $this->assignDataToArray($postData, $arrColumns);
        $user = $this->user_model->login($arrLogin['username'], $arrLogin['password']);
        
        echo json_encode($user);
    }
}
