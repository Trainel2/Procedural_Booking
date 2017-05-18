<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$users_id = mysqli_real_escape_string($con, $_GET['users_id']);

mysqli_begin_transaction($con);
$sql_del = "DELETE FROM tbl_users WHERE user_id = '$users_id'";
$result = mysqli_query($con, $sql_del);

if ($result) {
    mysqli_commit($con);
    header("location: users.php");
} else {
    mysqli_rollback($con);
    echo 'เกิดข้อผิดพลาด ' . mysqli_error($con);
}

mysqli_close($con);
