<?php
//always call core/init.php to initialize the system
require_once "../Core/init.php";

if (!Session::exists('examygoUser')) {
    Session::set('lastPage', $_SERVER['REQUEST_URI']);
    Redirect::to('/examygo/user/login.php');
}

$quiz = new Quiz;

$activity = $course->getActivity('activity_id', $_GET['id']);
$courseId = $course->getCourse('course_id', $_GET['course_id']);
$quizs = $quiz->getQuiz();

require_once "../Views/Templates/header.php";

?>
<div class="row m-2">
    <div class="col col-md shadow-sm rounded bg-white m-2 py-2">
        <h3><?= $courseId['course_full_name']; ?> : <?= $activity['activity_name']; ?></h3>
        <hr />
        <?php if (isset($_GET['course_id']) && isset($_GET['id'])) { ?>
            <?php if (empty($quizs)) { ?>
                <div class="row mt-5">
                    <div class="col-sm text-center">
                        <p>Empty</p>
                    </div>
                </div>
            <?php } else { ?>
                <!-- Info tentang activity, mis: date -> expire -->
                <div class="warning text-center py-3 rounded" style="background: #bffff3">
                    <?php if ($activity['status'] == 0) { ?>
                        <p>not submitted yet</p>
                        <p>Courses From : <?= $courseId['course_full_name'] ?></p>
                        <?php if (date('d M Y H:i', strtotime($activity['activity_expire'])) < date('d M Y H:i')){ ?>
                            <p class="text-danger">Was Expired</p>
                        <?php } else { ?>
                            <p>Will Expired on : <?= date('d M Y H:i', strtotime($activity['activity_expire'])); ?></p>
                        <?php } ?>
                        <p><?= date('l, d M Y H:i') ?></p>
                        <button type="submit" class="btn btn-primary" id="masuk">Enroll Me</button>
                    <?php } else { ?>
                        <p>submitted on : </p>
                        <p>Courses From : <?= $course['course_full_name'] ?></p>
                        <a class="btn btn-light" href="/examygo/courses/">Back To Courses</a>
                    <?php } ?>
                </div>
                <!-- Hitung Jumlah quiz yg terhubung dengan id activity -->
                <!-- tombol memasukkan token -->
                <!-- validasi token -->
                <!-- redirect ke halaman exam.php -->
                <!-- tekan tombol enroll untuk memulai quiz -->
            <?php } ?>
            <?php if ($user->getUser('username', Session::get('examygoUser'))['role'] == 2) { ?>
                <div class="row my-5">
                    <div class="col-sm text-center">
                        <a class="btn btn-outline-primary" href="/examygo/courses/newquiz.php?course_id=<?= $courseId['course_id'] ?>&activity_id=<?= $activity['activity_id'] ?>">Add new quiz</a>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p class="alert alert-danger">Invalid URL</p>
            <a class="btn btn-primary" href="/examygo/dashboard/">Back To Dashboard</a>
        <?php } ?>
    </div>
</div>
<?php require_once "../Views/Templates/footer.php"; ?>