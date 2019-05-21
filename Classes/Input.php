<?php

class Input{

    public static function get($nama)
    {
        if (isset($_GET[$nama])) {
            return $_GET[$nama];
        }else if (isset($_POST[$nama])) {
            return $_POST[$nama];
        }
    }

}