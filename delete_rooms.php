<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$room_id = mysqli_real_escape_string($con, $_GET['room_id']);

//ลบรูปออกจาก server
$sql_select_pic = "SELECT room_pic FROM tbl_rooms WHERE room_id = '$room_id'";
$result_select_pic = mysqli_query($con, $sql_select_pic);
$row_select_pic = mysqli_fetch_row($result_select_pic);
@unlink("./images/rooms/" . $row_select_pic[0]);

//ลบข้อมูลใน DB
mysqli_begin_transaction($con);
$sql_del = "DELETE FROM tbl_rooms WHERE room_id = '$room_id'";
$result = mysqli_query($con, $sql_del);

if ($result) {
    mysqli_commit($con);
    header("location: rooms.php");
} else {
    mysqli_rollback($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
}

mysqli_close($con);