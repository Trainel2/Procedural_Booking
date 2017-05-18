<?php
include("set_session.php");
?>
<?php require("ConnectDB.php"); ?>
<?php
$book_id = mysqli_real_escape_string($con, $_GET['book_id']);
$sql_select_book = "SELECT * FROM tbl_book
                        LEFT JOIN tbl_users ON tbl_users.user_id = tbl_book.user_id
                        LEFT JOIN tbl_rooms ON  tbl_rooms.room_id = tbl_book.room_id
                        LEFT JOIN tbl_department ON tbl_users.department_id = tbl_department.department_id
                        WHERE book_id = '$book_id'";
$result_select_book = mysqli_query($con, $sql_select_book);
$row_select_book = mysqli_fetch_assoc($result_select_book);


//function การแปลงวันที่ จาก eng เป็น th
$thai_day_arr = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์");
$thai_month_arr = array(
    "0" => "",
    "1" => "มกราคม",
    "2" => "กุมภาพันธ์",
    "3" => "มีนาคม",
    "4" => "เมษายน",
    "5" => "พฤษภาคม",
    "6" => "มิถุนายน",
    "7" => "กรกฎาคม",
    "8" => "สิงหาคม",
    "9" => "กันยายน",
    "10" => "ตุลาคม",
    "11" => "พฤศจิกายน",
    "12" => "ธันวาคม"
);
$thai_month_arr_short = array(
    "0" => "",
    "1" => "ม.ค.",
    "2" => "ก.พ.",
    "3" => "มี.ค.",
    "4" => "เม.ย.",
    "5" => "พ.ค.",
    "6" => "มิ.ย.",
    "7" => "ก.ค.",
    "8" => "ส.ค.",
    "9" => "ก.ย.",
    "10" => "ต.ค.",
    "11" => "พ.ย.",
    "12" => "ธ.ค."
);

function thai_date_and_time($time) {   // 19 ธันวาคม 2556 เวลา 10:10:43
    global $thai_day_arr, $thai_month_arr;
    $thai_date_return .= date("j", $time);
    $thai_date_return .= " " . $thai_month_arr[date("n", $time)];
    $thai_date_return .= " " . (date("Y", $time) + 543);
    $thai_date_return .= " เวลา " . date("H:i:s", $time);
    return $thai_date_return;
}

function thai_date_and_time_short($time) {   // 19  ธ.ค. 2556 10:10:4
    global $thai_day_arr, $thai_month_arr_short;
    $thai_date_return .= date("j", $time);
    $thai_date_return .= "&nbsp;&nbsp;" . $thai_month_arr_short[date("n", $time)];
    $thai_date_return .= " " . (date("Y", $time) + 543);
    $thai_date_return .= " " . date("H:i:s", $time);
    return $thai_date_return;
}

function thai_date_short($time) {   // 19  ธ.ค. 2556
    global $thai_day_arr, $thai_month_arr_short;
    $thai_date_return .= date("j", $time);
    $thai_date_return .= "&nbsp;&nbsp;" . $thai_month_arr_short[date("n", $time)];
    $thai_date_return .= " " . (date("Y", $time) + 543);
    return $thai_date_return;
}

function thai_date_fullmonth($time) {   // 19 ธันวาคม 2556
    global $thai_day_arr, $thai_month_arr;
    @$thai_date_return .= date("j", $time);
    $thai_date_return .= " " . $thai_month_arr[date("n", $time)];
    $thai_date_return .= " " . (date("Y", $time) + 543);
    return $thai_date_return;
}

function thai_date_short_number($time) {   // 19-12-56
    global $thai_day_arr, $thai_month_arr;
    $thai_date_return .= date("d", $time);
    $thai_date_return .= "-" . date("m", $time);
    $thai_date_return .= "-" . substr((date("Y", $time) + 543), -2);
    return $thai_date_return;
}

//การแสดงผล
// time()
// thai_date_and_time(time())
// thai_date_and_time_short(time())
// thai_date_short(time())
// thai_date_fullmonth(time())
// thai_date_short_number(time())
?>

