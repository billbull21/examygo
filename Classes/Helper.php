<?php

class Helper{

    //generate new token and store it into a session
    public static function generateToken()
    {
        return $_SESSION['token'] = md5(uniqid(rand(), true));
    }

    //check $param which have generateToken()
    public static function checkToken($param)
    {
        if ($param === $_SESSION['token']) {
            return true;
        }

        return false;
    }
    
}