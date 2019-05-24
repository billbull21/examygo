<?php

require_once "Core/init.main.php";
if (file_exists('install.php') && !file_exists('config.php')) {
    Redirect::to('install');
}else if ( file_exists('install.php') && file_exists('config.php') ) {
    if(unlink('install.php')){
        Redirect::to('index');
    }
    
    return false;
}else if ($user->getUser() == false) {
    Redirect::to('/examygo/user/register.php');
}else{
    Redirect::to('/examygo/dashboard/');
}






require_once "Views/Templates/headerInstall.php";
?>

<?php require_once "Views/Templates/footer.php"; ?>
