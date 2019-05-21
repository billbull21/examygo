<?php
/** 
 * this file is used for register a new user admin.
 */
require_once "Core/init.php";

session_start();
if (!Session::exists('csrf')) {
    Session::set('csrf', Helper::str_rand());
}

if (Input::get('submit')) {

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
            'char'      =>   '/^[a-zA-Z0-9_]*$/',
            'unique'    =>   true
        ],
        'password'  => [
            'required'  =>   true,
            'min'       =>   6,
        ],
        'password2' => [
            'required'  =>  true,
            'match'     =>  true
        ]
    ]);
    //mengecek apakah lolos dari error!
    if ($validasi->passed()) {
        if (Session::get('csrf') == Input::get('csrf')) {
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
            session_unset(Session::get('csrf'));
        }else{
            die('oops!, token is not valid');
        }
        session_destroy();
    } else {
        $errors = $validasi->errors();
    }
}
require_once "Views/Templates/headerInstall.php";
?>

<div class="border p-3 rounded bg-light">
    <h2 class="center">Register</h2>
    <hr />
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="nama_user">Nama<span class="text-danger">*</span></label>
            <?php if (!empty($errors['nama_user'])) : ?><div class="alert alert-danger"><?= $errors['nama_user']; ?></div><?php endif; ?>
            <input type="text" class="form-control" name="nama_user" id="nama" placeholder="Nama Admin/Pengawas/Proktor" value="<?= $_SESSION['nama_user']; ?>" required />
        </div>
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
        <div class="form-group">
            <label for="password2">Konfirmasi Password<span class="text-danger">*</span></label>
            <?php if (!empty($errors['password2'])) : ?><div class="alert alert-danger"><?= $errors['password2']; ?></div><?php endif; ?>
            <input type="password" class="form-control" name="password2" id="password2" placeholder="ulangi password" required />
        </div>
        <input type="hidden" name="csrf" value="<?= Session::get('csrf'); ?>" />
        <input class="btn btn-primary" type="submit" name="submit" value="Submit" />
    </form>
</div>