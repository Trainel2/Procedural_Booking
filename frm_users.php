<?php
include("set_session.php");
?>
<?php require("ConnectDB.php"); ?>
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
                                <div class="panel-title ">เพิ่มพนักงาน</div>
                                <div class="panel-options">
                                    <a href="users.php"><i class="glyphicon glyphicon-arrow-left"></i> รายละเอียดพนักงาน</a>
                                </div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <form id="form1" action="insert_users.php" method="POST" enctype="multipart/form-data" novalidate>
                                            <fieldset>
                                                <?php
                                                $sql_depart = "SELECT * FROM tbl_department";
                                                $result_depart = mysqli_query($con, $sql_depart);
                                                ?>
                                                <div class="form-group">
                                                    <label for="room_name">แผนก</label>
                                                    <select name="department_id" id="department_id" class="form-control" data-validation="required">
                                                        <option value=""><---กรุณาเลือกแผนกพนักงาน---></option>
                                                        <?php
                                                        while ($row_depart = mysqli_fetch_row($result_depart)) {
                                                            echo '<option value=' . $row_depart[0] . '> ' . $row_depart[1] . ' </option>';
                                                        }
                                                        mysqli_free_result($result_depart);
                                                        mysqli_close($con);
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_firstname">ชื่อพนักงาน</label>
                                                    <input id="user_firstname" name="user_firstname" class="form-control" type="text" data-validation="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_lastname">สกุลพนักงาน</label>
                                                    <input id="user_lastname" name="user_lastname" class="form-control" type="text" data-validation="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_email">Email</label>
                                                    <input id="user_email" name="user_email" class="form-control" type="text" data-validation="email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_username">Username</label>
                                                    <input id="user_username" name="user_username" class="form-control" type="text" data-validation="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_password">รหัสผ่าน</label>
                                                    <input id="user_password" name="user_password" class="form-control" type="password" data-validation="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_password1">ยืนยันรหัสผ่าน</label>
                                                    <input id="user_password1" name="user_password1" class="form-control" type="password" data-validation="confirmation" data-validation-confirm="user_password">
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
                        $.post("insert_users.php", $("#form1").serialize()).done(function (data) {
                            if (data.status === 'success') {
                                $.smkAlert({text: data.messages, type: data.status});
                                $("#form1")[0].reset();
                                $("#room_name").focus();
                            } else {
                                $.smkAlert({text: data.messages, type: data.status});
                                $("#user_username").focus();
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
