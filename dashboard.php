<?php
require_once "Core/init.php";

if (!Session::exists('username')) {
    Session::flash('examygoFlash', 'Anda Harus Login dulu!');
    header('Location: login.php');
}

require_once "Views/Templates/header.php";
?>
<div class="container">
    <?php if (Session::exists('examygoFlashRegister')) { ?>
        <p class="alert alert-success"><?= Session::flash('examygoFlashRegister'); ?></p>
    <?php } ?>
</div>

<div class="row m-3">
    <div class="col shadow-sm rounded bg-white mr-3">
        1 of 3
    </div>
    <div class="col-6 shadow-sm rounded bg-white">
        2 of 3 (wider)
    </div>
    <div class="col shadow-sm rounded bg-white ml-3">
        3 of 3
    </div>
</div>

<?php require_once "Views/Templates/footer.php"; ?>