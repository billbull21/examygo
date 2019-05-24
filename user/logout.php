<?php

require_once "../Core/init.php";
session_destroy();
Redirect::to('/examygo/user/login.php');

?>