<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$department_name = mysqli_real_escape_string($con, $_POST['department_name']);

mysqli_begin_transaction($con);
$sql = "INSERT INTO tbl_department(department_name) VALUES('$department_name')";
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
