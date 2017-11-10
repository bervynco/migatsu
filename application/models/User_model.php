<?php
class user_model extends CI_Model {
    function login($username, $password){
        $query = $this->db->select(array('name', 'username', 'role'))->where('username', $username)->where('password', $password)->get('users');
        return ($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function selectAllUsers(){
        $query = $this->db->select(array('id', 'name', 'username','role'))->get('users');

        return($query->num_rows() > 0) ? $query->result_array(): array();
    }

    function checkExisting($action, $arrUserDetail){
        $query = $this->db->where('username', $arrUserDetail['username']);
        $query = $this->db->count_all_results('users');
        return $query;
    }
    function insertUser($arrUserDetail){
        $query = $this->db->insert('users', $arrUserDetail);

        return $this->db->insert_id();
    }
    
    function updateUser($arrUserDetail){
        $query = $this->db->where('id', $arrUserDetail['id'])
                          ->update('users', array('name'=> $arrUserDetail['name'], 'username' => $arrUserDetail['username'], 'role' => $arrUserDetail['role']));
        return $this->db->affected_rows();
    }

    function updatePassword($arrUserDetail){
        $query = $this->db->where('id', $arrUserDetail['id'])->update('users', array('password'=>$arrUserDetail['password']));

        return $this->db->affected_rows();
    }
    function deleteUser($arrUserDetail){
        $query = $this->db->where('id', $arrUserDetail['id'])->delete('users');

        return $this->db->affected_rows();
    }
}

?>