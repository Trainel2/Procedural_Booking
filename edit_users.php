<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$user_id = mysqli_real_escape_string($con, $_POST['user_id']);
$user_firstname = mysqli_real_escape_string($con, $_POST['user_firstname']);
$user_lastname = mysqli_real_escape_string($con, $_POST['user_lastname']);
$user_email = mysqli_real_escape_string($con, $_POST['user_email']);
$user_username = mysqli_real_escape_string($con, $_POST['user_username']);
$user_password = mysqli_real_escape_string($con, $_POST['user_password']);
$user_status = mysqli_real_escape_string($con, $_POST['user_status']);
$department_id = mysqli_real_escape_string($con, $_POST['department_id']);


if ($user_password === '') {
    //ไม่มีการเปลี่ยนรหัสผ่าน
    mysqli_begin_transaction($con);
    $sql_update = "UPDATE tbl_users SET user_username = '$user_username', user_firstname ='$user_firstname', user_lastname = '$user_lastname', user_email = '$user_email', user_status ='$user_status', department_id = '$department_id' WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $sql_update);

    if ($result) {
        mysqli_commit($con);
        header("Content-Type: application/json");
        echo json_encode(array('status' => 'success', 'messages' => 'แก้ไขข้อมูลเรียบร้อย'));
    } else {
        mysqli_rollback($con);
        header("Content-Type: application/json");
        echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
    }
} else {
    //มีการเปลี่ยนรหัสผ่าน
    $key = "asdf123asdf123asdf123";
    $hash_password = hash_hmac('SHA256', $user_password, $key);

    mysqli_begin_transaction($con);
    $sql_update = "UPDATE tbl_users SET user_username = '$user_username', user_password = '$hash_password', user_firstname ='$user_firstname', user_lastname = '$user_lastname', user_email = '$user_email', user_status ='$user_status', department_id = '$department_id' WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $sql_update);

    if ($result) {
        mysqli_commit($con);
        header("Content-Type: application/json");
        echo json_encode(array('status' => 'success', 'messages' => 'แก้ไขข้อมูลเรียบร้อย'));
    } else {
        mysqli_rollback($con);
        header("Content-Type: application/json");
        echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
    }
}


mysqli_close($con);
