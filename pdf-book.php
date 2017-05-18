<?php
include './session.php';
include './mpdf/mpdf.php'; //นำไฟล์รายงานเข้ามาสร้างรายงาน
require("ConnectDB.php");

$book_date_start = $_GET['book_date_start'];
$book_date_finish = $_GET['book_date_finish'];

//$start_year = date_format(new DateTime($book_date_start), 'Y');
//$finish_year = date_format(new DateTime($book_date_finish), 'Y');
//
//$start_month = date_format(new DateTime($book_date_start), 'm');
//$finish_month = date_format(new DateTime($book_date_finish), 'm');


$sql_range = "SELECT * FROM tbl_book
              LEFT JOIN tbl_users ON tbl_users.user_id = tbl_book.user_id
              LEFT JOIN tbl_rooms ON  tbl_rooms.room_id = tbl_book.room_id
              LEFT JOIN tbl_department ON tbl_users.department_id = tbl_department.department_id
              WHERE book_status = 'อนุมัติ'
              AND (((book_date_start <= '$book_date_start' AND book_date_finish >= '$book_date_start')
              OR (book_date_start <= '$book_date_finish' AND book_date_finish >= '$book_date_finish')
              OR (book_date_start >= '$book_date_start' AND book_date_start <= '$book_date_finish')
              OR (book_date_finish >= '$book_date_start' AND book_date_finish <= '$book_date_finish')))";

$result_sql_range = mysqli_query($con, $sql_range);

ob_start(); // คำสั่งรันไฟล์ให้เสร็จเรียบร้อยก่อนส่งออกไปเป็น pdf
?>

<!DOCTYPE html>
<html lang="en">
    <head>

    </head>
    <body>
        <h1 class="text-center">รายงานการจองห้องประชุม</h1>
        <p class="text-center">ระหว่างวันที่ <?php echo $book_date_start ?> ถึงวันที่ <?php echo $book_date_finish ?></p>
        <div class="table table-responsive">
            <table id="table" class="table table-condensed">
                <tr>
                    <th>หัวข้อการจอง</th>
                    <th>ห้องประชุม</th>
                    <th>วันที่เริ่มต้น</th>
                    <th>เวลาเริ่มต้น</th>
                    <th>วันที่สิ้นสุด</th>
                    <th>เวลาสิ้นสุด</th>
                    <th>จำนวนผู้ใช้งาน / วัน</th>
                    <th>ผู้จอง</th>
                </tr>

                <?php while ($row_sql_range = mysqli_fetch_assoc($result_sql_range)) { ?>
                    <tr>
                        <td><?php echo $row_sql_range['book_title']; ?></td>
                        <td><?php echo $row_sql_range['room_name']; ?></td>
                        <td><?php echo $row_sql_range['book_date_start']; ?></td>
                        <td><?php echo $row_sql_range['book_time_start']; ?></td>
                        <td><?php echo $row_sql_range['book_date_finish']; ?></td>
                        <td><?php echo $row_sql_range['book_time_finish']; ?></td>
                        <td><?php echo $row_sql_range['book_qty']; ?></td>
                        <td><?php echo $row_sql_range['user_firstname']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>


        <?php
        $html = ob_get_contents(); //หลังจากทำงานเสร็จก็ส่ง output ไป เก็บใน html
        ob_end_clean(); //ล้างข้อมูลที่ gen มา
//$mpdf = new mpdf('UTF-8');
        $mpdf = new mpdf('UTF-8', 'A4-L'); //กระดาษแนวนอน
//$mpdf = new mpdf('UTF-8', array(100,100)); //กำหนดขนาดกระดาษ หน่วยเป็นมิลลิเมตร

        $mpdf->Bookmark('Start of the document');


        $mpdf->margin_header = 9; //ขอบหัวกระดาษ
        $mpdf->SetHeader('รายงานการขอใช้ห้องประชุม| |หน้าที่ {PAGENO}'); //หัวรายงาน

        $mpdf->margin_footer = 9;
        $mpdf->SetFooter('รายงานโดย ' . $s_login_firstname . ' |  | ออกรายงาน ' . date('d/m/Y H:i:s'));

        $styleSheet = file_get_contents('./bootstrap/css/printpdf.css'); //ดึง style มาใช้งาน (bootstrap) ที่เขียนไว้
        $mpdf->WriteHTML($styleSheet, 1); //ลำดับ 1 css 2 body (html)
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output("Bookdetail-" . time() . ".pdf", "I");
        mysqli_free_result($result_sql_range);
        mysqli_close($con);
        exit();
        ?>
    </body>
</html>
