<?php
include 'koneksi.php';
$vnrp = $_GET['nrp']; 

$result = mysql_query("SELECT * FROM mahasiswa  WHERE NRP = '$vnrp'");
if ($row_list = mysql_fetch_assoc($result)) {
    $vnama = $row_list['NAMA'];
     echo $vnama;
} 

?>
