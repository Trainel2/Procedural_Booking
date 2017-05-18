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
$book_status = mysqli_real_escape_string($con, $_POST['book_status']);
$book_id = mysqli_real_escape_string($con, $_POST['book_id']);

//ตรวจสอบ ว่ามีการเปลี่ยนแปลงวันที่และเวลาหรือไม่
$sql_check_changeData = "SELECT * FROM tbl_book WHERE book_id = '$book_id'";
$result_check_changeData = mysqli_query($con, $sql_check_changeData);
$row_check_changeData = mysqli_fetch_assoc($result_check_changeData);

//ไม่มีการเปลี่ยนแปลงวันที่และเวลา
if ($row_check_changeData['book_date_start'] === $book_date_start && $row_check_changeData['book_time_start'] === $book_time_start &&
        $row_check_changeData['book_date_finish'] === $book_date_finish && $row_check_changeData['book_time_finish'] === $book_time_finish) {
    mysqli_free_result($result_check_changeData);

    mysqli_begin_transaction($con);
    $sql_update = "UPDATE tbl_book SET book_date_start = '$book_date_start', book_time_start ='$book_time_start',
                         book_date_finish = '$book_date_finish', book_time_finish = '$book_time_finish',
                         book_title ='$book_title', book_detail = '$book_detail', book_qty = '$book_qty',
                         book_status = '$book_status', user_id = '$user_id', room_id = '$room_id' WHERE book_id = '$book_id'";
    $result = mysqli_query($con, $sql_update);

    if ($result) {
        mysqli_commit($con);
        header("location: book.php");
    } else {
        mysqli_rollback($con);
        header("Content-Type: application/json");
        echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
    }
   
    exit();
} else {
//มีการเปลี่ยนแปลงวันที่และเวลา
    //ตรวจสอบเวลาเริ่มต้นต้องมากกว่า เวลาสิ้นสุด
    if ($book_time_finish <= $book_time_start) {
        header("Content-Type: application/json");
        echo json_encode(array('status' => 'danger', 'messages' => 'กรุณาตรวจสอบเวลาใหม่อีกครั้ง'));
        exit();
    }

    mysqli_begin_transaction($con);

    $sql_delete_book = "DELETE FROM tbl_book WHERE book_id = '$book_id'";
    $result_delete_book = mysqli_query($con, $sql_delete_book);

    if (!$result_delete_book) {
        echo "Error";
        mysqli_rollback($con);
        mysqli_close($con);
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
        mysqli_rollback($con);
        header("Content-Type: application/json");
        echo json_encode(array('status' => 'danger', 'messages' => 'ช่วงเวลาดังกล่าวมีการจองไว้แล้ว กรุณาเลือกช่วงเวลาใหม่อีกครั้ง'));
        mysqli_free_result($result_check_time);
        mysqli_close($con);
        exit();
    }

    mysqli_rollback($con);

    $sql_update = "UPDATE tbl_book SET book_date_start = '$book_date_start', book_time_start ='$book_time_start',
                       book_date_finish = '$book_date_finish', book_time_finish = '$book_time_finish',
                       book_title ='$book_title', book_detail = '$book_detail', book_qty = '$book_qty',
                       book_status = '$book_status', user_id = '$user_id', room_id = '$room_id' WHERE book_id = '$book_id'";
    $result_update = mysqli_query($con, $sql_update);

    if ($result_update) {
        mysqli_commit($con);
        header("location: book.php");
    } else {
        mysqli_rollback($con);
        header("Content-Type: application/json");
        echo json_encode(array('status' => 'danger', 'messages' => 'เกิดข้อผิดพลาด ' . mysqli_error($con)));
    }
}

mysqli_close($con);
exit();
