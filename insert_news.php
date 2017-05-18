<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$news_title = $_POST['news_title'];
$news_detail =  $_POST['news_detail'];

$news_detail= str_replace("\n", "<br>\n", "$news_detail"); 

mysqli_begin_transaction($con);
//upload รูป
if (is_uploaded_file($_FILES['news_file']['tmp_name'])) {
    $ext = pathinfo(basename($_FILES['news_file']['name']), PATHINFO_EXTENSION);
    $name_file = "file_" . uniqid() . "." . $ext;
    $path = "./upload/" . $name_file;
    move_uploaded_file($_FILES['news_file']['tmp_name'], $path);
    $news_file = $_FILES['news_file']['name'];

    $sql = "INSERT INTO tbl_news VALUES('0','$news_title','$news_detail', now(), '$news_file','$name_file','$s_login_id')";
    $result = mysqli_query($con, $sql);
} else {
    $sql = "INSERT INTO tbl_news(news_id, news_title, news_detail, news_date, user_id) 
            VALUES('0','$news_title','$news_detail', now(), '$s_login_id' )";
    $result = mysqli_query($con, $sql);
}


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
