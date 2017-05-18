<?php

require("ConnectDB.php");

$user_username = mysqli_real_escape_string($con, $_POST['user_username']);
$user_password = mysqli_real_escape_string($con, $_POST['user_password']);

$key = "asdf123asdf123asdf123";
$hash_password = hash_hmac('SHA256', $user_password, $key);

//ดึงข้อมูลจาก DB โดยใช้การดึงข้อมูลแบบ param (พารามิเตอร์)
$sql = "SELECT * FROM tbl_users WHERE user_username=? AND user_password=?";
$stmt = mysqli_prepare($con, $sql);
//กำหนดพารามิเตอร์ "ss"
mysqli_stmt_bind_param($stmt, "ss", $user_username, $hash_password);
mysqli_execute($stmt);
$result_user = mysqli_stmt_get_result($stmt);

if ($result_user->num_rows == 1) {
    session_start();
    $row_user = mysqli_fetch_array($result_user, MYSQLI_ASSOC);
    $_SESSION['login_id'] = $row_user['user_id'];
    //$_SESSION['user_active'] = $row_user['user_active'];
    header("Location: index.php");
} else {
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'กรุณาตรวจสอบ Username และ Password ใหม่อีกครั้ง'));
}
