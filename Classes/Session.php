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
       if( self::exists($nama) ){
           unset($_SESSION[$nama]);
       }
    }

    public static function flash($nama, $msg = '')
    {
        if ( self::exists($nama) ) {
            $session = self::get($nama);
            self::delete($nama);
            return $session;
        }else{
            self::set($nama, $msg);
        }
    }

}