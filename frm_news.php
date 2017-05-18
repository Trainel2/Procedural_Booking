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
                                <div class="panel-title ">เพิ่มข่าวสารบริษัท</div>
                                <div class="panel-options">
                                    <a href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> หน้าหลัก</a>
                                </div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <form id="form1" action="insert_news.php" method="POST" enctype="multipart/form-data" novalidate>
                                            <fieldset>
                                                <div class="form-group">
                                                    <label for="news_title">หัวข้อข่าว</label>
                                                    <input id="news_title" name="news_title" class="form-control" type="text" data-validation="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for="room_detail">รายละเอียดข่าว</label>
                                                    <textarea id="news_detail" name="news_detail"  class="form-control" data-validation="required" rows="7"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="room_pic">เอกสารอ้างอิง</label>
                                                    <input id="news_file" name="news_file"  class="form-control" type="file"
                                                           data-validation="size"
                                                           data-validation-max-size="1mb">
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
                            url: "insert_news.php",
                            type: 'POST',
                            data: new FormData(this),
                            processData: false,
                            contentType: false,
                            dataType: 'json'
                        }).done(function (data) {
                            if (data.status === 'success') {
                                $.smkAlert({text: data.messages, type: data.status});
                                $("#form1")[0].reset();
                                $("#news_title").focus();
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
