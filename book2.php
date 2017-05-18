<?php require("ConnectDB.php"); ?>
<?php
  // $txt_search = mysqli_real_escape_string($con, $_GET['txt_search']);
  $sql_room = "SELECT * FROM tbl_book LEFT JOIN tbl_rooms ON tbl_book.room_id = tbl_rooms.room_id ";
  $result_room = mysqli_query($con, $sql_room);
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
                    <a href="frm_book.php" class="btn btn-primary">จองห้องประชุม</a>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4 pull-right">
                  <div class="form-group">
                    <form class="form" action="book.php" method="GET">
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
                          <th>ห้องประชุม</th>
                          <th>วันเวลาที่เริ่มต้น</th>
                          <th>วันเวลาที่สิ้นสุด</th>
                          <th>หัวข้อ</th>
                          <th>สถานะ</th>
                          <th>View</th>
                        </tr>
                        <?php
                            while ($row_room = mysqli_fetch_assoc($result_room)) {
                        ?>
                        <tr>
                          <td><?php echo $row_room['room_name'] ; ?></td>
                          <td><?php echo date_format( date_create($row_room['book_date_start']), 'd/m/Y' )  . "<br>" . $row_room['book_time_start'] ; ?></td>
                          <td><?php echo date_format( date_create($row_room['book_date_finish']), 'd/m/Y' ) . "<br>" . $row_room['book_time_finish'] ; ?></td>
                          <td><?php echo $row_room['book_title']; ?></td>
                          <?php if ($row_room['book_status'] === 'อนุมัติ') {
                            echo "<td><span class='label label-success'>" . $row_room['book_status'] . "</span></td>" ;
                          }elseif ($row_room['book_status'] === 'รออนุมัติ') {
                            echo "<td><span class='label label-warning'>" . $row_room['book_status'] . "</span></td>" ;
                          }elseif ($row_room['book_status'] === 'ไม่อนุมัติ') {
                            echo "<td><span class='label label-danger'>" . $row_room['book_status'] . "</span></td>" ;
                          } ?>
                          <td><a href="frm_edit_rooms.php?room_id=<?php echo $row_room['room_id'] ?>" class="btn_edit"><i class="glyphicon glyphicon-eye-open"></i> รายละเอียด</a></td>
                        </tr>
                        <?php } ?>
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

        $( document ).ready(function(){


        });
    </script>

  </body>
</html>
