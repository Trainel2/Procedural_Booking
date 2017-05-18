<?php

require './session.php';
include("session_expire.php");
setSessionTime(60 * 60 * 10, "login.php", null, $s_login_id, true);
?>
