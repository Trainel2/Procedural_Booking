<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$room_name = $_POST['room_name'];
$room_detail = $_POST['room_detail'];

//upload รูป
if (is_uploaded_file($_FILES['room_pic']['tmp_name'])) {
    $ext = pathinfo(basename($_FILES['room_pic']['name']), PATHINFO_EXTENSION);
    $name_img = "rooms_" . uniqid() . "." . $ext;
    $path = "./images/rooms/" . $name_img;
    move_uploaded_file($_FILES['room_pic']['tmp_name'], $path);
} else {
    $name_img = "rooms_" . uniqid() . ".png";
    $srcfile = './images/rooms/photo2.png';
    $targetfile = './images/rooms/' . $name_img;
    copy($srcfile, $targetfile);
}

mysqli_begin_transaction($con);
$sql = "INSERT INTO tbl_rooms VALUES('0','$room_name','$room_detail','$name_img')";
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
