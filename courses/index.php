<?php
//always call core/init.php to initialize the system
require_once "../Core/init.php";


require_once "../Views/Templates/header.php";
?>

<div class="row m-2">
    <div class="col col-md shadow-sm rounded bg-white m-2 py-2">
        <h3>Courses List</h3>
        <hr />
        <?php if ($user->getUser('username', Session::get('examygoUser'))['role'] == 2) { ?>
            <div class="row my-5">
                <div class="col-sm text-center">
                    <a class="btn btn-outline-primary" href="/examygo/courses.php">Add new Courses</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php require_once "../Views/Templates/footer.php"; ?>