<!DOCTYPE html>
<html>
    <?php include("head.php") ?>
    <style>
        p{
            font-size:large;
        }
    </style>
    <body>
        <?php include("header.php") ?>
        <div class="page-content">
            <div class="row">
                <div class="col-md-2">
                    <?php include("sitebar.php") ?>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-12 panel-primary">
                            <div class="content-box-header panel-heading">
                                <div class="panel-title ">รายละเอียดการจองห้องประชุม <i><?php echo $row_select_book['book_title']; ?></i></div>
                                <div class="panel-options">        

                                </div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <div class="row">
                                    <div class="col-md-7">
                                        <center><p style="font-size:xx-large;">
                                                <?= $row_select_book['room_name']; ?>
                                            </p></center>
                                        <div class="col-md-12">
                                            <p>
                                                <i class="glyphicon glyphicon-th-list"></i>&nbsp หัวข้อการจอง : <?= $row_select_book['book_title']; ?>
                                            </p>
                                        </div>
                                        <div class="col-md-7">
                                            <p>
                                                <i class="glyphicon glyphicon-calendar"></i>&nbsp ตั้งแต่วันที่ : <?= thai_date_fullmonth(strtotime($row_select_book['book_date_start'])) ?>
                                            </p>
                                        </div>
                                        <div class="col-md-5">
                                            <p>
                                                เวลา : <?= date_format(new DateTime($row_select_book['book_time_start']), 'H:i') ?> น.
                                            </p>
                                        </div>
                                        <div class="col-md-7">
                                            <p>
                                                <i class="glyphicon glyphicon-calendar"></i>&nbsp สิ้นสุดวันที่ : <?= thai_date_fullmonth(strtotime($row_select_book['book_date_finish'])) ?>
                                            </p>
                                        </div>
                                        <div class="col-md-5">
                                            <p>
                                                เวลา :  <?= date_format(new DateTime($row_select_book['book_time_finish']), 'H:i') ?> น.
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <p>
                                                <i class="glyphicon glyphicon-eye-open"></i>&nbsp จำนวนผู้ใช้งาน : <?= ($row_select_book['book_qty']) ?> คน
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <p>
                                                <i class="glyphicon glyphicon-list-alt"></i>&nbsp รายละเอียดการจอง  <br>

                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <p style="border-style: solid; border-width:1px;">
                                                <br>
                                                &nbsp <?= ($row_select_book['book_detail']) ?>
                                                <br><br>
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                            <br>
                                            <p>
                                                <i class="glyphicon glyphicon-user"></i>&nbsp ชื่อผู้จอง : <?= ($row_select_book['user_firstname']) ?><br>
                                                &nbsp &nbsp &nbsp แผนก : <?= ($row_select_book['department_name']) ?>
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                            <br>
                                            <p>
                                                <?php
                                                if ($row_select_book['book_status'] === 'ไม่อนุมัติ') {
                                                    echo "<span class='text-danger pull-right'><i class='glyphicon glyphicon-remove'></i>&nbsp สถานะการจอง <i>" . $row_select_book['book_status'] . "</i></span>";
                                                } elseif ($row_select_book['book_status'] === 'รอการอนุมัติ') {
                                                    echo "<span class='text-warning pull-right'><i class='glyphicon glyphicon-refresh'></i>&nbsp สถานะการจอง : <i>" . $row_select_book['book_status'] . "</i></span>";
                                                } elseif ($row_select_book['book_status'] === 'อนุมัติ') {
                                                    echo "<span class='text-success pull-right'><i class='glyphicon glyphicon-ok'></i>&nbsp สถานะการจอง : <i>" . $row_select_book['book_status'] . "</i></span>";
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="img-responsive">
                                            <img class="img-thumbnail" src="./images/rooms/<?= ($row_select_book['room_pic']) ?>" alt="<?= ($row_select_book['room_name']) ?>" />
                                        </div>
                                        <div class="text-right">
                                            <hr>
                                            <a href="pdf-bookdetail.php?book_id=<?php echo $book_id ?>" class="btn btn-primary" target="_blank">รายงาน การจองห้องประชุม</a>
                                            <br>
                                            <hr>
                                            <?php
                                            mysqli_free_result($result_select_book);
                                            mysqli_close($con);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("footer.php") ?>

    </body>
</html>
