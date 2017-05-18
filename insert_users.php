<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$department_id = mysqli_real_escape_string($con, $_POST['department_id']);
$user_firstname = mysqli_real_escape_string($con, $_POST['user_firstname']);
$user_lastname = mysqli_real_escape_string($con, $_POST['user_lastname']);
$user_email = mysqli_real_escape_string($con, $_POST['user_email']);
$user_username = mysqli_real_escape_string($con, $_POST['user_username']);
$user_password = mysqli_real_escape_string($con, $_POST['user_password']);

$sql_check_username = "SELECT * FROM tbl_users WHERE user_username = '$user_username'";
$result_check_username = mysqli_query($con, $sql_check_username);
$check_user = mysqli_num_rows($result_check_username);

if ($check_user == 1) {
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'Username (ชื่อผู้ใช้งาน) มีอยู่แล้วในระบบ กรุณาตรวจสอบอีกครั้ง'));
    mysqli_free_result($result_check_username);
    mysqli_close($con);
    exit();
}


$key = "asdf123asdf123asdf123";
$hash_password = hash_hmac('SHA256', $user_password, $key);

//    echo $department_id . " --- " . $user_firstname . " --- " . $user_lastname . " --- " . $user_email . " --- " . $user_username . " --- " . $hash_password;
mysqli_begin_transaction($con);
$sql = "INSERT INTO tbl_users VALUES('0','$user_username','$hash_password','$user_firstname','$user_lastname','$user_email','user','$department_id')";
$result = mysqli_query($con, $sql);

if ($result) {
    mysqli_commit($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'success', 'messages' => 'บันทึกข้อมูลเรียบร้อย'));
} else {
    mysqli_rollback($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
}


mysqli_close($con);
