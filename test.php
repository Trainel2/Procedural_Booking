<!DOCTYPE html>
<html>
<head>

</head>
<body>

<table>
<tr>
<td>row1</td>
<td class="department111">name111</td>
<td><a href="#" id="111" class="btn_edit">แก้ไข</a></td>
<td><a href="#" id="111" class="btn_del">ลบ</a>
</tr>
<tr>
<td>row1</td>
<td class="department111">name222</td>
<td><a href="#" id="222" class="btn_edit">แก้ไข</a></td>
<td><a href="#" id="222" class="btn_del">ลบ</a>
</tr>
</table>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function () {
  $("a.btn_edit").on("click", function (e) {
    var row_edit = $(this).attr("id");
    var id = 'department' + row_edit;
    alert($('#'+id).text());
  });

  $("a.btn_del").on("click", function (e) {
  var row_del = $(this).attr("id");
  });
});
</script>
</body>
</html>

