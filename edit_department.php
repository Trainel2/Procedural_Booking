<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$department_id = mysqli_real_escape_string($con, $_POST['department_id']);
$department_name = mysqli_real_escape_string($con, $_POST['department_name']);

mysqli_begin_transaction($con);
$sql_del = "UPDATE tbl_department SET department_name = '$department_name' WHERE department_id = '$department_id'";
$result = mysqli_query($con, $sql_del);

if ($result) {
    mysqli_commit($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
} else {
    mysqli_rollback($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
}


mysqli_close($con);