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
                                <div class="panel-title ">รายงานการจองห้องประชุม</div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
                                    <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
                                </div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form name="form1" id="form1" class="form" method="Get" action="pdf-book.php">

                                            <div class="form-group col-md-6">
                                                <label for="book_date_start" class="control-label">วันที่เริ่มต้น</label>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                            <input type="text" name="book_date_start" id="book_date_start" class="form-control" data-validation="required" >
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
                                                            <input type="text" name="book_date_finish" id="book_date_finish" class="form-control" data-validation="required" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <br>
                                            <div class="pull-right">
                                                <button class="btn btn-warning" id="btn1" type="submit">เรียกรายงาน</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("footer.php") ?>

        <script>
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
        </script>
    </body>
</html>
