<?php
/**
 * this file is only for backup if you loss install.php
 * 
 * 
 * rename or duplicate this, if you want to reconfigure your app.
 */
require_once "Classes/Helper.php";
session_start();

if (isset($_POST['submit'])) {
    if (Helper::checkToken($_POST['csrf'])) {
        //membuat file config.php
        $file_config = fopen('config.php', 'w+');
        fwrite($file_config, "<?php \r\n");
        fwrite($file_config, "\$get_HOST='" . $_POST['dbhost'] . "'; \r\n");
        fwrite($file_config, "\$get_USER='" . $_POST['dbuser'] . "'; \r\n");
        fwrite($file_config, "\$get_PASS='" . $_POST['dbpass'] . "'; \r\n");
        fwrite($file_config, "\$get_NAME='" . $_POST['dbname'] . "'; \r\n");
        fwrite($file_config, "?>");
        fclose($file_config);

        unset($_SESSION['csrf']);
        header('Location: install.php?success=true');
    } else {
        header('Location: install.php');
    }
}

if (isset($_POST['confirm'])) {
    if (Helper::checkToken($_POST['csrf'])) {
        header('Location: index.php');
    }
}
require_once 'Views/Templates/headerInstall.php';
?>

<?php if ($_GET['success'] == true) : ?>
    <div class="border p-3 bg-light" style="border-radius:4px;">
        <p class="alert alert-warning">Congratulations!, you have done installation examygo</p>
        <form action="install.php?success=true" method="post">
            <input type="hidden" name="csrf" value="<?= Helper::generateToken() ?>" />
            <button name="confirm" type="submit" class="btn btn-primary">Confirm</button>
        </form>
    </div>
<?php endif; ?>

<?php if (substr($_SERVER['REQUEST_URI'], -11) == 'install.php') : ?>
    <div class="border p-3 bg-light" style="border-radius:4px;">
        <div class="jumbotron">
            <h2>Install Examygo</h2>
            <hr />
            <h4>Configure Your Database!</h4>
            <p>Please, fill in the form to install Examygo!</p>
            <p><i>Happy Install!!!</i></p>
        </div>
        <div class="alert alert-warning">Fill it the form with your database cridential!</div>
        <form action="install.php" method="POST">
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
            <input type="hidden" name="csrf" value="<?= Helper::generateToken() ?>" />
            <p>if, you hit the submit button. you agree with our policy & privacy!</p>
            <input class="btn btn-primary" type="submit" name="submit" value="Submit" />
        </form>
    </div>
<?php endif; ?>