<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$department_id = mysqli_real_escape_string($con, $_GET['department_id']);

mysqli_begin_transaction($con);

$sql_del = "DELETE FROM tbl_department WHERE department_id = '$department_id'";
$result = mysqli_query($con, $sql_del);

if ($result) {
    mysqli_commit($con);
    header("location: department.php");
} else {
    mysqli_rollback($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
}

mysqli_close($con);
