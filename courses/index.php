<?php
//always call core/init.php to initialize the system
require_once "../Core/init.php";

if (!Session::exists('examygoUser')) {
    Session::set('lastPage', $_SERVER['REQUEST_URI']);
    Redirect::to('/examygo/user/login.php');
}

$courses = $course->getCourse();

require_once "../Views/Templates/header.php";
?>

<div class="row m-2">
    <div class="col col-md shadow-sm rounded bg-white m-2 py-2">
        <h3>Courses List</h3>
        <hr />
        <?php if (empty($course->getCourse())) { ?>
            <div class="row my-5">
                <div class="col-sm text-center">
                    <p>Empty</p>
                </div>
            </div>
        <?php } else { ?>
            <?php foreach ($courses as $course) { ?>
                <div class="my-3">
                    <ul>
                        <li><a href="/examygo/courses/view.php?id=<?= $course['course_id']; ?>"><?= $course['course_full_name'] ?></a></li>
                    </ul>
                </div>
            <?php } ?>
        <?php } ?>
        <?php if ($user->getUser('username', Session::get('examygoUser'))['role'] == 2) { ?>
            <div class="row my-5">
                <div class="col-sm text-center">
                    <a class="btn btn-outline-primary" href="/examygo/courses/add.php">Add new Courses</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php require_once "../Views/Templates/footer.php"; ?>