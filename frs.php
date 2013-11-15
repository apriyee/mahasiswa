<script src="js/jquery-1.9.1.js"></script>
<link rel="stylesheet" href="chosen.css">
<script src="js/chosen.jquery.js" type="text/javascript"></script>


<script language="javascript" type="text/javascript">
    function clearText(field)
    {
        if (field.defaultValue == field.value)
            field.value = '';
        else if (field.value == '')
            field.value = field.defaultValue;
    }
</script>

<script type="text/javascript">

    var popupWindow = null;

    function child_open()
    {
        popupWindow = window.open('new.jsp', "_blank", "directories=no, status=no, menubar=no, scrollbars=yes, resizable=no,width=600, height=280,top=200,left=200");
    }
    function parent_disable() {
        if (popupWindow && !popupWindow.closed)
            popupWindow.focus();
    }
</script>

<script type="text/javascript">
    function cekfrs() {
        document.getElementById('idcek').value = '1';
        document.form1.submit();
    }

    function clearnrp() {
        document.getElementById('nrp').value = '';
        document.getElementById('pelajaran').value = '';
    }

    function cekpel() {

        var vthn = document.getElementById('tahun').value;
        var vsms = document.getElementById('semester').value;
        var vnrp = document.getElementById('nrp').value;
        var vpel = document.getElementById('pelajaran').value;

        var nama = $('#nama').val();
        $.ajax({
            type: "POST",
            //url: "cek_nrp.php?nrp=" + vnrp,
            url: "cek_pelajaran.php?nrp=" + vnrp + "&tahun=" + vthn + "&semester=" + vsms + "&pelajaran=" + vpel,
            data: {nama: nama}
        }).done(function(data) {
            if (!data) {
                return;
            } else {
                alert("Maaf, Pelajaran ini sudah di ambil " + data);
                document.getElementById('pelajaran').value = '';
                document.getElementById('pelajaran').focus();
            }
        });

    }

    function konf_hapus(id) {
        var id_del = id;
        var x = window.confirm("Maaf, Yakin akan menghapus data ini ")
        if (x) {
            var answer = window.prompt("Maaf, Penghapusan diperlukan otoritas!, silahkan Enter password ")
            if (answer == '123456') {
                window.location.href = '?p=frs&opsi=hapus&id=' + id_del;
            } else {
                window.alert("Maaf !, Password salah... silahkan hubungai admin")
            }
        } else {
            window.alert("Bagus!, Saudara membatalkan penghapusan !")

        }
    }
</script>
<?php
include 'koneksi.php';

if ($_POST[cek] == '1') {
    $varnrp = $_POST['nrp'];
    $vartahun = $_POST['tahun'];
    $vsemes = $_POST['semester'];
    $var_taget = '?p=frs&opsi=tambah';
    $var_tombol = "Tambah data";
} else {

    if ($_GET[opsi] == 'tambah') {
        $varnrp = $_POST['nrp'];
        $vartahun = $_POST['tahun'];
        $vsemes = $_POST['semester'];

        $save = "INSERT INTO frs 
        SET nrp='$_POST[nrp]',
            thajar='$_POST[tahun]',
            semester='$_POST[semester]',
            kd_pel='$_POST[pelajaran]'";
        if (!mysql_query($save)) {
            echo "Gagal !, <br>" . mysql_error();
        }
    } elseif ($_GET[opsi] == 'hapus') {
        $varid = $_GET['id'];
        
        $varnrp = ambil('frs', 'id_frs', $varid, 'nrp'); 
        $vartahun = ambil('frs', 'id_frs', $varid, 'thajar'); 
        $vsemes =  ambil('frs', 'id_frs', $varid, 'semester'); 
        
        
        $hapus = "DELETE FROM frs WHERE id_frs = $varid";
        if (!mysql_query($hapus)) {
            echo "Gagal !, <br>" . mysql_error();
        } 
        
    } elseif ($_GET[opsi] == 'edit') {
        $varid = $_GET['id'];
        $list = mysql_query("SELECT * FROM frs WHERE id_frs = '$varid'");
        if ($row_list = mysql_fetch_assoc($list)) {
            $varnrp = $row_list['nrp'];
            $vartahun = $row_list['thajar'];
            $vsemes = $row_list['semester'];
            $varpel = $row_list['kd_pel'];
        }
    } elseif ($_GET[opsi] == 'update') {
        $varid = $_POST['id'];
        $update = "UPDATE frs 
        SET nrp='$_POST[nrp]',
            thajar='$_POST[tahun]',
            semester='$_POST[semester]',
            kd_pel='$_POST[pelajaran]' WHERE id_frs = $varid";
        if (!mysql_query($update)) {
            echo "Gagal !, <br>" . mysql_error();
        }
    }
}

