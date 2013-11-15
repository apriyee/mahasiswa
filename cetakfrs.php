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

?>
<div style="padding-top:4px; text-shadow:#666666; background-color: fff;" id="cetak">
    <h3>FORMULIR RENCANA STUDY</h3>
    <table width="98%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; alignment-adjust: central; 
           font-family:'Courier New', Courier, monospace; font-size:11px;">
           <?php
           $table = "frs";
           $nrpmhs = $_GET['nrp'];
           $thajar = $_GET['tahun'];
           $semest = $_GET['semester'];

           $sql_data = mysql_query("select * from $table WHERE nrp=$nrpmhs AND thajar=$thajar AND semester=$semest
               GROUP BY nrp ORDER BY nrp ASC limit 1");
           while ($res_data = mysql_fetch_array($sql_data)) { //start jika ada datanya  
               $jur = ambil('mahasiswa', 'NRP', $nrpmhs, 'JURUSAN');
               $bid = ambil('mahasiswa', 'NRP', $nrpmhs, 'BIDSTUDI');
               $wali = ambil('mahasiswa', 'NRP', $nrpmhs, 'WALI');
               ?>	
            <tr valign='top'>
                <td width='20%'>
                    Nama Mahasiswa <br>
                    NRP <br>
                    Tahun Ajaran/ Semester<br>
                </td>
                <td><b>
                        <?= tempel('mahasiswa', 'NRP', $nrpmhs, 'NAMA'); ?><br>
                        <?= tempel('mahasiswa', 'NRP', $nrpmhs, 'NRP'); ?><br>
                        <?php
                        if ($res_det[semester] == '1') {
                            echo $thajar . "/ Ganjil";
                        } else {
                            echo $thajar . "/ Genap";
                        }
                        ?>
                    </b>
                </td>
                <td width='20%'>
                    Jurusan <br>
                    Bidang Studi<br>
                    Dosen Wali<br>
                </td>
                <td><b>
                        <?= tempel('jurusan', 'id_jurusan', $jur, 'nm_jurusan'); ?><br>
                        <?= tempel('bidang', 'id_bidang', $bid, 'nm_bidang'); ?><br>
                        <?= tempel('dosen', 'id_dosen', $wali, 'nm_dosen'); ?><br>
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan='4'>
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; 
                           font-family:'Courier New', Courier, monospace; font-size:10px;">
                        <tr bgcolor="#CCCCCC" align='center'>
                            <td width="4%" height="31"><b>NO</b></td>
                            <td><b>NAMA PELAJARAN</b></td>	
                            <td width="4%"><b>SKS</b></td>	
                            <td><b>DOSEN</b></td>
                        </tr>
                        <?php
                        $kondisi = "nrp=$nrpmhs AND thajar=$thajar AND semester=$semest";
                        $sql_det = mysql_query("select * from $table WHERE $kondisi ORDER BY thajar ASC, semester DESC");
                        $total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM $table WHERE $kondisi"), 0);

                        while ($res_det = mysql_fetch_array($sql_det)) { //start jika ada datanya
                            $nmr++;
                            $kddsn = ambil('pelajaran', 'id_pel', $res_det[kd_pel], 'kd_dosen');
                            ?>	
                            <tr bgcolor="#FFFFFF" style=" border-bottom-width:thin; border-bottom-style:inset; border-bottom-color:#CCCCFF;" 
                                valign="midle" height="36">
                                <td  width='4%'><div align="center"><?php echo $nmr; ?></div></td>
                                <td>
                                    <div style="padding-left: 4px;">
                                        <?= tempel('pelajaran', 'id_pel', $res_det[kd_pel], 'kd_pel'); ?> - 
                                        <?= tempel('pelajaran', 'id_pel', $res_det[kd_pel], 'nm_pel'); ?></div>
                                </td>
                                <td align='center'>
                                    <?php //$sks = tempel('pelajaran', 'id_pel', $res_det[kd_pel], 'sks'); ?>
                                    
                                    <?php $sks = ambil('pelajaran', 'id_pel', $res_det[kd_pel], 'sks'); ?>
                                    <?= $sks; 
                                    $total_sks += (int)$sks; ?>
                                </td>
                                <td>&nbsp;<?= tempel('dosen', 'id_dosen', $kddsn, 'nm_dosen'); ?></td>


                            </tr> <?php } ?>
                    </table>

                </td>
            </tr>

            <?php
        }
        ?>
        <tr>
            <td colspan="5">
                <br>Total Mata Pelajaran : <b><?= $total_record; ?></b>
                <br>Total SKS  : <b><?= $total_sks; ?></b> SKS

            </td>
        </tr>
    </table>
    <BR>
</div>
