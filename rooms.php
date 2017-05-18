<?php
include("set_session.php");
?>
<?php require("ConnectDB.php") ?>
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
                                <div class="panel-title ">รายละเอียดห้องประชุม</div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <a href="frm_rooms.php" class="btn btn-primary">เพิ่มห้องประชุม</a>
                                <br><br>
                                <div class="table table-responsive">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>ชื่อห้องประชุม</th>
                                            <th>รูปภาพห้องประชุม</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <?php
                                        $sql = "SELECT * FROM tbl_rooms";
                                        $result = mysqli_query($con, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['room_name'] ?></td>
                                                <td><img src="./images/rooms/<?php echo $row['room_pic'] ?>" alt="<?php echo $row['room_pic'] ?>" height="40px" class="img-rounded"></td>
                                                <td><a href="frm_edit_room.php?room_id=<?php echo $row['room_id'] ?>"><i class="glyphicon glyphicon-eye-open"></i> รายละเอียด</a></td>
                                                <td><a id="<?php echo $row['room_id'] ?>" href="#" class="btn_del"><i class="glyphicon glyphicon-trash"></i> ลบ</a>
                                            </tr>
                                            <?php
                                        }
                                        mysqli_free_result($result);
                                        mysqli_close($con);
                                        ?>
                                    </table>
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
                }, 500);
            });


            $(document).ready(function () {
                $("a.btn_del").on("click", function (e) {
                    var row_id = $(this).attr("id");
                    $.smkConfirm({text: 'คุณต้องการที่จะลบห้องประชุมใช่หรือไม่ ?', accept: 'ยืนยัน', cancel: 'ยกเลิก'}, function (res) {
                        if (res) {
                            $.get("delete_rooms.php", {room_id: row_id}).done(function (e) {
                            });
                        } else {
                            $.smkAlert({text: data.messages, type: data.status});
                            e.preventDefault();
                        }
                    });
                });
            });
        </script>
    </body>
</html>
