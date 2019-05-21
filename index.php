<?php
require_once "Core/init.php";

if (file_exists('install.php') && !file_exists('config.php')) {
    Redirect::to('install');
}else if ( file_exists('install.php') && file_exists('config.php') ) {
    if(unlink('install.php')){
        Redirect::to('index');
    }

    return false;
}else if ($user->getUser == false) {
    Redirect::to('register');
}



require_once "Views/Templates/header.php";
?>

<?php require_once "Views/Templates/footer.php"; ?>
