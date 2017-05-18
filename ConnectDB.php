<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'meetingroom';

    $con = mysqli_connect($host, $user, $password, $database);
    mysqli_set_charset($con, 'UTF8');

    if ($con == FALSE) {
      echo 'เกิดข้อผิดพลาด : ' .  mysqli_connect_error();
    }
