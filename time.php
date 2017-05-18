<?php

function check_time_period($startTime,$endTime,$chkStartTime,$chkEndTime)
{

     if($chkStartTime > $startTime && $chkEndTime < $endTime)
     {
	echo "ช่วงเวลาที่ต้องการเช็คอยู่ในช่วง เวลาเริ่มต้น-สิ้นสุด ทั้งหมด";
     }elseif(($chkStartTime > $startTime && $chkStartTime < $endTime) || ($chkEndTime > $startTime && $chkEndTime < $endTime))
     {
	echo "ช่วงเวลาที่ต้องการเช็คมีบางช่วงอยู่ในช่วงของ เวลาเริ่มต้น-สิ้นสุด";
     }elseif($chkStartTime==$startTime || $chkEndTime==$endTime)
     {
	echo "ช่วงเวลาที่ต้องการเช็คอยู่บนขอบของ เวลาเริ่มต้น-สิ้นสุด";
     }elseif($startTime > $chkStartTime && $endTime < $chkEndTime)
     {
	echo "ช่วงเวลาเริ่มต้น-สิ้นสุด อยู่ในช่วงเวลาที่ต้องการเช็คทั้งหมด";
     }else
     {
	echo "ช่วงเวลาที่ต้องการเช็ค กับ ช่วงเวลาเริ่มต้น-สิ้นสุด ไม่ได้มีการคาบเกี่ยวกัน";
     }

}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">

<title>การตรวจสอบเช็คช่วงเวลา ที่คาบเกี่ยวซ้ำซ้อนกัน ด้วย PHP (Check For Time Period Overlap)</title>

<STYLE type=text/css>
  A:link { color: #0000cc; text-decoration:none}
  A:visited {color: #0000cc; text-decoration: none}
  A:hover {color: red; text-decoration: none}
 </STYLE>
<style type="text/css">
<!--
small { font-family: Arial, Helvetica, sans-serif; font-size: 8pt; } 
input, textarea { font-family: Arial, Helvetica, sans-serif; font-size: 9pt; } 
b { font-family: Arial, Helvetica, sans-serif; font-size: 11pt; } 
big { font-family: Arial, Helvetica, sans-serif; font-size: 15pt; } 
strong { font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight : extra-bold; } 
font, td { font-family: Arial, Helvetica, sans-serif; font-size: 11pt; } 
BODY { font-size: 11pt; font-family: Arial, Helvetica, sans-serif; } 
-->
</style>

</head>

<body>

<center>

<u><big>การตรวจสอบเช็คช่วงเวลา ที่คาบเกี่ยวซ้ำซ้อนกัน ด้วย PHP (Check For Time Period Overlap)</big></u>
<br><br>

คุณสามารถนำฟังก์ชันตรวจสอบเช็คช่วงเวลาซ้ำซ้อนนี้ ไปพัฒนาต่อในระบบของคุณได้เลยครับ

<br><br>

<table border="1" width="850" style="border-collapse: collapse" bordercolor="#111111" cellpadding="5" cellspacing="0">
<tr bgcolor="#EDF6B0">
   <td width="6%"><center><b>กรณี</b></center></td>
   <td width="17%"><center><b>เวลาเริ่มต้น-สิ้นสุด</b></center></td>
   <td width="17%"><center><b>ช่วงเวลาที่จะเช็ค</b></center></td>
   <td width="60%"><center><b>ผลการตรวจสอบ</b></center></td>
</tr>

<tr>
   <td><center>1</center></td>
   <td><center>7:00 - 10:30 น.</center></td>
   <td><center>7:30 - 10:10 น.</center></td>
   <td><center><?=check_time_period(strtotime("7:00"),strtotime("10:30"),strtotime("7:30"),strtotime("10:10")); ?></center></td>
</tr>

<tr>
   <td><center>2</center></td>
   <td><center>7:00 - 10:30 น.</center></td>
   <td><center>6:30 - 08:10 น.</center></td>
   <td><center><?=check_time_period(strtotime("7:00"),strtotime("10:30"),strtotime("6:30"),strtotime("8:10")); ?></center></td>
</tr>

<tr>
   <td><center>3</center></td>
   <td><center>7:00 - 10:30 น.</center></td>
   <td><center>6:30 - 10:30 น.</center></td>
   <td><center><?=check_time_period(strtotime("7:00"),strtotime("10:30"),strtotime("6:30"),strtotime("10:30")); ?></center></td>
</tr>

<tr>
   <td><center>4</center></td>
   <td><center>7:00 - 10:30 น.</center></td>
   <td><center>6:30 - 12:30 น.</center></td>
   <td><center><?=check_time_period(strtotime("7:00"),strtotime("10:30"),strtotime("6:30"),strtotime("12:30")); ?></center></td>
</tr>

<tr>
   <td><center>5</center></td>
   <td><center>7:00 - 10:30 น.</center></td>
   <td><center>15:30 - 19:30 น.</center></td>
   <td><center><?=check_time_period(strtotime("7:00"),strtotime("10:30"),strtotime("15:30"),strtotime("19:30")); ?></center></td>
</tr>

</table>

<br>
<hr width="75%">
<center><big>สนับสนุนโดย : <a href="http://www.codetukyang.com" target="_blank">CodeTukYang.Com</a></big></center>
<hr width="75%">

</center>
</body>
</html>
