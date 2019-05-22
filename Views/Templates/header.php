<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Examygo</title>
    <link rel="stylesheet" href="Assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="Assets/fontawesome/css/all.min.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light">
        <a class="navbar-brand" href="/examygo/">EXAMYGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <?php if (Session::exists('username')) { ?>
                    <li class="nav-item">
                        <!-- Example single danger button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= Session::get('examygoUser') ?>&nbsp;<i class="fas fa-user-circle"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <p class="dropdown-header"><?= Session::get('examygoUser') ?></p>
                                <a class="dropdown-item" href="#"><i class="fas fa-user-circle"></i>&nbsp;Profile</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-bell"></i>&nbsp;Notifications</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-book"></i>&nbsp;Courses</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-history"></i>&nbsp;History</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user-cog"></i>&nbsp;Setting</a>
                                <a class="dropdown-item" href="/examygo/logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                            </div>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary my-2 my-sm-0" href="/examygo/login.php">LOGIN</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <div class="container">