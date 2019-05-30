<?php
//always call core/init.php to initialize the system
require_once "../Core/init.php";

if (!Session::exists('examygoUser')) {
    Session::set('lastPage', $_SERVER['REQUEST_URI']);
    Redirect::to('/examygo/user/login.php');
}
if (Session::exists('examygoUser') && $user->getUser('username', Session::get('examygoUser'))['role'] <= 1) {
    Redirect::to('/examygo/courses/');
}

$quiz = new Quiz;

$activities = $course->getActivity('activity_id', $_GET['activity_id']);
$course = $course->getCourse('course_id', $_GET['course_id']);

$cid = $_GET['course_id'];
$aid = $_GET['activity_id'];

if (Input::get('submit')) {

    $_SESSION['addquiz'] = $_POST;

    // var_dump($_SESSION['files']['image']['name']);
    // die();

    //call validation class
    $validasi = new Validation;

    //rule validasi
    $validasi = $validasi->check([
        'semester'  => [
            'required'  =>   true,
        ],
    ]);

    if (Helper::checkToken(Input::get('csrf'))) {


        if (!empty($_FILES['audio']['name'])) {
            //audio
            $nama_audio = $_FILES['audio']['name'];
            $asal_audio = $_FILES['audio']['tmp_name'];
            $format_audio = $_FILES['audio']['type'];
            $size_audio = $_FILES['audio']['size'];
            $error_audio = $_FILES['audio']['error'];

            //validasi audio input
            if ($error_audio == 0) {
                if ($size_audio < 3000000) {
                    if ($format_audio == 'audio/mpeg' || $format_audio == 'audio/x-wav') {
                        $nama_audio = time() . '-' . addslashes($nama_audio);
                        move_uploaded_file($asal_audio, '../Assets/Media/Upload/Audio/' . $nama_audio);
                    } else {
                        $errors['audio'] = "format that allowed is .mp3 / .wav";
                    }
                } else {
                    $errors['audio'] = "maximum audio file size is 3mb";
                }
            } else {
                $errors['audio'] = "There is an error!";
            }
        }

        if (!empty($_FILES['image']['name'])) {
            //image
            $nama_image = $_FILES['image']['name'];
            $asal_image = $_FILES['image']['tmp_name'];
            $format_image = $_FILES['image']['type'];
            $size_image = $_FILES['image']['size'];
            $error_image = $_FILES['image']['error'];

            //validasi image input
            if ($error_image == 0) {
                if ($size_image < 3000000) {
                    if ($format_image == 'image/jpeg' || $format_image == 'image/png') {
                        $nama_image = time()  . '-' . addslashes($nama_image);
                        move_uploaded_file($asal_image, '../Assets/Media/Upload/Images/' . $nama_image);
                    } else {
                        $errors['image'] = "format that allowed is .jpg / .png";
                    }
                } else {
                    $errors['image'] = "maximum image file size is 3mb";
                }
            } else {
                $errors['image'] = "There is an error!";
            }
        }
        if (!isset($hash)) {
            $hash = time();
        } else {
            $hash;
        }

        if ($validasi->passed() && empty($errors)) {
            $quizData = $quiz->addQuiz([
                'activity_id'   =>  $activities['activity_id'],
                'course_id'     =>  $course['course_id'],
                'semester'      =>  Input::get('semester'),
                'audio'         =>  $nama_audio,
                'image'         =>  $nama_image,
                'question'      =>  Input::get('question'),
                'answer_key'    =>  Input::get('answer_key'),
                'hash'          =>  $hash
            ]);
            if ($quizData == true) {
                $quizId = $quiz->getQuiz('hash', $hash)['quiz_id'];

                $answer_tags = Input::get('answer_tags');
                $answer_subject = Input::get('answer_subject');
                $total_tags = count($answer_tags);

                $result = $quiz->addAnswer($answer_tags, $answer_subject, $total_tags, [
                    'quiz_id'       =>  $quizId,
                    'activity_id'   =>  $activities['activity_id'],
                    'course_id'     =>  $course['course_id']
                ], $cid, $aid);
            } else {
                //echo "<script>Swal.fire('Sorry!', 'fail to upload data!', 'error');</script>";
                die('ada error!');
            }
        }
    } else {
        Redirect::to('/examygo/courses/');
    }
}
require_once "../Views/Templates/header.php";
?>

