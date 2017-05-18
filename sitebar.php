<div class="sidebar content-box" style="display: block;">
    <ul class="nav">
        <!-- Main menu -->
        <li class="current"><a href="index.php"><i class="glyphicon glyphicon-home"></i> หน้าหลัก</a></li>
        <li><a href="book.php"><i class="glyphicon glyphicon-calendar"></i> จองห้องประชุม</a></li>

        <li class="submenu">
            <a href="#">
                <i class="glyphicon glyphicon-file"></i> รายงาน
                <span class="caret pull-right"></span>
            </a>
            <!-- Sub menu -->
            <ul>
                <li><a href="report-book.php">รายงานการจองห้องประชุม</a></li>
            </ul>
        </li>

        <?php if ($s_login_status === 'admin') { ?>
            <li class="submenu">
                <a href="#">
                    <i class="glyphicon glyphicon-cog"></i> ตั้งค่า
                    <span class="caret pull-right"></span>
                </a>
                <!-- Sub menu -->
                <ul>
                    <li><a href="rooms.php">ตั้งค่าห้องประชุม</a></li>
                    <li><a href="users.php">ตั้งค่าพนักงาน</a></li>
                    <li><a href="department.php">ตั้งค่าแผนก</a></li>
                </ul>
            </li>
        <?php } ?>

    </ul>
</div>
