<?php

class Session{

    public static function exists($nama)
    {
        return (isset($_SESSION[$nama])) ? TRUE : FALSE;
    }

    public static function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    public static function get($nama){
        return $_SESSION[$nama];
    }

    public static function delete($nama)
    {
        return (isset($_SESSION[$nama])) ? unset($_SESSION[$nama]) : false;
    }

}