<?php
//always call core/init.php to initialize the system
require_once "../Core/init.php";

if (!Session::exists('examygoUser')) {
    Redirect::to('/examygo/user/login.php');
}

$courseId = $course->getCourse('course_id', $_GET['course_id']);

require_once "../Views/Templates/header.php";

?>
<div class="row m-2">
    <div class="col col-md shadow-sm rounded bg-white m-2 py-2">
        <h3>Courses List</h3>
        <hr />
        <?php if (!isset($_GET['course_id']) && !isset($_GET['id'])) { ?>
            <?php if (empty($course->getCourse())) { ?>
                <div class="row my-5">
                    <div class="col-sm text-center">
                        <p>Empty</p>
                    </div>
                </div>
            <?php } else { ?>
                <!-- Info tentang activity, mis: date -> expire -->
                <!-- Hitung Jumlah quiz yg terhubung dengan id activity -->
                <!-- tombol memasukkan token -->
                <!-- validasi token -->
                <!-- redirect ke halaman exam.php -->
                <!-- tekan tombol enroll untuk memulai quiz -->
            <?php } ?>
            <?php if ($user->getUser('username', Session::get('examygoUser'))['role'] == 2) { ?>
                <div class="row my-5">
                    <div class="col-sm text-center">
                        <a class="btn btn-outline-primary" href="/examygo/courses/add.php">Add new quiz</a>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<?php require_once "../Views/Templates/footer.php"; ?>