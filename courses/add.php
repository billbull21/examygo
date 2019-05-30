<?php
//always call core/init.php to initialize the system
require_once "../Core/init.php";

if (!Session::exists('examygoUser')) {
    Redirect::to('/examygo/user/login.php');
}
if (Session::exists('examygoUser') && $user->getUser('username', Session::get('examygoUser'))['role'] <= 1) {
    Redirect::to('/examygo/courses/');
}

if (Input::get('submit')) {

    if (Helper::checkToken(Input::get('csrf'))) {
        //secure user input into a session
        $_SESSION['addcourse'] = $_POST;
        //call validation class
        $validasi = new Validation;

        //rule validasi
        $validasi = $validasi->check([
            'course_full_name'  => [
                'required'  =>   true,
                'min'       =>   4,
                'max'       =>   30,
                'char'      =>   '/^[a-zA-Z0-9 ]*$/',
            ],
            'course_short_name'  => [
                'required'  =>   true,
                'min'       =>   4,
                'max'       =>   30,
                'char'      =>   '/^[a-zA-Z0-9 ]*$/'
            ]
        ]);

        // var_dump($validasi->passed());
        // die();
        //check if $validasi is passed (true)
        if ($validasi->passed()) {
            if ($course->getCourse('course_full_name', Input::get('course_full_name')) == false && $course->getCourse('course_short_name', Input::get('course_short_name')) == false) {
                $course->addCourse([
                    'course_full_name'  =>  Input::get('course_full_name'),
                    'course_short_name' =>  Input::get('course_short_name'),
                    'course_visibility' =>  Input::get('course_visibility')
                ]);
                //flash message
                Session::flash('examygoFlashRegister', 'Berhasil menambahkan data baru!');
                Redirect::to('/examygo/courses/');
            } else {
                $errors['universal'] = "Data sudah ada!";
            }
        } else {
            $errors = $validasi->errors();
        }
    } else {
        Redirect::to('/examygo/courses/add.php');
    }
}
require_once "../Views/Templates/header.php";
?>

<div class="row justify-content-center m-2">
    <div class="col my-boxes border p-3 rounded bg-white shadow-lg mt-3">
        <h2 class="center">Add new courses</h2>
        <hr />
        <form action="add.php" method="POST">
            <div class="form-group">
                <label for="course_full_name">Course Full Name (title)<span class="text-danger">*</span></label>
                <?php if (!empty($errors['course_full_name'])) : ?><div class="alert alert-danger"><?= $errors['course_full_name']; ?></div><?php endif; ?>
                <input type="text" class="form-control" name="course_full_name" id="course_full_name" value="<?php if (isset($_SESSION['addcourse']['course_full_name'])) echo $_SESSION['addcourse']['course_full_name']; ?>" required />
            </div>
            <div class="form-group">
                <label for="course_short_name">Course Short Name<span class="text-danger">*</span></label>
                <?php if (!empty($errors['course_short_name'])) : ?><div class="alert alert-danger"><?= $errors['course_short_name']; ?></div><?php endif; ?>
                <input type="text" class="form-control" name="course_short_name" id="course_short_name" value="<?php if (isset($_SESSION['addcourse']['course_short_name'])) echo $_SESSION['addcourse']['course_short_name']; ?>" required />
            </div>
            <div class="form-group">
                <label for="course_visibility">Course Visibility</label>
                <p class="font-italic small">if, you set into hidden. only admin and teacher can access it!</p>
                <?php if (!empty($errors['course_visibility'])) : ?><div class="alert alert-danger"><?= $errors['course_visibility']; ?></div><?php endif; ?>
                <select name="course_visibility" class="form-control" id="course_visibility">
                    <option value="0">Hidden</option>
                    <option value="1" selected>Show</option>
                </select>
            </div>
            <input type="hidden" name="csrf" value="<?= Helper::generateToken() ?>" />
            <?php if (!empty($errors['universal'])) : ?><div class="alert alert-danger"><?= $errors['universal']; ?></div><?php endif; ?>
            <input class="btn btn-primary btn-block" type="submit" name="submit" value="Add" />
        </form>
    </div>
</div>
<?php require_once "../Views/Templates/footer.php"; ?>