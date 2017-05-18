<?php
include("set_session.php");
?>
<?php require("ConnectDB.php"); ?>
<?php
$user_id = mysqli_real_escape_string($con, $_GET['user_id']);
$sql_select_user = "SELECT * FROM tbl_users WHERE user_id = '$user_id'";
$result_select_user = mysqli_query($con, $sql_select_user);
$row_select_user = mysqli_fetch_assoc($result_select_user);
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
                                <div class="panel-title ">เพิ่มพนักงาน</div>
                                <div class="panel-options">
                                    <a href="users.php"><i class="glyphicon glyphicon-arrow-left"></i> รายละเอียดพนักงาน</a>
                                </div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <form id="form1" action="edit_users.php" method="POST" enctype="multipart/form-data" novalidate>
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
                                                            if ($row_select_user['department_id'] === $row_depart[0]) {
                                                                echo '<option value=' . $row_depart[0] . ' selected> ' . $row_depart[1] . ' </option>';
                                                            } else {
                                                                echo '<option value=' . $row_depart[0] . '> ' . $row_depart[1] . ' </option>';
                                                            }
                                                        }
                                                        mysqli_free_result($result_depart);
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_firstname">ชื่อพนักงาน</label>
                                                    <input id="user_firstname" name="user_firstname" class="form-control" type="text" value="<?php echo $row_select_user['user_firstname']; ?>" data-validation="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_lastname">สกุลพนักงาน</label>
                                                    <input id="user_lastname" name="user_lastname" class="form-control" type="text" value="<?php echo $row_select_user['user_lastname']; ?>" data-validation="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_email">Email</label>
                                                    <input id="user_email" name="user_email" class="form-control" type="text" value="<?php echo $row_select_user['user_email']; ?>" data-validation="email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_username">Username</label>
                                                    <input class="form-control" type="text" value="<?php echo $row_select_user['user_username']; ?>" data-validation="required" disabled>
                                                    <input id="user_username" name="user_username" class="form-control" type="hidden" value="<?php echo $row_select_user['user_username']; ?>" data-validation="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_password">รหัสผ่าน</label>
                                                    <input id="user_password" name="user_password" class="form-control" type="password" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_password1">ยืนยันรหัสผ่าน</label>
                                                    <input id="user_password1" nae="user_password1" class="form-control" type="password" data-validation="confirmation" data-validation-confirm="user_password">
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <?php
                                                        if ($row_select_user['user_status'] == 'user') {
                                                            echo '<input type="radio" name="user_status" id="radio1" value="user" checked>';
                                                        } else {
                                                            echo '<input type="radio" name="user_status" id="radio1" value="user">';
                                                        }
                                                        ?>
                                                        User
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <?php
                                                        if ($row_select_user['user_status'] == 'admin') {
                                                            echo '<input type="radio" name="user_status" id="radio1" value="admin" checked>';
                                                        } else {
                                                            echo '<input type="radio" name="user_status" id="radio1" value="admin">';
                                                        }
                                                        ?>
                                                        Admin
                                                    </label>
                                                </div>
                                                <input type="hidden" name="user_id" value="<?php echo $row_select_user['user_id']; ?>">
                                                <?php
                                                mysqli_free_result($result_select_user);
                                                mysqli_close($con);
                                                ?>
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
            $(document).ajaxStart(function () {
                $.smkProgressBar({element: 'body', status: 'start', bgColor: '#000', barColor: '#fff', content: 'Loading...'});
            }).ajaxStop(function () {
                setTimeout(function () {
                    $.smkProgressBar({status: 'end'});
                    window.location.replace("users.php");
                }, 1000);
            });

            $(document).ready(function () {
                $.validate({modules: 'security, file'});
                $("#form1").on("submit", function (e) {
                    $.post("edit_users.php", $("#form1").serialize()).done(function (data) {
                        if (data.status === 'danger') {
                            $.smkAlert({text: data.messages, type: data.status});
                            e.preventDefault();
                        }
                    });
                    e.preventDefault();
                });
            });

        </script>
    </body>
</html>
