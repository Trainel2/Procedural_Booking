<?php require './session.php'; ?>
<?php

require("ConnectDB.php");

$news_id = mysqli_real_escape_string($con, $_GET['news_id']);

    $sql_select_file = "SELECT news_upload FROM tbl_news WHERE news_id = '$news_id'";
    $result_select_file = mysqli_query($con, $sql_select_file);
    $row_select_file = mysqli_fetch_row($result_select_file);
    @unlink("./upload/" . $row_select_file[0]);

mysqli_begin_transaction($con);
$sql_del = "DELETE FROM tbl_news WHERE news_id = '$news_id'";
$result = mysqli_query($con, $sql_del);

if ($result) {
    mysqli_commit($con);
    header("location: index.php");
} else {
    mysqli_rollback($con);
    echo 'เกิดข้อผิดพลาด ' . mysqli_error($con);
}

mysqli_close($con);
