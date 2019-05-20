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

require_once "Views/Templates/header.php";
?>

<h1>Halaman Index</h1>

<?php require_once "Views/Templates/footer.php"; ?>
