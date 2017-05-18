<?php
//สร้างรายงาน PDF
include './session.php';
include './mpdf/mpdf.php'; //นำไฟล์รายงานเข้ามาสร้างรายงาน
require("ConnectDB.php");


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
    $thai_date_return .= date("j", $time);
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

ob_start(); // คำสั่งรันไฟล์ให้เสร็จเรียบร้อยก่อนส่งออกไปเป็น pdf
?>

<!DOCTYPE HTML>
<html>
    <head>
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">
                    <b><?= $row_select_book['room_name']; ?></b>
                </h1>
                <hr>
                <p>
                    หัวข้อการจอง : <?= $row_select_book['book_title']; ?>
                </p>
                <p>
                    ตั้งแต่วันที่ : <?= thai_date_fullmonth(strtotime($row_select_book['book_date_start'])) ?>
                    เวลา : <?= date_format(new DateTime($row_select_book['book_time_start']), 'H:i') ?> น.
                </p>
                <p>
                    สิ้นสุดวันที่ : <?= thai_date_fullmonth(strtotime($row_select_book['book_date_finish'])) ?>
                    เวลา :  <?= date_format(new DateTime($row_select_book['book_time_finish']), 'H:i') ?> น.
                </p>
                <p>
                    จำนวนผู้ใช้งาน : <?= ($row_select_book['book_qty']) ?> คน
                </p>

                <p>รายละเอียดการจอง  </p>
                <p style="text-indent: 2.5em;">
                    <?= ($row_select_book['book_detail']) ?>
                </p>
                <p>
                    ชื่อผู้จอง : <?= ($row_select_book['user_firstname']) ?><br>
                    แผนก : <?= ($row_select_book['department_name']) ?>
                </p>
                <?php
                if ($row_select_book['book_status'] === 'ไม่อนุมัติ') {
                    echo "<span class='text-danger pull-right'><i class='glyphicon glyphicon-remove'></i> สถานะการจอง <i>" . $row_select_book['book_status'] . "</i></span>";
                } elseif ($row_select_book['book_status'] === 'รอการอนุมัติ') {
                    echo "<span class='text-warning pull-right'><i class='glyphicon glyphicon-refresh'></i> สถานะการจอง : <i>" . $row_select_book['book_status'] . "</i></span>";
                } elseif ($row_select_book['book_status'] === 'อนุมัติ') {
                    echo "<span class='text-success pull-right'><i class='glyphicon glyphicon-ok'></i> สถานะการจอง : <i>" . $row_select_book['book_status'] . "</i></span>";
                }
                ?>
            </div>
        </div>






        <?php
        $html = ob_get_contents(); //หลังจากทำงานเสร็จก็ส่ง output ไป เก็บใน html
        ob_end_clean(); //ล้างข้อมูลที่ gen มา

        $mpdf = new mpdf('UTF-8');
        $mpdf->Bookmark('Start of the document');

//$mpdf = new mpdf('UTF-8','A4-L'); //กระดาษแนวนอน
//$mpdf = new mpdf('UTF-8', array(100,100)); //กำหนดขนาดกระดาษ หน่วยเป็นมิลลิเมตร

        $mpdf->margin_header = 9; //ขอบหัวกระดาษ
        $mpdf->SetHeader('รายงานการขอใช้ห้องประชุม| |หน้าที่ {PAGENO}'); //หัวรายงาน

        $mpdf->margin_footer = 9;
        $mpdf->SetFooter('รายงานโดย ' . $s_login_firstname . ' |  | ออกรายงาน ' . date('d/m/Y H:i:s'));

        $styleSheet = file_get_contents('./bootstrap/css/printpdf.css'); //ดึง style มาใช้งาน (bootstrap) ที่เขียนไว้
        $mpdf->WriteHTML($styleSheet, 1); //ลำดับ 1 css 2 body (html)
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output("Bookdetail-" . time() . ".pdf", "I");

        mysqli_free_result($result_select_book);
        mysqli_close($con);
        exit();
        ?>
    </body>
</html>
