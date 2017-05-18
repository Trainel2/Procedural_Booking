<?php

session_start();
date_default_timezone_set("Asia/Bangkok");
//เช็คว่า $_session['login_id'] มีค่ารึเปล่าถ้าไม่มีทำการ redirect กลับไปหน้า login
if (!isset($_SESSION['login_id'])) {
    header("Location: login.php");
    exit();
}

// //เช็คว่า $_session['login_id'] มีค่ารึเปล่าถ้าไม่มีทำการ redirect กลับไปหน้า login
// if ($_SESSION['user_active'] === '1') {
//     header("Location: login.php");
// }

require 'ConnectDB.php';
$session_login_id = $_SESSION['login_id'];

//query ข้อมูลเก็บไว้ในตัวแปร เพื่อใช้งานในหน้าต่างๆ
$qry_user = "SELECT * FROM tbl_users WHERE user_id='$session_login_id'";
$result_user = mysqli_query($con, $qry_user);
if ($result_user) {
    $row_user = mysqli_fetch_assoc($result_user);
    $s_login_id = $row_user['user_id'];
    $s_login_username = $row_user['user_username'];
    $s_login_firstname = $row_user['user_firstname'];
    $s_login_status = $row_user['user_status'];
    mysqli_free_result($result_user);
}
