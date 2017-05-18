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
                                <div class="panel-title ">รายละเอียดพนักงาน</div>
                            </div>
                            <div class="content-box-large box-with-header">
                                <button id='remove' class='btn btn-danger' disabled><i class='glyphicon glyphicon-remove'></i> ลบข้อมูล</button>
                                <!-- table -->
                                <table id="table" data-toggle="table" data-url="history_user_book_data.php"
                                       data-pagination = "true"
                                       data-search = "true"
                                       data-show-toggle = "true"
                                       data-show-export="true"
                                       data-show-refresh="true"
                                       data-show-pagination-switch="true"
                                       data-show-columns="true"
                                       data-toolbar = "#remove"
                                       data-id-field = "book_id"
                                       >
                                    <thead>
                                        <tr>
                                            <th data-field='state' data-checkbox='true'></th>
                                            <th data-field="book_title" data-sortable="true">หัวข้อการจอง</th>
                                            <th data-field="room_name" data-sortable="true">ห้องประชุม</th>
                                            <th data-field="book_date_start" data-sortable="true">วันที่เริ่มต้น</th>
                                            <th data-field="book_time_start" data-sortable="true">เวลาเริ่มต้น</th>
                                            <th data-field="book_date_finish" data-sortable="true">วันที่สิ้นสุด</th>
                                            <th data-field="book_time_finish" data-sortable="true">เวลาสิ้นสุด</th>
                                            <th data-field="user_firstname" data-sortable="true">ผู้จอง</th>
                                            <th data-field="book_status" data-sortable="true" data-formatter="status" data-align = "center">สถานะ</th>
                                            <th data-formatter="operateFormatter" data-events="operateEvents" data-align = "center">รายละเอียด</th>
                                            <th data-formatter='operateFormatter1' data-events='operateEvents1' data-align = 'center'>แก้ไข</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div> <!-- close content  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("footer.php") ?>
        <script type="text/javascript">
            //export data
            var $table = $('#table');
            var $remove = $('#remove');
            $(document).ready(function () {
                $('#toolbar').find('select').change(function () {
                    $table.bootstrapTable('destroy').bootstrapTable({
                        exportDataType: $(this).val()
                    });
                });
            })

            //สถานะของการจองห้องประชุม
            function status(value, row, index) {
                if (row.book_status === 'อนุมัติ') {
                    return [
                        '<span class="label label-success">อนุมัติ</span>'
                    ]
                } else if (row.book_status === 'รอการอนุมัติ') {
                    return [
                        '<span class="label label-warning">รอการอนุมัติ</span>'
                    ]
                } else if (row.book_status === 'ไม่อนุมัติ') {
                    return [
                        '<span class="label label-danger">ไม่อนุมัติ</span>'
                    ]
                }
            }

            //เพิ่มสัญลักษณ์ดูรายละเอียด
            function operateFormatter(value, row, index) {
                return [
                    '<a class="btn_edit" href="javascript:void(0)" title="Edit">',
                    '<i class="glyphicon glyphicon-eye-open"></i>',
                    '</a>  '
                ].join('');
            }

            //เมื่อกดดูรายละเอียดจะทำอะไร
            window.operateEvents = {
                'click .btn_edit': function (e, value, row) {
                    window.location.replace("detail_book.php?book_id=" + row.book_id);
                }
            };

            //เพิ่มสัญลักษณ์แก้ไขรายละเอียด
            function operateFormatter1(value, row, index) {
                return [
                    '<a class="btn_edit" href="javascript:void(0)" title="Edit">',
                    '<i class="glyphicon glyphicon-edit"></i>',
                    '</a>  '
                ].join('');
            }

            //เมื่อกดแก้ไขรายละเอียดจะทำอะไร
            window.operateEvents1 = {
                'click .btn_edit': function (e, value, row) {
                    window.location.replace("frm_edit_book.php?book_id=" + row.book_id);
                }
            };

            //ลบข้อมูล


            //ปุ่มเปิดปิด delete
            $(document).ready(function () {
                $table.on('check.bs.table uncheck.bs.table ' +
                        'check-all.bs.table uncheck-all.bs.table', function () {
                            $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
                        });//close table on click select

                //delete data
                $remove.click(function () {
                    $.smkConfirm({text: 'คุณต้องการที่จะลบข้อมูลใช่หรือไม่ ?', accept: 'ยืนยัน', cancel: 'ยกเลิก'}, function (res) {
                        if (res) {
                            //get id for delete
                            var id = $.map($table.bootstrapTable('getSelections'), function (row) {
                                return row.book_id;
                            });//close var id

                            //delete with ajax (array)
                            $.get("delete_book.php", {"book_id[]": id}).done(function (data) {
                                if (data.status === "success") {
                                    $.smkAlert({text: data.message, type: data.status});
                                    $table.bootstrapTable("refresh"); // refersh datatable
                                    //disable button delete
                                    $remove.prop("disabled", true);
                                    //uncheck all data
                                    $table.bootstrapTable('togglePagination').bootstrapTable('uncheckAll').bootstrapTable('togglePagination');
                                } else {
                                    $.smkAlert({text: data.message, type: data.status});
                                }
                                $table.bootstrapTable('refresh');
                            });
                        } // close if
                    }); //close confirm
                }); // close $remove.click
            });
        </script>
    </body>
</html>
