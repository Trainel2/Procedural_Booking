<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$news_id = $_POST['news_id'];
$news_title = $_POST['news_title'];
$news_detail =  $_POST['news_detail'];

$news_detail= str_replace("\n", "<br>\n", "$news_detail"); 

//ตรวจสอบว่ามีการอัพโหลดรูปมารึเปล่า
if (is_uploaded_file($_FILES['news_file']['tmp_name'])) {
    //ลบรูปออกจาก server
    $sql_select_file = "SELECT news_upload FROM tbl_news WHERE news_id = '$news_id'";
    $result_select_file = mysqli_query($con, $sql_select_file);
    $row_select_file = mysqli_fetch_row($result_select_file);
    @unlink("./upload/" . $row_select_file[0]);

    // เพิ่มรูปใหม่
    $ext = pathinfo(basename($_FILES['news_file']['name']), PATHINFO_EXTENSION);
    $news_upload = "file_" . uniqid() . "." . $ext;
    $path = "./upload/" . $news_upload;
    move_uploaded_file($_FILES['news_file']['tmp_name'], $path);
    $news_file = $_FILES['news_file']['name'];
} else {
    $sql_select_file = "SELECT news_upload, news_file FROM tbl_news WHERE news_id = '$news_id'";
    $result_select_file = mysqli_query($con, $sql_select_file);
    $row_select_file = mysqli_fetch_row($result_select_file);
    $news_upload = $row_select_file[0];
    $news_file = $row_select_file[1];
}

//แก้ไขฐานข้อมูล
mysqli_begin_transaction($con);
$sql_update = "UPDATE tbl_news SET news_title = '$news_title', news_detail = '$news_detail', news_date = now(), news_file = '$news_file', news_upload = '$news_upload' WHERE news_id = '$news_id'";
$result_update = mysqli_query($con, $sql_update);

if ($result_update) {
    mysqli_commit($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'success', 'messages' => 'แก้ไขข้อมูลเรียบร้อย '));
} else {
    mysqli_rollback($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
}

mysqli_close($con);

