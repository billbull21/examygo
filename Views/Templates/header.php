<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Examygo</title>
    <!-- Stylesheet -->
    <link rel="stylesheet" href="../Assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../Assets/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../Assets/clockpicker/jquery-clockpicker.min.css">
    <link rel="stylesheet" href="../Assets/css/style.css" />
    <link rel="stylesheet" href="../Assets/sweetalert2/dist/sweetalert2.min.css" />
    <link rel="stylesheet" href="../Assets/jquery-ui-1.11.4/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="../Assets/jquery-ui-1.11.4/jquery-ui.theme.css" />
    <!-- javascript -->
    <script src="../Assets/js/jquery.slim.min.js"></script>
    <script src="../Assets/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="../Assets/jquery-ui-1.11.4/jquery-ui.js"></script>
    <script src="../Assets/jquery-ui-1.11.4/jquery-ui.min.js"></script>
</head>

<body class="bg-light">
    <div class="post-wrapper">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white shadow-sm">
            <h2>
                <button class="navbar-toggler d-inline" id="trigger" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="/examygo/">EXAMYGO</a>
            </h2>
            <ul class="nav navbar-nav ml-auto">
                <?php if (Session::exists('examygoUser')) { ?>
                    <li class="nav-item">
                        <!-- Example single danger button -->
                        <div class="dropdown">
                            <button type="button" class="btn btn-outline-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $user->getUser('username', Session::get('examygoUser'))['nama_user']; ?>&nbsp;<i class="fas fa-user-circle"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right position-absolute" aria-labelledby="dropdownMenuButton">
                                <p class="dropdown-header"><?= Session::get('examygoUser') ?></p>
                                <a class="dropdown-item" href="#"><i class="fas fa-user-circle"></i>&nbsp;Profile</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-bell"></i>&nbsp;Notifications</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-history"></i>&nbsp;History</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user-cog"></i>&nbsp;Setting</a>
                                <a class="dropdown-item" href="/examygo/user/logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                            </div>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary my-2 my-sm-0" href="/examygo/user/login.php">LOGIN</a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <div class="shadow-sm bg-white h-100 side-slide" id="slider">
            <div class="menu">
                <li><a href="/examygo/dashboard/"><i class="fas fa-tachometer-alt"></i>&nbsp;Dashboard</a></li>
                <li><a href="/examygo/courses/"><i class="fas fa-book"></i>&nbsp;Courses</a></li>
                <?php if ($user->getUser('username', Session::get('examygoUser'))['role'] == 2 || $user->getUser('username', Session::get('examygoUser'))['role'] == 1) :  ?>
                    <li><a href="/examygo/office/"><i class="fas fa-building"></i>&nbsp;Office</a></li>
                <?php endif; ?>
                <?php if (($user->getUser('username', Session::get('examygoUser'))['role'] == 2 || $user->getUser('username', Session::get('examygoUser'))['role'] == 1) && isset($courseId)) { ?>
                    <li><a href="/examygo/office/"><i class="fas fa-users"></i>&nbsp;Participant</a></li>
                <?php } ?>
            </div>
        </div>
        <div class="container-fluid m-0 p-0 float-right clearfix" id="content">