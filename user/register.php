<?php
/** 
 * this file is used for register a new user admin.
 */
require_once "../Core/init.php";

if (Session::exists('examygoUser')) {
    Redirect::to('/examygo/dashboard/');
}

if (Input::get('submit')) {

    if (Helper::checkToken(Input::get('csrf'))) {
        //menjaga isi form tidak hilang saat validasi gagal
        $_SESSION = $_POST;
        //panggil kelas validasi
        $validasi = new Validation;

        //rule validasi
        $validasi = $validasi->check([
            'nama_user'  => [
                'required'  =>   true,
                'min'       =>   3,
                'max'       =>   30,
                'char'      =>   '/^[a-zA-Z ]*$/',
                'unique'    =>   true
            ],
            'username'  => [
                'required'  =>   true,
                'min'       =>   3,
                'max'       =>   30,
                'char'      =>   '/^[a-z0-9_]*$/',
                'unique'    =>   true
            ],
            'password'  => [
                'required'  =>   true,
                'min'       =>   6
            ],
            'password2' => [
                'required'  =>  true,
                'match'     =>  true
            ]
        ]);

        // var_dump($validasi->passed());
        // die();
        //mengecek apakah lolos dari error!
        if ($validasi->passed()) {
            if ($user->getUser() == false) {
                $user->registerUser([
                    'nama_user'     =>  Input::get('nama_user'),
                    'username'      =>  Input::get('username'),
                    'password'      =>  password_hash(Input::get('password'), PASSWORD_DEFAULT),
                    'role'          =>  2 //0 user biasa, 1 pengawas, 2 super user / admin [default = 0]
                ]);
            } else {
                $user->registerUser([
                    'nama_user'     =>  Input::get('nama_user'),
                    'username'      =>  Input::get('username'),
                    'password'      =>  password_hash(Input::get('password'), PASSWORD_DEFAULT)
                ]);
            }
            //flash message
            Session::flash('examygoFlashRegister', 'Berhasil menambahkan data baru!');
            //make a session for login authentication
            Session::set('examygoUser', Input::get('username'));
            Redirect::to('/examygo/dashboard/');
        } else {
            $errors = $validasi->errors();
        }
    } else {
        die('oops!, token is not valid');
    }
}
require_once "../Views/Templates/header.php";
?>

<div class="row justify-content-center m-2">
    <div class="col my-boxes border p-3 rounded bg-white shadow-lg mt-3">
        <h2 class="center">Register</h2>
        <hr />
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="nama_user">Nama<span class="text-danger">*</span></label>
                <?php if (!empty($errors['nama_user'])) : ?><div class="alert alert-danger"><?= $errors['nama_user']; ?></div><?php endif; ?>
                <input type="text" class="form-control" name="nama_user" id="nama" placeholder="Nama Admin/Pengawas/Proktor" value="<?php if (isset($_SESSION['nama_user'])) echo $_SESSION['nama_user']; ?>" required />
            </div>
            <div class="form-group">
                <label for="username">Username<span class="text-danger">*</span></label>
                <?php if (!empty($errors['username'])) : ?><div class="alert alert-danger"><?= $errors['username']; ?></div><?php endif; ?>
                <input type="text" class="form-control" name="username" id="username" placeholder="admin" value="<?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?>" required />
            </div>
            <div class="form-group">
                <label for="password">Password<span class="text-danger">*</span></label>
                <?php if (!empty($errors['password'])) : ?><div class="alert alert-danger"><?= $errors['password']; ?></div><?php endif; ?>
                <input type="password" class="form-control" name="password" id="password" placeholder="password" required />
            </div>
            <div class="form-group">
                <label for="password2">Konfirmasi Password<span class="text-danger">*</span></label>
                <?php if (!empty($errors['password2'])) : ?><div class="alert alert-danger"><?= $errors['password2']; ?></div><?php endif; ?>
                <input type="password" class="form-control" name="password2" id="password2" placeholder="ulangi password" required />
            </div>
            <input type="hidden" name="csrf" value="<?= Helper::generateToken() ?>" />
            <input class="btn btn-primary btn-block" type="submit" name="submit" value="Submit" />
        </form>
    </div>
</div>

<?php require_once "../Views/Templates/footer.php"; ?>