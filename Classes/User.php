<?php

class User{

    private $_db;
    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    //get all user data or spesific user data by using param
    public function getUser($key = '', $value = '')
    {
        if ($key != '') {
            return $this->_db->getUser('users', $key, $value);            
        }
        return $this->_db->getUser('users', $key = '', $value = '');
    }

    //adding data user by register in form register
    public function registerUser($fields = [])
    {
        if ( $this->_db->insertUser('users', $fields) ) return true;
        else return false;
    }

    //get some data from database to login
    public function loginUser($username, $password)
    {
        //fetch data from database
        $data = $this->getUser('username', $username);
        
        if (!empty($data)) {
            if (password_verify($password, $data['password'])) {
                return true;
            }else{
                return false;
            }
        }else {
            return false;
        }
    } 

}