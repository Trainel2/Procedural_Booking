<?php require 'session.php'; ?>

<?php

include("ConnectDB.php");

$sql = "SELECT * FROM tbl_book
            LEFT JOIN tbl_users ON tbl_users.user_id = tbl_book.user_id
            LEFT JOIN tbl_rooms ON  tbl_rooms.room_id = tbl_book.room_id
            WHERE tbl_users.user_id = '$s_login_id'
            ORDER BY book_date_start DESC, tbl_book.room_id ASC, book_time_start ASC";
$result = mysqli_query($con, $sql);

$userArray = array();

while ($row = mysqli_fetch_assoc($result)) {
    $userArray[] = $row;
}

echo json_encode($userArray);

mysqli_free_result($result);
mysqli_close($con);
