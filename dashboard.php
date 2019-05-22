<?php
require_once "Core/init.php";

if (!Session::exists('username')) {
    Session::flash('examygoFlash', 'Anda Harus Login dulu!');
    header('Location: login.php');
}

require_once "Views/Templates/header.php";
?>
<?php if (Session::exists('examygoFlashRegister')) { ?>
    <p class="alert alert-success"><?= Session::flash('examygoFlashRegister'); ?></p>
<?php } ?>

<?php require_once "Views/Templates/footer.php"; ?>