<?php

include("set_session.php");
include("./ConnectDB.php");

$news_id = mysqli_real_escape_string($con, $_GET['news_id']);

$sql = "SELECT * FROM tbl_news WHERE news_id = '$news_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<div id="news">
    <h3><?php echo $row['news_title']; ?></h3>
    <p><?php echo $row['news_detail']; ?></p>
    <a target="_blank" href="upload/<?php echo $row['news_upload']; ?>"><?php echo $row['news_file']; ?></a>
    
    <p style="text-align: right;"><small><?php echo $row['news_date']; ?></small></p>
    
</div>
