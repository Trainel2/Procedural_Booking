<?php
include("set_session.php");
include("./ConnectDB.php");

//function นับตัวอักษร UTF-8
function utf8_strlen($s) {
    $c = strlen($s);
    $l = 0;
    for ($i = 0; $i < $c; ++$i) {
        if ((ord($s[$i]) & 0xC0) != 0x80) {
            ++$l;
        }
    }
    return $l;
}
?>

<!DOCTYPE html>
<html>
    <?php include("head.php") ?>
    <body>
        <?php include("header.php") ?>
        <style>
            /*style popup learn model*/
            #detail {
                width: 600px;
                padding: 30px; 
                display:none;

                background: #FFF;
                border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;
                box-shadow: 0px 0px 4px rgba(0,0,0,0.7); -webkit-box-shadow: 0 0 4px rgba(0,0,0,0.7); -moz-box-shadow: 0 0px 4px rgba(0,0,0,0.7);
            }

            #lean_overlay {
                position: fixed;
                z-index:100;
                top: 0px;
                left: 0px;
                height:100%;
                width:100%;
                background: #000;
                display: none;
            }
        </style>
        <div class="page-content">
            <div class="row">
                <div class="col-md-2">
                    <?php include("sitebar.php") ?>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-8 panel-info">
                            <div class="content-box-header panel-heading">
                                <div class="panel-title ">กระดานข่าว</div>
                                <?php if ($s_login_status === 'admin') { ?>
                                    <div class="panel-options">
                                        <a href="frm_news.php"><i class="glyphicon glyphicon-plus"></i> เพิ่ม</a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="content-box-large box-with-header">
                                <div class="table table-responsive">
                                    <table class="table table-striped">
                                        <?php
                                        $sql_select_news = "SELECT * FROM tbl_news ORDER BY news_id DESC";
                                        $result_select_news = mysqli_query($con, $sql_select_news);
                                        $i = 1;
                                        while ($row_select_news = mysqli_fetch_assoc($result_select_news)) {
                                            if ($i <= 9) {
                                                ?>
                                                <tr>
                                                    <td style="width: 20%"><?php echo $row_select_news['news_title'] ?></td>
                                                    <td style="width: 50%">
                                                        <?php
                                                        if (utf8_strlen($row_select_news['news_detail']) <= 55) {
                                                            echo str_replace("<br>","",$row_select_news['news_detail']);
                                                        } else if (strlen($row_select_news['news_detail']) > 55) {
                                                            echo mb_substr($row_select_news['news_detail'], 0, 55, 'UTF-8') . " ...";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="width: 10%"><?php echo date_format(new DateTime($row_select_news['news_date']), "d/m/Y"); ?></td>
                                                    <td style = "width: 15%; text-align: right;">
                                                        <a href = "#detail" rel="leanModal" id="<?php echo $row_select_news['news_id']; ?>" class="btn_read"><i class = "glyphicon glyphicon-eye-open"></i> </a> &nbsp
                                                        <?php if ($s_login_status === 'admin') { ?>
                                                            <a href = "frm_edit_news.php?news_id=<?php echo $row_select_news['news_id']; ?>"><i class = "glyphicon glyphicon-pencil"></i> </a>
                                                        <?php } ?>
                                                    </td>


                                                </tr>
                                                <?php
                                            } else {
                                                break;
                                            }
                                            $i++;
                                        }
                                        mysqli_free_result($result_select_news);
                                        ?>    
                                    </table>
                                </div>

                            </div>
                        </div>



                        <div class="col-md-4 panel-warning">
                            <div class="content-box-header panel-heading">
                                <div class="panel-title ">การใช้ห้องประชุม ณ <?php echo date("d/m/Y"); ?></div>
                                <div class="panel-options">

                                </div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <?php
                                $sql_select_book = "SELECT * FROM  tbl_book 
                                    LEFT JOIN tbl_rooms ON tbl_book.room_id = tbl_rooms.room_id 
                                    WHERE  book_status = 'อนุมัติ'
                                    AND ((book_date_start <= CURDATE() AND book_date_finish >= CURDATE())
                                    OR (book_date_start <= CURDATE() AND book_date_finish >= CURDATE())
                                    OR (book_date_start >= CURDATE() AND book_date_start <= CURDATE())
                                    OR (book_date_finish >= CURDATE() AND book_date_finish <= CURDATE()))
                                    ORDER BY book_time_start, tbl_rooms.room_name DESC";
                                $result_select_book = mysqli_query($con, $sql_select_book);
                                while ($row_select_book = mysqli_fetch_assoc($result_select_book)) {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <a href="detail_book.php?book_id=<?php echo $row_select_book['book_id'] ?>"><i class="glyphicon glyphicon-eye-open"></i></a> &nbsp
                                            <?php echo $row_select_book['room_name']; ?>
                                        </div>
                                        <div class="col-md-7">
                                            <?php echo date_format(new datetime($row_select_book['book_time_start']), "H:i") . " &nbsp  ถึง &nbsp  " . date_format(new DateTime($row_select_book['book_time_finish']), "H:i"); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="detail">
        </div>


        <?php include("footer.php") ?>
        <script type="text/javascript" src="bootstrap/js/jquery.leanModal.min.js"></script>

        <script type="text/javascript">
            $(function () {
                $('a[rel*=leanModal]').leanModal({top: 20, overlay: 0.5, closeButton: ".modal_close"});
            });

            $("a.btn_read").on("click", function (e) {
                var id = $(this).attr("id");
                $.ajax({// ใช้ ajax ด้วย jQuery ดึงข้อมูลจากฐานข้อมูล  
                    url: "detail_news.php?news_id=" + id,
                    async: false,
                    success: function (getData) {
                        $("div#detail").html(getData); //นำข้อมูลมาแสดง  
                    }
                });
            });


        </script>

    </body>
</html>
