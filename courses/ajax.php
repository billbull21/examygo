<?php

require_once "../Core/init.php";

if (!Session::exists('examygoUser')) {
    Redirect::to('/examygo/user/login.php');
}


if (!empty($_POST)) {

    $date = $_POST['activity_date'];
    $date = explode('/', $date);
    $larik= [$date[2],$date[0],$date[1]];
    $date = implode('-',$larik);

    $clock = $_POST['clock'].':00';
    $date = $date.' '.$clock;

    $expiredate = $_POST['activity_expire'];
    $expiredate = explode('/', $expiredate);
    $explarik = [$expiredate[2], $expiredate[0], $expiredate[1]];
    $expiredate = implode('-', $explarik);

    $expclock = $_POST['expireclock'] . ':00';
    $expiredate = $expiredate . ' ' . $expclock;

    $masuk = $course->addActivity([
        'activity_name'         =>  $_POST['activity_name'],
        'activity_date'         =>  $date,
        'activity_expire'       =>  $expiredate,
        'course_id'             =>  $_POST['course_id']
    ]);

    //flash message
    if ($masuk) {
        echo "<li><a href='/examygo/courses/activity.php?id=".$_POST['course_id']."'>".$_POST[ 'activity_name']."</a></li>";
    }else{
        echo "gagal";
    }
}else{
    echo 'gagal';
}