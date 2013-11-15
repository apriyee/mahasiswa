<?php
include 'koneksi.php';

function tempel($tabel, $idtabel, $idcari, $hasilcari) {
        $res_cari = mysql_query("SELECT * FROM $tabel WHERE $idtabel=$idcari");
        if ($row_cari = mysql_fetch_array($res_cari)) {
            print $row_cari[$hasilcari];
        }
    }
    
$vnrp = $_GET['nrp'];
$vthn = $_GET['tahun'];
$vsms = $_GET['semester'];
$vpel = $_GET['pelajaran'];


$cek_frs = mysql_query("SELECT * FROM frs  
    WHERE nrp = '$vnrp' AND  
          thajar = '$vthn' AND  
          semester = '$vsms' AND  
              kd_pel = '$vpel'");
if ($row_list = mysql_fetch_array($cek_frs)) {
    $vnrp = $row_list['nrp'];
    echo tempel('mahasiswa', 'NRP', $vnrp, 'NAMA'); 
     //$vnrp .'-'. $vthn .'-'. $vsms .'-'. $vpel;
}
?>
