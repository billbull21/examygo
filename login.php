<?php
/** 
 * this file is used for register a new user admin.
 */
require_once "Core/init.php";

if (Session::exists('examygoUser')) {
    header('Location: dashboard.php');
}

if (Input::get('submit')) {

    if (Helper::checkToken(Input::get('csrf'))) {
        //menjaga isi form tidak hilang saat validasi gagal
        $_SESSION = $_POST;
        //panggil kelas validasi
        $validasi = new Validation;

        //rule validasi
        $validasi = $validasi->check([
            'username'  => ['required'  =>   true],
            'password'  => ['required'  =>   true]
        ]);
        //mengecek apakah lolos dari error!
        if ($validasi->passed()) {
            //memasukkan data ke database
            if ($user->loginUser(Input::get('username'), Input::get('password'))) {
                //make a session for login authentication
                Session::set('examygoUser', Input::get('username'));
                Redirect::to('dashboard');
            } else {
                $errors['username'] = 'Login gagal!';
            }
        } else {
            $errors = $validasi->errors();
        }
    } else {
        die('oops!, token is not valid');
    }
}
require_once "Views/Templates/header.php";
?>

<?php if (Session::exists('examygoFlash')) { ?>
    <p class="alert alert-success"><?= Session::flash('examygoFlash'); ?></p>
<?php } ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-4 border p-3 rounded bg-white shadow-lg mt-3">
            <h2 class="center">Login</h2>
            <hr />
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username<span class="text-danger">*</span></label>
                    <?php if (!empty($errors['username'])) : ?><div class="alert alert-danger"><?= $errors['username']; ?></div><?php endif; ?>
                    <input type="text" class="form-control" name="username" id="username" placeholder="admin" value="<?= $_SESSION['username']; ?>" required />
                </div>
                <div class="form-group">
                    <label for="password">Password<span class="text-danger">*</span></label>
                    <?php if (!empty($errors['password'])) : ?><div class="alert alert-danger"><?= $errors['password']; ?></div><?php endif; ?>
                    <input type="password" class="form-control" name="password" id="password" placeholder="password" required />
                </div>
                <input type="hidden" name="csrf" value="<?= Helper::generateToken() ?>" />
                <input class="btn btn-primary btn-block" type="submit" name="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>