<?php
include("set_session.php");
?>
<?php require("ConnectDB.php"); ?>
<?php
$book_id = mysqli_real_escape_string($con, $_GET['book_id']);
$sql_select_book = "SELECT * FROM tbl_book LEFT JOIN tbl_users ON tbl_users.user_id = tbl_book.user_id LEFT JOIN tbl_rooms ON  tbl_rooms.room_id = tbl_book.room_id WHERE book_id = '$book_id'";
$result_select_book = mysqli_query($con, $sql_select_book);
$row_select_book = mysqli_fetch_assoc($result_select_book);
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
                                <div class="panel-title ">จองห้องประชุม</div>
                                <div class="panel-options">
                                    <a href="book.php"><i class="glyphicon glyphicon-arrow-left"></i> รายละเอียดการจองห้องประชุม</a>
                                </div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="form1" action="edit_book.php" method="POST" enctype="multipart/form-data" novalidate>
                                            <fieldset>
                                                <div class="form-group col-md-12">
                                                    <label for="book_title">หัวข้อการประชุม</label>
                                                    <input id="book_title" name="book_title" class="form-control" type="text" data-validation="required" value="<?php echo $row_select_book['book_title']; ?>">
                                                </div>
                                                <?php
                                                $sql_room = "SELECT * FROM tbl_rooms";
                                                $result_room = mysqli_query($con, $sql_room);
                                                ?>
                                                <div class="form-group col-md-8">
                                                    <label for="room_id" class="control-label">ห้องประชุม</label>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                                                                <select name="room_id" id="room_id" class="form-control" data-validation="required">
                                                                    <option value=""><---กรุณาเลือกห้องประชุม---></option>
                                                                    <?php
                                                                    while ($row_room = mysqli_fetch_row($result_room)) {
                                                                        if ($row_select_book['room_id'] === $row_room[0]) {
                                                                            echo '<option value=' . $row_room[0] . ' selected> ' . $row_room[1] . ' </option>';
                                                                        } else {
                                                                            echo '<option value=' . $row_room[0] . '> ' . $row_room[1] . ' </option>';
                                                                        }
                                                                    }
                                                                    mysqli_free_result($result_room);
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="book_qty" class="control-label">จำนวนผู้เข้าประชุม</label>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="input-group">
                                                                <input id="book_qty" name="book_qty" class="form-control" type="text" data-validation="number" data-validation-allowing="range[1;100]" value="<?php echo $row_select_book['book_qty']; ?>">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="book_date_start" class="control-label">วันที่เริ่มต้น</label>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input type="text" name="book_date_start" id="book_date_start" class="form-control" data-validation="required" value="<?php echo $row_select_book['book_date_start']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="book_time_start" class="control-label">เวลาเริ่มต้น</label>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                                <input type="text" name="book_time_start" id="book_time_start" class="form-control" data-validation="required" value="<?php echo $row_select_book['book_time_start']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-6">
                                                    <label for="book_date_finish" class="control-label">วันที่สิ้นสุด</label>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input type="text" name="book_date_finish" id="book_date_finish" class="form-control" data-validation="required" value="<?php echo $row_select_book['book_date_finish']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="book_time_finish" class="control-label">เวลาสิ้นสุด</label>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                                <input type="text" name="book_time_finish" id="book_time_finish" class="form-control" data-validation="required" value="<?php echo $row_select_book['book_time_finish']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="book_detail" class="control-label">รายละเอียด</label>
                                                    <textarea id="book_detail" name="book_detail" rows="4" class="form-control"><?php echo $row_select_book['book_detail']; ?></textarea>
                                                </div>

                                                <div class="form-group col-md-8">
                                                    <label for="room_name">ผู้จองห้องประชุม : <?php echo $s_login_firstname ?></label>
                                                    <input type="hidden" name="user_id" id="user_id" class="form-control" value="<?php echo $s_login_id ?>">
                                                </div>

                                                <?php if ($s_login_status === 'admin') { ?>
                                                    <div class="col-md-12">
                                                        <div class="col-md-2">
                                                            <label class="radio">
                                                                <?php
                                                                if ($row_select_book['book_status'] === 'ไม่อนุมัติ') {
                                                                    echo "<input type='radio' name='book_status' id='book_status_no' value='ไม่อนุมัติ' checked>";
                                                                } else {
                                                                    echo "<input type='radio' name='book_status' id='book_status_no' value='ไม่อนุมัติ'>";
                                                                }
                                                                ?>
                                                              <!-- <input type="radio" name="book_status" id="book_status_no" value="ไม่อนุมัติ"> -->
                                                                <span class="label label-danger" style="font-size:medium;">ไม่อนุมัติ</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="radio">
                                                                <?php
                                                                if ($row_select_book['book_status'] === 'รอการอนุมัติ') {
                                                                    echo "<input type='radio' name='book_status' id='book_status_wait' value='รอการอนุมัติ' checked>";
                                                                } else {
                                                                    echo "<input type='radio' name='book_status' id='book_status_wait' value='รอการอนุมัติ'>";
                                                                }
                                                                ?>
                                                                <span class="label label-warning" style="font-size:medium;">รอการอนุมัติ</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="radio">
                                                                <?php
                                                                if ($row_select_book['book_status'] === 'อนุมัติ') {
                                                                    echo "<input type='radio' name='book_status' id='book_status_ok' value='อนุมัติ' checked>";
                                                                } else {
                                                                    echo "<input type='radio' name='book_status' id='book_status_ok' value='อนุมัติ'>";
                                                                }
                                                                ?>
                                                                <span class="label label-success" style="font-size:medium;">อนุมัติ</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <input type="hidden" name="book_status" value="<?php echo $row_select_book['book_status']; ?>">
                                                <?php } ?>
                                                <input type="hidden" name="book_id" value="<?php echo $row_select_book['book_id']; ?>">
                                            </fieldset>
                                            <br>
                                            <?php
                                            mysqli_free_result($result_select_book);
                                            mysqli_close($con);
                                            ?>
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
                //validate file
                $.validate({modules: 'security, file'});
                //set datetimepicker choose day
                $('#book_date_start').datetimepicker({
                    format: 'Y/m/d',
                    onShow: function (ct) {
                        this.setOptions({
                            maxDate: $('#book_date_finish').val() ? $('#book_date_finish').val() : false
                        })
                    },
                    timepicker: false
                });
                $('#book_date_finish').datetimepicker({
                    format: 'Y/m/d',
                    onShow: function (ct) {
                        this.setOptions({
                            minDate: $('#book_date_start').val() ? $('#book_date_start').val() : false
                        })
                    },
                    timepicker: false
                });

                //set time with datetimepicker
                $('#book_time_start').datetimepicker({
                    datepicker: false,
                    format: 'H:i',
                    step: 30
                });

                $('#book_time_finish').datetimepicker({
                    datepicker: false,
                    format: 'H:i',
                    step: 30
                });

                $("#form1").on("submit", function (e) {
                    $.post("edit_book.php", $("#form1").serialize()).done(function (data) {
                        if (data.status === 'danger') {
                            $.smkAlert({text: data.messages, type: data.status});
                            $("#book_title").focus();
                        } else {
                            window.location.replace('book.php');
                        }
                        e.preventDefault();
                    });
                    e.preventDefault();
                }); //close form1 .submit

            }); //close $( document ).ready()
        </script>
    </body>
</html>
