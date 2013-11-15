<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
//nama tabel,fieldid,varcari,fieldhasil
include 'koneksi.php';

function tempel($tabel, $idtabel, $idcari, $hasilcari) {
    $res_cari = mysql_query("SELECT * FROM $tabel WHERE $idtabel=$idcari");
    if ($row_cari = mysql_fetch_array($res_cari)) {
        print $row_cari[$hasilcari];
    }
}

function ambil($tabel, $idtabel, $idcari, $hasilcari) {
    $res_cari = mysql_query("SELECT * FROM $tabel WHERE $idtabel=$idcari");
    if ($row_cari = mysql_fetch_array($res_cari)) {
        return $row_cari[$hasilcari];
    }
}

function f_jml_mpel($nrp, $thajar, $semester) {
    $jml_sks = mysql_query("SELECT count( pelajaran.sks ) AS jmlsks FROM frs, pelajaran  
        WHERE frs.kd_pel = pelajaran.id_pel AND 
               frs.thajar = $thajar AND 
               frs.semester = $semester AND 
               frs.nrp = $nrp");
    if ($row_jml_sks = mysql_fetch_array($jml_sks)) {
        return $row_jml_sks[jmlsks];
    }
}

function ambil_jml_sks($nrp, $thajar, $semester) {
    $jml_sks = mysql_query("SELECT SUM( pelajaran.sks ) AS jmlsks FROM frs, pelajaran  
        WHERE frs.kd_pel = pelajaran.id_pel AND 
               frs.thajar = $thajar AND 
               frs.semester = $semester AND 
               frs.nrp = $nrp");
    if ($row_jml_sks = mysql_fetch_array($jml_sks)) {
        return $row_jml_sks[jmlsks];
    }
}
?>
<div style="padding-top:4px; text-shadow:#666666; background-color: fff;" id="cetak">
    <?php
    $table = "frs";
    $thajar = $_GET['tahun'];
    $semest = $_GET['semester'];
    ?>
    <h3>DAFTAR RENCANA STUDY MAHASISWA </h3>
    Tahun/ Semester :  <?php if ($semest == '1')  {  echo $thajar . "/ Ganjil";
                        } else {   echo $thajar . "/ Genap"; }  ?>  
    <table width="98%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; alignment-adjust: central; 
           font-family:'Courier New', Courier, monospace; font-size:11px;">

        <tr valign='midle' align="center">
            <td width='20%'><b>NRP</b></td>
            <td> <b>Nama Mahasiswa</b></td>
            <td width='20%'><b> Jml SKS</b></td>
            <td width='20%'><b> Jml<br>Mata Pel.</b></td>
        </tr>
        <?php
// $sql_data = mysql_query("select * from $table WHERE hajar=$thajar AND semester=$semest GROUP BY nrp
        $sql_data = mysql_query("select * from $table 
            WHERE thajar='$thajar' and semester='$semest'  
                GROUP BY nrp
                ORDER BY nrp ASC");
        while ($res_data = mysql_fetch_array($sql_data)) { //start jika ada datanya  
            //$jur = ambil('mahasiswa', 'NRP', $nrpmhs, 'JURUSAN');
            //$bid = ambil('mahasiswa', 'NRP', $nrpmhs, 'BIDSTUDI');
            //$wali = ambil('mahasiswa', 'NRP', $nrpmhs, 'WALI');
            ?>	

            <tr valign='top'>
                <td style="padding-left: 6px;"><?= $res_data['nrp']; ?></td>
                <td style="padding-left: 6px;"><?= tempel('mahasiswa', 'NRP', $res_data['nrp'], 'NAMA'); ?></td>
                <td align="center"><?= ambil_jml_sks($res_data['nrp'], $thajar, $semest); ?></td>
                <td align="center"><?= f_jml_mpel($res_data['nrp'], $thajar, $semest); ?></td>
            </tr>


            <?php
        }
        ?>

    </table>
    <BR>
</div>