if ($_GET[opsi] == 'edit') {
    $opti = 'disabled="disabled"';
    $var_taget = '?p=frs&opsi=update';
    $var_tombol = "Update data";
} else {
    $opti = '';
    $var_taget = '?p=frs&opsi=tambah';
    $var_tombol = "Tambah data";
}
?>


<?php
$thn1 = intval(date("Y"));
$thn2 = intval(date("Y")) + 2;
?> 

<style>
    .td {padding-left: 2px; }
</style>


<body onFocus="parent_disable();" onclick="parent_disable();">
    <table width="100%" border='0'>
        <tr>
            <td><div style="float: left; padding-left: 12px;">
                    <h2 align="center">PENGISIAN FORMULIR RENCANA STUDY </h2>
                </div>
            </td>

        </tr>
        <tr>
            <td>
                <div style="padding-right: 12px; float: right; padding-top: 10px;">
                    <form name='form1' id='cilik' method="POST" action="<?php echo $var_taget; ?>" >
                        <input name="cek" id="idcek" type="hidden" value="0">
                        <input name="id" type="hidden" value="<?php echo $varid; ?>">
                        <table>
                            <tr align='center' style='font-style: oblique;'>
                                <td>TAHUN</td>
                                <td>SEMESTER</td>
                                <td>MAHASISWA</td>
                                <td>MATA PELAJARAN</td>
                                <td>&nbsp;<!-- <a href="javascript:child_open()">Click me</a> --></td>
                            </tr>
                            <tr>
                                <td>
                                    <select name='tahun' id="tahun" onChange="javascript:clearnrp();">
                                        <option value="" <?php
