<?php

session_start();

spl_autoload_register(function($class){
    require_once '../Classes/'.$class.'.php';
});

$user = new User;
$course = new Course;