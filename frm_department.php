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
                                <div class="panel-title ">เพิ่มแผนก</div>
                                <div class="panel-options">
                                    <a href="department.php"><i class="glyphicon glyphicon-arrow-left"></i> รายละเอียดแผนก</a>
                                </div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form id="form1" action="insert_department.php" method="POST" novalidate>
                                            <fieldset>
                                                <div class="form-group">
                                                    <label for="department_name">ชื่อแผนก</label>
                                                    <input id="department_name" name="department_name" class="form-control" placeholder="กรุณากรอกชื่อแผนก" type="text" required>
                                                </div>
                                                <button id="btn1" class="btn btn-primary" type="submit">
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                    บันทึก
                                                </button>
                                            </fieldset>
                                        </form>        
                                    </div>
                                </div>
                            </div>
                        </div> <!-- close content  -->
                    </div>
                </div>
            </div>
        </div>
        <?php include("footer.php") ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#btn1").on("click", function (e) {
                    if ($("#form1").smkValidate()) {
                        $.post("insert_department.php", $("#form1").serialize()).done(function (data) {
                            if (data.status === "success") {
                                $.smkAlert({text: data.messages, type: data.status});
                                $("#form1").smkClear();
                                $("#department_name").focus();
                            } else {
                                $.smkAlert({text: data.messages, type: data.status});
                            }
                        });
                        e.preventDefault();
                    }
                    e.preventDefault();
                });
            });
        </script>
    </body>
</html>
