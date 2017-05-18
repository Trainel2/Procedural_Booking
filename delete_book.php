<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

//การส่งข้อมูลแบบ ajax แบบ array ใช้ mysqli_real_escape_string ไม่ได้
$book_id = $_GET['book_id'];

mysqli_begin_transaction($con);
foreach ($book_id as $id) {
    $sql = "DELETE FROM tbl_book WHERE book_id='$id' ";
    $result = mysqli_query($con, $sql);
}
if ($result) {
    mysqli_commit($con);
    header('Content-Type: application/json');
    echo json_encode(array('status' => 'success', 'message' => 'ลบข้อมูลเรียบร้อยแล้ว'));
} else {
    mysqli_rollback($con);
    header('Content-Type: application/json');
    $errors = "เกิดข้อผิดพลาดในการบันทึก กรุณาลองใหม่ " . mysqli_error($con);
    echo json_encode(array('status' => 'danger', 'message' => $errors));
}

mysqli_close($con);
