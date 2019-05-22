<?php

class Database{

    private static $INSTANCE = null;
    private $mysqli,
            $db_host,
            $db_user,
            $db_pass,
            $db_name;
            
    public function __construct(){
        if (file_exists("config.php")) {
            include "config.php";
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

    public static function getInstance()
    {
        if (!isset(self::$INSTANCE)) {
            self::$INSTANCE = new Database;
        }

        return self::$INSTANCE;
    }

    public function insertUser($table, $fields = [])
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
            die('gagal tambah');
        }
    }

    public function getUser($table, $key = '', $value = '')
    {
        if ($key == '') {
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