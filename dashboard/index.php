<?php
require_once "../Core/init.php";

if (!Session::exists('examygoUser')) {
    Session::flash('examygoFlash', 'Anda Harus Login dulu!');
    Redirect::to('/examygo/user/login.php');
}

require_once "../Views/Templates/header.php";
?>
<?php if (Session::exists('examygoFlashRegister')) { ?>
    <div class="container mt-3">
        <p class="alert alert-success"><?= Session::flash('examygoFlashRegister'); ?></p>
    </div>
<?php } ?>

<div class="row m-2">
    <div class="col col-md shadow-sm rounded bg-white m-2 py-2">
        <h3>Last Courses</h3>
        <hr />
        <?php if (true) { ?>
            <div class="row my-5">
                <div class="col-12 text-center">
                    <p>Empty</p>
                </div>
                <div class="col-sm text-center">
                    <a class="btn btn-outline-primary" href="/examygo/courses/">Enroll Me</a>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="col my-sidebar shadow-sm rounded bg-white m-2 py-2">
        <h3>Menu</h3>
        <hr />
        <ul>
            <li><a href="/examygo/">Home</a></li>
            <li><a href="/examygo/dashboard/">Dashboard</a></li>
            <li><a href="/examygo/courses/">Courses</a></li>
        </ul>
    </div>
</div>

<?php require_once "../Views/Templates/footer.php"; ?>