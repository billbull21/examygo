<?php
require_once "Core/init.php";

if (file_exists('install.php') && !file_exists('config.php')) {
    Redirect::to('install');
}else if ( file_exists('install.php') && file_exists('config.php') ) {
    if(unlink('install.php')){
        Redirect::to('index');
    }

    return false;
}

Database::getInstance();

echo "test";