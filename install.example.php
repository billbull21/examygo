<?php
/**
 * this file is only for backup if you loss install.php
 * 
 * 
 * rename or duplicate this, if you want to reconfigure your app.
 */
if (isset($_POST['submit'])) {
    //validasi
    $db_connect = [
        'HOST'  =>  $_POST['dbhost'],
        'USER'  =>  $_POST['dbuser'],
        'PASS'  =>  $_POST['dbpass'],
        'NAME'  =>  $_POST['dbname'],
    ];
}

require_once 'Views/Templates/headerInstall.php';
?>

<?php if ($_GET['success'] == true) : ?>
    <div class="border p-3 bg-light" style="border-radius:4px;">
        <p class="alert alert-warning">Copy this script below, and create a file "config.php" into root directory examygo and paste to it!</p>
        <div class="card bg-light p-3" style="border-radius:4px;">
            <div class="border p-2 mb-3" style="border-radius:4px;">
                <p><?= htmlspecialchars('<?php') ?></p>
                <p><?= htmlspecialchars('//copy this and paste it into a config.php file') ?></p>
                <p>$get_HOST = <?= "'" . $db_connect['HOST'] . "';"; ?></p>
                <p>$get_USER = <?= "'" . $db_connect['USER'] . "';"; ?></p>
                <p>$get_PASS = <?= "'" . $db_connect['PASS'] . "';"; ?></p>
                <p>$get_NAME = <?= "'" . $db_connect['NAME'] . "';"; ?></p>
                <p><?= "?>" ?></p>
            </div>
            <p class="alert alert-warning"><i>Note!: pastikan konfigurasi yang tertera diatas sesuai dengan database milik anda dan sudah membuat file config.php</i></p>
            <form action="index.php" method="post">
                <button name="confirm" type="submit" class="btn btn-primary">KONFIRMASI</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php if ($_GET['success'] == false || substr($_SERVER['REQUEST_URI'], -11) == 'install.php') : ?>
    <div class="border p-3 bg-light" style="border-radius:4px;">
        <div class="jumbotron">
            <h2>Install Examygo</h2>
            <hr />
            <h4>Configure Your Database!</h4>
            <p>Please, fill in the form to install Examygo!</p>
            <p><i>Happy Install!!!<i></p>
        </div>
        <div class="alert alert-warning">Fill it the form with your database cridential!</div>
        <form action="install.php?success=true" method="POST">
            <div class="form-group">
                <label for="DB_HOST">DATABASE HOST<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="dbhost" id="DB_HOST" placeholder="localhost" required />
            </div>
            <div class="form-group">
                <label for="DB_USER">DATABASE USER<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="dbuser" id="DB_USER" placeholder="root" required />
            </div>
            <div class="form-group">
                <label for="DB_PASS">DATABASE PASSWORD<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="dbpass" id="DB_PASS" placeholder="root" required />
            </div>
            <div class="form-group">
                <label for="DB_NAME">DATABASE NAME<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="dbname" id="DB_NAME" placeholder="examygo" required />
            </div>
            <input type="hidden" name="" />
            <p>if, you hit the submit button. you agree with our policy & privacy!</p>
            <input class="btn btn-primary" type="submit" name="submit" value="Submit" />
        </form>
    </div>
<?php endif; ?>