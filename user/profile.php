<?php

if (!Session::exists('examygoUser')) {
    Session::set('lastPage', $_SERVER['REQUEST_URI']);
    Redirect::to('/examygo/user/login.php');
}

?>