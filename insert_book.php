<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$book_title = mysqli_real_escape_string($con, $_POST['book_title']);
$room_id = mysqli_real_escape_string($con, $_POST['room_id']);
$book_qty = mysqli_real_escape_string($con, $_POST['book_qty']);
$book_date_start = mysqli_real_escape_string($con, $_POST['book_date_start']);
$book_time_start = mysqli_real_escape_string($con, $_POST['book_time_start']);
$book_date_finish = mysqli_real_escape_string($con, $_POST['book_date_finish']);
$book_time_finish = mysqli_real_escape_string($con, $_POST['book_time_finish']);
$book_detail = mysqli_real_escape_string($con, $_POST['book_detail']);
$user_id = mysqli_real_escape_string($con, $_POST['user_id']);

if ($book_time_finish <= $book_time_start) {
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'กรุณาตรวจสอบเวลาใหม่อีกครั้ง'));
    exit();
}

$sql_check_time = "SELECT * FROM  tbl_book WHERE room_id = '$room_id'
                      AND book_status <> 'ไม่อนุมัติ'
                      AND ((book_date_start <= '$book_date_start' AND book_date_finish >= '$book_date_start')
                      OR (book_date_start <= '$book_date_finish' AND book_date_finish >= '$book_date_finish')
                      OR (book_date_start >= '$book_date_start' AND book_date_start <= '$book_date_finish')
                      OR (book_date_finish >= '$book_date_start' AND book_date_finish <= '$book_date_finish'))

                      AND ((book_time_start <= '$book_time_start' AND book_time_finish >= '$book_time_start')
                      OR (book_time_start <= '$book_time_finish' AND book_time_finish >= '$book_time_finish')
                      OR (book_time_start >= '$book_time_start' AND book_time_start <= '$book_time_finish')
                      OR (book_time_finish >= '$book_time_start' AND book_time_finish <= '$book_time_finish'))";


$result_check_time = mysqli_query($con, $sql_check_time);

if (mysqli_num_rows($result_check_time) >= 1) {
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'ช่วงเวลาดังกล่าวมีการจองไว้แล้ว กรุณาเลือกช่วงเวลาใหม่อีกครั้ง'));
    exit();
}

mysqli_begin_transaction($con);
$sql_insert_book = "INSERT INTO tbl_book
                        VALUES('0','$book_date_start','$book_time_start','$book_date_finish','$book_time_finish',
                              '$book_title','$book_detail','$book_qty','รอการอนุมัติ','$user_id','$room_id')";
$result_insert_book = mysqli_query($con, $sql_insert_book);

if ($result_insert_book) {
    mysqli_commit($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'success', 'messages' => 'บันทึกข้อมูลเรียบร้อย'));
} else {
    mysqli_rollback($con);
    header("Content-Type: application/json");
    echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
}
?>
