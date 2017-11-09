<?php
class user_model extends CI_Model {
    function login($username, $password){
        $query = $this->db->select(array('name', 'username', 'role'))->where('username', $username)->where('password', $password)->get('users');
        return ($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function selectAllUsers(){
        $query = $this->db->select(array('name', 'username','role'))->get('users');

        return($query->num_rows() > 0) ? $query->result_array(): array();
    }
    function insertUser($arrUserDetail){
        $query = $this->db->insert('users', $arrUserDetail);

        return $this->db->insert_id();
    }
    
    function updateUser(){

    }

    function deleteUser(){

    }
}

?>