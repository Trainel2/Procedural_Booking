<?php
include("set_session.php");
?>
<?php
require("ConnectDB.php");

$room_id = mysqli_real_escape_string($con, $_GET['room_id']);
$sql_select_room = "SELECT * FROM tbl_rooms WHERE room_id ='$room_id'";
$result_select_room = mysqli_query($con, $sql_select_room);
$row_select_room = mysqli_fetch_assoc($result_select_room);
?>

<!DOCTYPE html>
<html>
    <?php include("head.php") ?>
    <body>
        <?php include("header.php") ?>

        <div class="page-content">
            <div class="row">
                <div class="col-md-2">
                    <?php include("sitebar.php") ?>
                </div>
                <div class="col-md-10">

                    <div class="row">
                        <div class="col-md-12 panel-info">
                            <div class="content-box-header panel-heading">
                                <div class="panel-title ">แก้ไขห้องประชุม : <?php echo $row_select_room['room_name']; ?></div>

                                <div class="panel-options">
                                    <a href="rooms.php"><i class="glyphicon glyphicon-arrow-left"></i> รายละเอียดห้องประชุม</a>

                                </div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <form id="form1" action="edit_rooms.php" method="POST" enctype="multipart/form-data" novalidate>
                                            <fieldset>
                                                <div class="form-group">
                                                    <label for="room_name">ชื่อห้องประชุม</label>
                                                    <input id="room_name" name="room_name" class="form-control" type="text" data-validation="required" value="<?php echo $row_select_room['room_name']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="room_detail">รายละเอียดห้องประชุม</label>
                                                    <textarea id="room_detail" name="room_detail"  class="form-control" data-validation="required" rows="3"><?php echo $row_select_room['room_detail']; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="room_pic">รูปภาพห้องประชุม</label>
                                                    <img  src="./images/rooms/<?php echo $row_select_room['room_pic'] ?>"  alt="<?php echo $row_select_room['room_pic']; ?>" class="img-thumbnail">
                                                    <input id="room_pic" name="room_pic"  class="form-control" type="file"
                                                           data-validation="mime size"
                                                           data-validation-allowing="jpg, png"
                                                           data-validation-max-size="512kb">
                                                </div>
                                                <input type="hidden" name="room_id" value="<?php echo $row_select_room['room_id'] ?>">
                                            </fieldset>
                                            <?php
                                            mysqli_free_result($result_select_room);
                                            mysqli_close($con);
                                            ?>
                                            <div>
                                                <button id="btn1"  class="btn btn-warning" type="submit">
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                    แก้ไข
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- close content  -->
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <?php include("footer.php") ?>

        <script type="text/javascript">
            $(document).ajaxStart(function () {
                $.smkProgressBar({element: 'body', status: 'start', bgColor: '#000', barColor: '#fff', content: 'Loading...'});
            }).ajaxStop(function () {
                setTimeout(function () {
                    $.smkProgressBar({status: 'end'});
                    window.location.replace("rooms.php");
                }, 1000);
            });

            $(document).ready(function () {
                $.validate({modules: 'security, file'});
                $("#form1").on("submit", function (e) {
                    $.ajax({
                        url: "edit_rooms.php",
                        type: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        dataType: 'json'
                    }).done(function (data) {
                        if (data.status === 'danger') {
                            $.smkAlert({text: data.messages, type: data.status});
                            $("#room_name").focus();
                            e.preventDefault();
                        }
                    });
                    e.preventDefault();
                });
            });
        </script>
    </body>
</html>
