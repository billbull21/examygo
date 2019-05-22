<?php
require_once "Core/init.php";

if (Session::exists('examygoUser')) {
    Redirect::to('dashboard');
}

require_once "Views/Templates/header.php";
?>

<?php if (Session::exists('examygoFlash')) { ?>
    <p class="alert alert-success"><?= Session::flash('examygoFlash'); ?></p>
<?php } ?>