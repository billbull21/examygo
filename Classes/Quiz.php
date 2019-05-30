<?php

class Quiz{

    private $_db;
    //db connection
    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    public function getQuiz($key = '', $value = '', $orderBy = '', $type = '')
    {
        if ($key != '') {
            return $this->_db->getData('quiz', $key, $value);
        } else if ($key == '' && $value == '' && $orderBy != '') {
            return $this->_db->getData('quiz', $key = '', $value = '', $orderBy, $type);
        }
        return $this->_db->getData('quiz', $key = '', $value = '');
    }

    public function addQuiz($fields = [])
    {
        if ($this->_db->insertData('quiz', $fields)) return TRUE;
        else return FALSE;
    }

    public function addAnswer($dataTags, $dataSubj, $total, $fields = [], $cid, $aid)
    {
        if ($this->_db->insertAnswer('answer', $dataTags, $dataSubj, $total, $fields, $cid, $aid)) return TRUE;
        else return FALSE;
    }
}