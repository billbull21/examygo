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
        if ( mysqli_connect_error() ) {
            die("gagal terhubung!");
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$INSTANCE)) {
            self::$INSTANCE = new Database;
        }

        return self::$INSTANCE;
    }
}

?>