if (!(strcmp("", $vartahun))) {
    echo "SELECTED";
}
?>  >Tahun </option>
                                                <?php
                                                for ($num = $thn1; $num <= $thn2; $num++) {
                                                    ?>
                                            <option value="<?= $num; ?>" 
                                            <?php
                                            if ($num == $select) {
                                                echo "selected";
                                            }
                                            ?>  
                                            <?php
                                            if (!(strcmp($num, $vartahun))) {
                                                echo "SELECTED";
                                            }
                                            ?>><?= $num; ?></option>
                                                <?php } ?>
                                    </select> 

                                </td>
                                <td>
                                    <select name="semester" id="semester" onChange="javascript:clearnrp();">
                                        <option value="''" <?php
                                                if (!(strcmp('', $vsemes))) {
                                                    echo "SELECTED";
                                                }
                                                ?>> -- Semester --</option>
                                        <option value="0" <?php
                                        if (!(strcmp('0', $vsemes))) {
                                            echo "SELECTED";
                                        }
                                                ?>>GENAP</option>
                                        <option value="1" <?php
                                        if (!(strcmp('1', $vsemes))) {
                                            echo "SELECTED";
                                        }
                                                ?>>GANJIL</option>

                                    </select>
                                </td>
                                <td>
                                    <select name='nrp' id="nrp" onChange="javascript:cekfrs();" class="chosen-select">
                                        <option value="" <?php
                                        if (!(strcmp("", $varnrp))) {
                                            echo "SELECTED";
                                        }
                                                ?> >  -- Pilih Mahasiswa --  </option>
                                                <?php
                                                $data_mhs = mysql_query("SELECT * FROM mahasiswa");
                                                while ($data = mysql_fetch_assoc($data_mhs)) {
                                                    ?>
                                            <option value="<?php echo $data['NRP']; ?>" 
                                            <?php
                                            if ($data['NAMA'] == $select) {
                                                echo "selected";
                                            }
                                            ?>  
                                            <?php
                                            if (!(strcmp($data['NRP'], $varnrp))) {
                                                echo "SELECTED";
                                            }
                                            ?>><?= '[' . $data['NRP'] . '] ' . $data['NAMA']; ?> 
                                            </option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <select name='pelajaran' id="pelajaran" onChange="javascript:cekpel();" class="chosen-select">

                                    <!-- <select name='pelajaran' id="pelajaran" onChange="javascript:cekpel();"> -->
                                        <option value="" <?php
                                        if (!(strcmp("", $varpel))) {
                                            echo "SELECTED";
                                        }
                                        ?>  >  -- Pilih Pelajaran --  </option>
                                                <?php
                                                $data_pel = mysql_query("SELECT * FROM pelajaran");
                                                while ($data = mysql_fetch_assoc($data_pel)) {
                                                    ?>
                                            <option <?= $opti; ?>  value="<?php echo $data['id_pel']; ?>" 
                                            <?php
                                            if ($data['nm_pel'] == $select) {
                                                echo "selected";
                                            }
                                            ?>  
                                            <?php
                                            if (!(strcmp($data['id_pel'], $varpel))) {
                                                echo "SELECTED";
                                            }
                                            ?>><?= '[' . $data['kd_pel'] . '] ' . $data['nm_pel']; ?> 
                                            </option>
                                        <?php } ?>
                                    </select>

                                </td>

                                <td><a href="#" onclick='submit()' class="tombol"><?php echo $var_tombol; ?></a></td>
                            </tr>
                        </table>
                    </form>
                </div>

            </td>
        </tr>
    </table>
    <hr>


    <div style="padding-top:4px; text-align:justify; text-shadow:#666666;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; 
               font-family:'Courier New', Courier, monospace; font-size:12px;">
               <?php
               $hal = $_GET[hal];
               if (!isset($_GET['hal'])) {
                   $page = 1;
               } else {
                   $page = $_GET['hal'];
               }

               $jmlperhalaman = 1;  //JUMLAH RECORD PER HALAMAN 
               $offset = (($page * $jmlperhalaman) - $jmlperhalaman);
               $table = "frs";
               $pgurl = "?p=frs";

//$varnrp = $_POST['nrp'];
//$vartahun = $_POST['tahun'];
//$vsemes = $_POST['semester'];

               $sql_data = mysql_query("select * from $table WHERE nrp='$varnrp' AND thajar='$vartahun' AND semester='$vsemes'
    GROUP BY nrp ORDER BY nrp ASC limit $offset,$jmlperhalaman");
               while ($res_data = mysql_fetch_array($sql_data)) { //start jika ada datanya  
                   $nrpmhs = $res_data[nrp];
                   $jur = ambil('mahasiswa', 'NRP', $nrpmhs, 'JURUSAN');
                   $bid = ambil('mahasiswa', 'NRP', $nrpmhs, 'BIDSTUDI');
                   $wali = ambil('mahasiswa', 'NRP', $nrpmhs, 'WALI');
                   ?>	
                <tr valign='top'>
                    <td width='20%'>
                        Nama Mahasiswa <br>
                        NRP 
                    </td>
                    <td><b>
                            <?= tempel('mahasiswa', 'NRP', $nrpmhs, 'NAMA'); ?><br>
                            <?= tempel('mahasiswa', 'NRP', $nrpmhs, 'NRP'); ?>
                        </b>
                    </td>
                    <td width='20%'>
                        Jurusan <br>
                        Bidang Studi<br>
                        Dosen Wali
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
                               font-family:'Courier New', Courier, monospace; font-size:12px;">
                            <tr bgcolor="#CCCCCC" align='center'>
                                <td width="4%" height="31"><b>NO</b></td>
                                <td><b>TAHUN/SEMESTER</b></td>	
                                <td><b>NAMA PELAJARAN</b></td>	
                                <td><b>SKS</b></td>	
                                <td><b>DOSEN</b></td>
                                <td><b>OPSI</b></td>
                            </tr>
                            <?php
                            $sql_det = mysql_query("select * from $table WHERE nrp=$nrpmhs AND thajar=$vartahun AND semester=$vsemes
                        ORDER BY thajar ASC, semester DESC");
                            while ($res_det = mysql_fetch_array($sql_det)) { //start jika ada datanya
                                $no++;
                                $kddsn = ambil('pelajaran', 'id_pel', $res_det[kd_pel], 'kd_dosen');
                                ?>	
                                <tr bgcolor="#FFFFFF" style=" border-bottom-width:thin; border-bottom-style:inset; border-bottom-color:#CCCCFF;" 
                                    valign="top" height="36">
                                    <td  width='4%'><div align="center"><?php echo $no; ?></div></td>
                                    <td align='left' style='padding-left: 4px;'>
                                        <?= $res_det[thajar]; ?>/<?php
                                        if ($res_det[semester] == '1') {
                                            echo "Ganjil";
                                        } else {
                                            echo "Genap";
                                        }
                                        ?>
                                    </td>
                                    <td>&nbsp;
                                        <a href="?p=frs&opsi=edit&id=<?php echo $res_det[id_frs]; ?>">
                                            [<?= tempel('pelajaran', 'id_pel', $res_det[kd_pel], 'kd_pel'); ?>]&nbsp;
                                            <?= tempel('pelajaran', 'id_pel', $res_det[kd_pel], 'nm_pel'); ?>
                                        </a>
                                    </td>
                                    <td align='center'><?= tempel('pelajaran', 'id_pel', $res_det[kd_pel], 'sks'); ?></td>
                                    <td>&nbsp;<?= tempel('dosen', 'id_dosen', $kddsn, 'nm_dosen'); ?></td>

                                    <td><span style="float: right; padding-right: 6px;">
                                            <a href="#" 
                                               onclick="konf_hapus(<?php echo $res_det[id_frs]; ?>);">Del</a>

                                        </span>
                                    </td>
                                </tr> <?php } ?>
                        </table>

                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    </script> 
</p>
</body>