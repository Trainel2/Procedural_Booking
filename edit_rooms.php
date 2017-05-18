<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$room_id = mysqli_real_escape_string($con, $_POST['room_id']);
$room_name = mysqli_real_escape_string($con, $_POST['room_name']);
$room_detail = mysqli_real_escape_string($con, $_POST['room_detail']);

//ตรวจสอบว่ามีการอัพโหลดรูปมารึเปล่า
if (is_uploaded_file($_FILES['room_pic']['tmp_name'])) {
    //ลบรูปออกจาก server
    $sql_select_pic = "SELECT room_pic FROM tbl_rooms WHERE room_id = '$room_id'";
    $result_select_pic = mysqli_query($con, $sql_select_pic);
    $row_select_pic = mysqli_fetch_row($result_select_pic);
    @unlink("./images/rooms/" . $row_select_pic[0]);

    // เพิ่มรูปใหม่
    $ext = pathinfo(basename($_FILES['room_pic']['name']), PATHINFO_EXTENSION);
    $name_img = "rooms_" . uniqid() . "." . $ext;
    $path = "./images/rooms/" . $name_img;
    move_uploaded_file($_FILES['room_pic']['tmp_name'], $path);
} else {
    $sql_select_pic = "SELECT room_pic FROM tbl_rooms WHERE room_id = '$room_id'";
    $result_select_pic = mysqli_query($con, $sql_select_pic);
    $row_select_pic = mysqli_fetch_row($result_select_pic);
    $name_img = $row_select_pic[0];
}

//แก้ไขฐานข้อมูล
mysqli_begin_transaction($con);
$sql_update = "UPDATE tbl_rooms SET room_name = '$room_name', room_detail = '$room_detail', room_pic = '$name_img' WHERE room_id = '$room_id'";
$result_update = mysqli_query($con, $sql_update);

if ($result_update) {
    mysqli_commit($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'success', 'messages' => 'OK '));
} else {
    mysqli_rollback($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
}

mysqli_free_result($result_select_pic);

mysqli_close($con);

