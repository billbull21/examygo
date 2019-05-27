<?php
/** 
 * File For Connect the database and proccess the CRUD
 * */ 
class Database{

    private static $INSTANCE = null;
    private $mysqli,
            $db_host,
            $db_user,
            $db_pass,
            $db_name;
    
    // Connection
    public function __construct(){
        if (file_exists("config.php")) {
            include "config.php";
        }else if ( file_exists("../config.php") ) {
            include "../config.php";
        }

        $this->db_host = $get_HOST;
        $this->db_user = $get_USER;
        $this->db_pass = $get_PASS;
        $this->db_name = $get_NAME;

        $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        /* check connection */
        if (mysqli_connect_errno()) {
            die("Connect failed: ". mysqli_connect_error());
        }
    }

    // avoid multiple call database,
    public static function getInstance()
    {
        if (!isset(self::$INSTANCE)) {
            self::$INSTANCE = new Database;
        }

        return self::$INSTANCE;
    }

    // register / add data user into database
    public function insertData($table, $fields = [])
    {
        $column = implode(", ", array_keys($fields));

        $valueArrays = [];
        $i = 0;
        foreach ($fields as $values => $value) {
            if (is_int($value)) {
                $valueArrays[$i] = $this->escape($value);
            }else{
                $valueArrays[$i] = "'".$this->escape($value)."'";
            }
            $i++;
        }
        $value = implode(", ", $valueArrays);

        $query = "INSERT INTO $table ($column) VALUES ($value)";
        $result = $this->mysqli->query($query);
        if( $result ){
            return true;
        }else{
            return false;
        }
    }

    // get data from spesific table on database
    public function getData($table, $key = '', $value = '', $orderBy = '', $type = '')
    {
        if ($key == '' && $orderBy == '') {
            $query = "SELECT * FROM $table";
            
            $result = $this->mysqli->query($query);
            if ( mysqli_num_rows($result) != 0 ) {
                while ($row = $result->fetch_assoc()) {
                    $results[] = $row;
                }

                return $results;
            }else{
                return false;
            }
        }else if($orderBy != ''){
            $query = "SELECT * FROM $table ORDER BY $orderBy $type";
            $result = $this->mysqli->query($query);
            if (mysqli_num_rows($result) != 0) {
                while ($row = $result->fetch_assoc()) {
                    $results[] = $row;
                }

                return $results;
            } else {
                return false;
            }
        }else{
            if (!is_int($value)) {
                $value = "'" . $this->escape($value) . "'";
            }

            $query = "SELECT * FROM $table WHERE $key = $value";
            $result = $this->mysqli->query($query);
            if (!empty($result)) {
                while ($row = $result->fetch_assoc()) {
                    return $row;
                }
            }else{
                return false;
            }
        }
    }

    //escaping input
    public function escape($nama)
    {
        return $this->mysqli->real_escape_string(htmlentities(htmlspecialchars($nama)));
    }
}

?>