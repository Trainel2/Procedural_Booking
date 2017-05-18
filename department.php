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
                                <div class="panel-title ">รายละเอียดแผนก</div>
                            </div>

                            <div class="content-box-large box-with-header">
                                <a href="frm_department.php" class="btn btn-primary">เพิ่มแผนก</a>
                                <br><br>
                                <div class="table table-responsive">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>รหัสแผนก</th>
                                            <th>ชื่อแผนก</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <?php
                                        $sql_depart = "SELECT * FROM tbl_department";
                                        $result_depart = mysqli_query($con, $sql_depart);
                                        $row_data = 1;
                                        while ($row_depart = mysqli_fetch_assoc($result_depart)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row_data ?></td>
                                                <td id="department<?php echo $row_depart['department_id']; //กำหนด id ให้ตรงกับ รหัสในฐานข้อมูล ?>"><?php echo $row_depart['department_name']; ?></td>
                                                <td><a href="#" id="<?php echo $row_depart['department_id'] ?>" class="btn_edit"><i class="glyphicon glyphicon-pencil"></i> แก้ไข</a></td>
                                                <td><a href="#" id="<?php echo $row_depart['department_id'] ?>" class="btn_del"><i class="glyphicon glyphicon-trash"></i> ลบ</a>
                                            </tr>
                                            <?php
                                            $row_data ++;
                                        }
                                        mysqli_free_result($result_depart);
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
            //เมื่อ ajax ทำงาน
            $(document).ajaxStart(function () {
                $.smkProgressBar({element: 'body', status: 'start', bgColor: '#000', barColor: '#fff', content: 'กำลังทำการแก้ไขข้อมูล.....กรุณารอซักครู่'});
            }).ajaxStop(function () {  //เมื่อ ajax หยุดทำงาน
                setTimeout(function () {
                    $.smkProgressBar({status: 'end'});
                    window.location.replace("department.php");
                }, 500);
            });

            $(document).ready(function () {
                //แก้ไขข้อมูล
                //เมื่อกดปุ่มแก้ไข
                $("a.btn_edit").on("click", function (e) {
                    //ประกาศตัวแปร row_edit ให้มีค่าเท่ากับ attribult id ของ tag ที่เราเลือก
                    var row_edit = $(this).attr("id");
                    //ประกาศตัวแปร id ให้มีค่าเท่ากับ ...
                    var id = 'department' + row_edit;
                    //เรียกใช้งาน $('#' + id).text(); คือการเรียกค่า text ของ id ที่ได้เก็บไว้มาใช้งาน
                    $.smkPrompt({text: 'คุณต้องการที่จะแก้ไขแผนก ' + $('#' + id).text() + ' เป็น ?', accept: 'ยืนยัน', cancel: 'ยกเลิก'}, function (res) {
                        if (res == '') {
                            $.smkAlert({text: 'กรุณาตรวจสอบชื่อแผนกใหม่อีกครั้ง', type: 'warning'});
                        } else if (res) {
                            $.post("edit_department.php", {department_id: row_edit, department_name: res}, function (data) {
                                // window.location.replace("department.php");
                            });
                        }
                    });
                });

                //ลบข้อมูล
                $("a.btn_del").on("click", function (e) {
                    var row_del = $(this).attr("id");
                    $.smkConfirm({text: 'คุณต้องการที่จะลบข้อมูลใช่หรือไม่ ?', accept: 'ยืนยัน', cancel: 'ยกเลิก'}, function (res) {
                        if (res) {
                            window.location.replace("delete_department.php?department_id=" + row_del);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
