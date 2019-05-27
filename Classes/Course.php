<?php

class Course{

    private $_db;
    //db connection
    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    //get all course data or spesific course data by using param
    public function getCourse($key = '', $value = '')
    {
        if ($key != '') {
            return $this->_db->getData('courses', $key, $value);
        }
        return $this->_db->getData('courses', $key = '', $value = '');
    }

    //get all course data or spesific course data by using param
    public function getActivity($key = '', $value = '', $orderBy = '', $type = '')
    {
        if ($key != '') {
            return $this->_db->getData('activity', $key, $value);
        } else if ($key == '' && $value == '' && $orderBy != '') {
            return $this->_db->getData('activity', $key = '', $value = '', $orderBy, $type);
        }
        return $this->_db->getData('activity', $key = '', $value = '');
    }

    //send param into database and pass it into addCourse func on database
    public function addCourse($fields = [])
    {
        if($this->_db->insertData('courses', $fields)) return TRUE;
        else return FALSE;
    }

    public function addActivity($fields = []){
        if($this->_db->insertData('activity', $fields)) return TRUE;
        else return FALSE;
    }

}