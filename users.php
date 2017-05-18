<?php
include("set_session.php");
?>
<?php require("ConnectDB.php"); ?>
<?php
@$txt_search = mysqli_real_escape_string($con, $_GET['txt_search']);
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
                                <div class="panel-title ">รายละเอียดพนักงาน</div>
                            </div>

                            <div class="content-box-large box-with-header">

                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="frm_users.php" class="btn btn-primary">เพิ่มพนักงาน</a>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 pull-right">
                                        <div class="form-group">
                                            <form class="form" action="users.php" method="GET">
                                                <div class="input-group">
                                                    <input class="form-control" id="txt_search" type="text" name="txt_search">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-warning" type="submit">
                                                            <span class="glyphicon glyphicon-search"></span>
                                                            Search
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="table table-responsive">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>ชื่อพนักงาน</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>แผนก</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <?php
                                        $sql_user = "SELECT * FROM tbl_users LEFT JOIN tbl_department ON tbl_users.department_id = tbl_department.department_id WHERE user_firstname LIKE '%$txt_search%' ORDER BY user_username";
                                        $result_user = mysqli_query($con, $sql_user);
                                        while ($row_user = mysqli_fetch_assoc($result_user)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row_user['user_firstname'] . " " . $row_user['user_lastname']; ?></td>
                                                <td><?php echo $row_user['user_username']; ?></td>
                                                <td><?php echo $row_user['user_email']; ?></td>
                                                <td><?php echo $row_user['department_name']; ?></td>
                                                <td><a href="frm_edit_users.php?user_id=<?php echo $row_user['user_id'] ?>" class="btn_edit"><i class="glyphicon glyphicon-pencil"></i> แก้ไข</a></td>
                                                <td><a href="#" id="<?php echo $row_user['user_id'] ?>" class="btn_del"><i class="glyphicon glyphicon-trash"></i> ลบ</a>
                                            </tr>
                                            <?php
                                        }
                                        mysqli_free_result($result_user);
                                        mysqli_close($con);
                                        ?>
                                    </table>
                                    <div id="process"></div>
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
                //ลบข้อมูล
                $("a.btn_del").on("click", function (e) {
                    var row_del = $(this).attr("id");
                    $.smkConfirm({text: 'คุณต้องการที่จะลบข้อมูลใช่หรือไม่ ?', accept: 'ยืนยัน', cancel: 'ยกเลิก'}, function (res) {
                        if (res) {
                            window.location.replace("delete_users.php?users_id=" + row_del);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
