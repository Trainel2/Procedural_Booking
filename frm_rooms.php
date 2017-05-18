<?php
include("set_session.php");
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
                                <div class="panel-title ">เพิ่มห้องประชุม</div>
                                <div class="panel-options">
                                    <a href="rooms.php"><i class="glyphicon glyphicon-arrow-left"></i> รายละเอียดห้องประชุม</a>
                                </div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <form id="form1" action="insert_rooms.php" method="POST" enctype="multipart/form-data" novalidate>
                                            <fieldset>
                                                <div class="form-group">
                                                    <label for="room_name">ชื่อห้องประชุม</label>
                                                    <input id="room_name" name="room_name" class="form-control" type="text" data-validation="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for="room_detail">รายละเอียดห้องประชุม</label>
                                                    <textarea id="room_detail" name="room_detail"  class="form-control" data-validation="required" rows="3"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="room_pic">รูปภาพห้องประชุม</label>
                                                    <input id="room_pic" name="room_pic"  class="form-control" type="file"
                                                           data-validation="mime size"
                                                           data-validation-allowing="jpg, png"
                                                           data-validation-max-size="512kb">
                                                </div>
                                            </fieldset>
                                            <div>
                                                <button id="btn1"  class="btn btn-primary" type="submit">
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                    บันทึก
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
            $(document).ready(function () {
                $.validate({modules: 'security, file'});
                $("#form1").on("submit", function (e) {
                    if ($("#form1").smkValidate()) {
                        $.ajax({
                            url: "insert_rooms.php",
                            type: 'POST',
                            data: new FormData(this),
                            processData: false,
                            contentType: false,
                            dataType: 'json'
                        }).done(function (data) {
                            if (data.status === 'success') {
                                $.smkAlert({text: data.messages, type: data.status});
                                $("#form1")[0].reset();
                                $("#room_name").focus();
                            } else {
                                $.smkAlert({text: data.messages, type: data.status});
                            }
                            e.preventDefault();
                        });
                    }
                    e.preventDefault();
                });
            });
        </script>
    </body>
</html>