<div class="m-3">
    <div class="container-fluid bg-white rounded shadow-lg p-3">
        <?php if (isset($_GET['course_id']) && isset($_GET['activity_id'])) { ?>
            <h2 class="center">Add Quiz For <?= $course['course_full_name']; ?> : <?= $activities['activity_name']; ?></h2>
            <hr />
            <form id="addquiz" action="/examygo/courses/newquiz.php?course_id=<?= $cid ?>&activity_id=<?= $aid ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col col-md">
                        <h4>FORM QUESTION</h4>
                        <div class="form-group">
                            <label for="semester">Semester<span class="text-danger">*</span></label>
                            <?php if (!empty($errors['semester'])) : ?><div class="alert alert-danger"><?= $errors['semester']; ?></div><?php endif; ?>
                            <select class="form-control" name="semester" id="semester" required>
                                <option <?php if (isset($_SESSION['addquiz']['semester']) == "") echo "selected" ?> value="">-- select the semester --</option>
                                <option <?php if (isset($_SESSION['addquiz']['semester']) == "1") echo "selected" ?> value="1">Ganjil</option>
                                <option <?php if (isset($_SESSION['addquiz']['semester']) == "2") echo "selected" ?> value="2">Genap</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputAudio">Upload Audio (.mp3/wav)</label>
                            <?php if (!empty($errors['audio'])) : ?><div class="alert alert-danger"><?= $errors['audio']; ?></div><?php endif; ?>
                            <input type="file" name="audio" class="form-control-file" id="inputAudio" />
                        </div>
                        <div class="form-group">
                            <label for="inputImage">Upload Image (.jpg/.jpeg/.png)</label>
                            <?php if (!empty($errors['image'])) : ?><div class="alert alert-danger"><?= $errors['image']; ?></div><?php endif; ?>
                            <input type="file" name="image" class="form-control-file" id="inputImage" />
                        </div>
                        <div class="form-group">
                            <label for="question">Question<span class="text-danger">*</span></label>
                            <textarea type="text" name="question" id="trumbowyg" required><?php if (isset($_SESSION['addquiz']['question'])) echo $_SESSION['addquiz']['question']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="answer_key">Answer Key for the Question<span class="text-danger">*</span></label>
                            <?php if (!empty($errors['answer_key'])) : ?><div class="alert alert-danger"><?= $errors['answer_key']; ?></div><?php endif; ?>
                            <select class="form-control" name="answer_key" required>
                                <option <?php if (isset($_SESSION['addquiz']) == "") echo 'selected' ?> value="" selected>-- select the answer key --</option>
                                <option <?php if (isset($_SESSION['addquiz']) == "A") echo 'selected' ?> value="A">A</option>
                                <option <?php if (isset($_SESSION['addquiz']) == "B") echo 'selected' ?> value="B">B</option>
                                <option <?php if (isset($_SESSION['addquiz']) == "C") echo 'selected' ?> value="C">C</option>
                                <option <?php if (isset($_SESSION['addquiz']) == "D") echo 'selected' ?> value="D">D</option>
                                <option <?php if (isset($_SESSION['addquiz']) == "E") echo 'selected' ?> value="E">E</option>
                            </select>
                        </div>
                    </div>
                    <div class="col my-asidebar rounded bg-white">
                        <h4>FORM ANSWER</h4>
                        <!-- Mengisi Jawaban -->
                        <div class="form-group border rounded p-2">
                            <label for="answer_subject">Form Answer A<span class="text-danger">*</span></label>
                            <label class="d-block">Answer Tags</label>
                            <select class="form-control" name="answer_tags[]" required>
                                <option value="A" selected>A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                            <?php if (!empty($errors['answer_subject'])) : ?><div class="alert alert-danger"><?= $errors['answer_subject']; ?></div><?php endif; ?>
                            <label>Answer Subject</label>
                            <textarea type="text" class="form-control" name="answer_subject[]" id="answer_subject" required><?php if (isset($_SESSION['addquiz']['answer_subject'])) echo $_SESSION['addquiz']['answer_subject'][0]; ?></textarea>
                        </div>
                        <div class="form-group border rounded p-2">
                            <label for="answer_subject">Form Answer B<span class="text-danger">*</span></label>
                            <label class="d-block">Answer Tags</label>
                            <select class="form-control" name="answer_tags[]" required>
                                <option value="A">A</option>
                                <option value="B" selected>B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                            <?php if (!empty($errors['answer_subject'])) : ?><div class="alert alert-danger"><?= $errors['answer_subject']; ?></div><?php endif; ?>
                            <label>Answer Subject</label>
                            <textarea type="text" class="form-control" name="answer_subject[]" id="answer_subject" required><?php if (isset($_SESSION['addquiz']['answer_subject'])) echo $_SESSION['addquiz']['answer_subject'][1]; ?></textarea>
                        </div>
                        <div class="form-group border rounded p-2">
                            <label for="answer_subject">Form Answer C<span class="text-danger">*</span></label>
                            <label class="d-block">Answer Tags</label>
                            <select class="form-control" name="answer_tags[]" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C" selected>C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                            <?php if (!empty($errors['answer_subject'])) : ?><div class="alert alert-danger"><?= $errors['answer_subject']; ?></div><?php endif; ?>
                            <label>Answer Subject</label>
                            <textarea type="text" class="form-control" name="answer_subject[]" id="answer_subject" required><?php if (isset($_SESSION['addquiz']['answer_subject'])) echo $_SESSION['addquiz']['answer_subject'][2]; ?></textarea>
                        </div>
                        <div class="form-group border rounded p-2">
                            <label for="answer_subject">Form Answer D<span class="text-danger">*</span></label>
                            <label class="d-block">Answer Tags</label>
                            <select class="form-control" name="answer_tags[]" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D" selected>D</option>
                                <option value="E">E</option>
                            </select>
                            <?php if (!empty($errors['answer_subject_d'])) : ?><div class="alert alert-danger"><?= $errors['answer_subject']; ?></div><?php endif; ?>
                            <label>Answer Subject</label>
                            <textarea type="text" class="form-control" name="answer_subject[]" id="answer_subject" required><?php if (isset($_SESSION['addquiz']['answer_subject'])) echo $_SESSION['addquiz']['answer_subject'][3]; ?></textarea>
                        </div>
                        <div class="form-group border rounded p-2">
                            <label for="answer_subject">Form Answer E<span class="text-danger">*</span></label>
                            <label class="d-block">Answer Tags</label>
                            <select class="form-control" name="answer_tags[]" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E" selected>E</option>
                            </select>
                            <?php if (!empty($errors['answer_subject_e'])) : ?><div class="alert alert-danger"><?= $errors['answer_subject']; ?></div><?php endif; ?>
                            <label>Answer Subject</label>
                            <textarea type="text" class="form-control" name="answer_subject[]" id="answer_subject" required><?php if (isset($_SESSION['addquiz']['answer_subject'])) echo $_SESSION['addquiz']['answer_subject'][4]; ?></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="csrf" name="csrf" value="<?= Helper::generateToken() ?>" />
                <?php if (!empty($errors['universal'])) : ?><div class="alert alert-danger"><?= $errors['universal']; ?></div><?php endif; ?>
                <input class="btn btn-primary btn-block" type="submit" name="submit" id="submit" value="Add" />
            </form>
        <?php } else { ?>
            <p class="alert alert-danger">Invalid URL</p>
            <a class="btn btn-primary" href="/examygo/dashboard/">Back To Dashboard</a>
        <?php } ?>
    </div>
</div>

<?php require_once "../Views/Templates/footer.php"; ?>