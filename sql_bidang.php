<?php

include 'koneksi.php';
$value = $_POST['value'];
$list = mysql_query("select * from bidang where kd_jurusan='$value' order by nm_bidang asc");

echo '<select name="bidstudi">';
while ($row_list = mysql_fetch_assoc($list)) {
   echo '<option value="' . $row_list["id_bidang"] . '">' . $row_list["nm_bidang"] . '</option>';
}
echo "</select>";

?>

