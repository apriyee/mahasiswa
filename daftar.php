 
<script language="javascript" type="text/javascript">
    function clearText(field)
    {
        if (field.defaultValue == field.value)
            field.value = '';
        else if (field.value == '')
            field.value = field.defaultValue;
    }

    function konfirmasi(nrp) {
        var nrpdel = nrp;
        var x = window.confirm("Maaf, Yakin akan menghapus data " + nrpdel)
        if (x) {
            var answer = window.prompt("Data mahasiswa akan di hapus !, silahkan Enter password ")
            if (answer == '123456') {
                window.location.href = '?p=daftar&opsi=delete&id=' + nrp;
            } else {
                window.alert("Maaf !, Password salah... silahkan hubungai admin")
            }
        } else {
            window.alert("Bagus!, Saudara membatalkan penghapusan !")

        }
    }

    
</script>

<?php
include "koneksi.php";
if ($_GET['opsi'] == 'delete') {
    $delnrp = $_GET['id'];
    $total_frs = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM frs WHERE nrp = '$delnrp'"), 0);
    if ($total_frs >= 1) {
        echo '<script type="text/javascript">pesan(); </script>';
    } else {
        $delete = "DELETE FROM mahasiswa WHERE NRP = '$delnrp'";
        if (!mysql_query($delete)) {
            echo "Gagal !, <br>" . mysql_error();
        } else {
            echo '<script type="text/javascript">sukses(); </script>';
        }
    }

// echo "proses delete ".$_GET['id']; 
}

if ($_POST[Submit] == 'Simpan Data') {
    include 'koneksi.php';

//list($tgl, $bll, $thl) = explode("/", $_POST[tglahir]);
    list( $bll, $tgl, $thl) = explode("/", $_POST[tglahir]);
    $tglahir = $thl . '-' . $bll . '-' . $tgl;

    $save = "INSERT INTO mahasiswa
        SET NRP='$_POST[nrp]', 
        NAMA='$_POST[nama]', 
        TMLAHIR='$_POST[tmlahir]', 
        TGLAHIR='$tglahir', 
        JURUSAN='$_POST[jurusan]', 
        BIDSTUDI='$_POST[bidstudi]', 
        ALAMAT='$_POST[alamat]', 
        WALI='$_POST[dosenwali]'";
    if (!mysql_query($save)) {
        echo "Gagal !, <br>" . mysql_error();
    }
}

if ($_POST[Submit] == 'Update Data') {
    include 'koneksi.php';

    list( $bll, $tgl, $thl) = explode("/", $_POST[tglahir]);
//list($tgl, $bll, $thl) = explode("/", $_POST[tglahir]);
    $tglahir = $thl . '-' . $bll . '-' . $tgl;

    $update = "UPDATE mahasiswa
        SET  NAMA='$_POST[nama]', 
             TMLAHIR='$_POST[tmlahir]', 
             TGLAHIR='$tglahir', 
             JURUSAN='$_POST[jurusan]', 
             BIDSTUDI='$_POST[bidstudi]', 
             ALAMAT='$_POST[alamat]', 
             WALI='$_POST[dosenwali]' 
       WHERE NRP='$_POST[nrp]'";
    if (!mysql_query($update)) {
        echo "Gagal !, <br>" . mysql_error();
    }
}
?>

<style>
    .td {padding-left: 4px; }
    tr.rowlight {color:#fff; background-color: steelblue;}
</style>
<table width="100%" border='0'>
    <tr>
        <td>
            <div style="float: left; padding-left: 12px;">
                <h2 align="center">DAFTAR MAHASISWA </h2>
            </div>
        </td>
        <td>
            <div style="padding-right: 12px; float: right; padding-top: 10px;">
                <form name='cari' id='search' method="post" action="" id="search">
                    <input name="cari" type="text"
                           value="NRP atau Nama" onFocus="clearText(this)" onBlur="clearText(this)" autocomplete='off' />
                    <a href="#" onclick='submit()' class="tombol">Cari</a> 
                    <a href="?p=tambah" class="tombol">Mahasiswa Baru</a> 

                </form>
            </div>

        </td>
    </tr>
</table>

<div style="padding-top:4px; padding-bottom: 14px; text-align:justify; text-shadow:#666666;">

    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; 
           font-family:'Courier New', Courier, monospace; font-size:12px;">
        <tr bgcolor="#CCCCCC">
            <td width="4%" height="31"><div align="center"><strong>NO</strong></div></td>
            <td width="17%" colspan="2"><div align="center"><strong>NRP.</strong></div></td>
            <td width="21%"><div align="center"><strong>NAMA MAHASISWA</strong>
                    &nbsp;<a href="?p=daftar&urut=nama">AZ</a>
                </div></td>
            <td width="25%"><div align="center">
                    <b>BIDANG STUDI</b>&nbsp;<a href="?p=daftar&urut=bidang">AZ</a>
                    <br><b>JURUSAN</b>&nbsp;<a href="?p=daftar&urut=jurusan">AZ</a>
                </div>
            <td><div align="center"><strong>ALAMAT</strong></div>	
        </tr>

        <?php
        $hal = $_GET[hal];
        if (!isset($_GET['hal'])) {
            $page = 1;
        } else {
            $page = $_GET['hal'];
        }

        $jmlperhalaman = 7;  //JUMLAH RECORD PER HALAMAN 
        $offset = (($page * $jmlperhalaman) - $jmlperhalaman);
        $table = "mahasiswa";
        $pgurl = "?p=daftar";

        if (!$_POST['cari']) {
            if (!$_GET['urut']) { //tampil daftar dengan pengurutan 
                $sql_data = mysql_query("select * from $table ORDER BY NRP ASC limit $offset,$jmlperhalaman");
            } elseif ($_GET['urut'] == 'nama') {
                $sql_data = mysql_query("SELECT * FROM $table order by NAMA asc limit $offset,$jmlperhalaman");
            } elseif ($_GET['urut'] == 'bidang') {
                $sql_data = mysql_query("SELECT * FROM $table order by BIDSTUDI asc limit $offset,$jmlperhalaman");
            } elseif ($_GET['urut'] == 'jurusan') {
                $sql_data = mysql_query("SELECT * FROM $table order by JURUSAN asc limit $offset,$jmlperhalaman");
            }
        } else {
            $cari = $_POST['cari'];
            if (!preg_match('/^[0-9]*$/', $cari)) {
                $data_cari = "SELECT * FROM mahasiswa WHERE NAMA LIKE '%$cari%' order by NRP asc";
            } else {
                $data_cek = "select if (NRP > '$cari', NRP - '$cari','$cari' - NRP) as belain, 
                    NRP, NAMA, TMLAHIR, TGLAHIR, JURUSAN, BIDSTUDI, ALAMAT FROM mahasiswa
                    WHERE ((NRP - '$cari') >=0 ) or (('$cari' - NRP) >=0) order by NRP asc";
                //coba loop untuk mencari nip near 
                $sql_cek = mysql_query($data_cek);
                while ($res_cek = mysql_fetch_array($sql_cek)) {
                    $min = isset($min) ? min($min, $res_cek['belain']) : $res_cek['belain'];
                }
                if (preg_match('/^[0-9]*$/', $cari)) {
                    $nrpcari = $cari - $min;
                    $cek_nnrp_cari = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM mahasiswa WHERE NRP = '$nrpcari'"), 0);
                    if ($cek_nnrp_cari >= 1) {
                        $rest_cari_nrp = $nrpcari;
                    } else {
                        $rest_cari_nrp = $cari + $min;
                    }
                    echo "Near searcing for " . $cari . " is <b>" . $rest_cari_nrp . "</b>";
                }
                //Query baru untuk menampilkan blog 
                $data_cari = "SELECT * FROM mahasiswa order by NRP asc limit 0,10";

                //end loop 
            }
            $sql_data = mysql_query($data_cari);
        }


        while ($res_data = mysql_fetch_array($sql_data)) { //start jika ada datanya
            $no++;
            $nrpmahasiswa = $res_data['NRP']; 
            ?>	
            <tr 
            <?php
            if ($_POST['cari']) {
                if ($nrpmahasiswa==trim($rest_cari_nrp)) {
                    echo 'class="rowlight"';
                }
            }
            ?>       
                bgcolor="#FFFFFF" style=" border-bottom-width:thin; border-bottom-style:inset; border-bottom-color:#CCCCFF;" 
                valign="top" height="36">
                <td><div align="center"><?php echo $no; ?></div></td>
                <td width='4%' align='center'>
                    <a href="#" 
                       onclick="konfirmasi(<?php echo $res_data[NRP]; ?>);">Del</a></td>
                <td class='td'>
                    <a href="?p=edit&id=<?php echo $res_data[NRP]; ?>"><?= $nrpmahasiswa; ?></a>
                </td>
                <td class='td'><?php echo $res_data[NAMA]; ?><br>
                    <?php echo $res_data[TMLAHIR]; ?>, <?php echo date('d/m/Y', strtotime($res_data[TGLAHIR])); ?>
                </td>
                <td class='td'><?= tempel('jurusan', 'id_jurusan', $res_data[JURUSAN], 'nm_jurusan'); ?><br>
                    <?= tempel('bidang', 'id_bidang', $res_data[BIDSTUDI], 'nm_bidang'); ?>
                </td>
                <td class='td'><? echo $res_data[ALAMAT]; ?></td>
            </tr>
            <?php
        }

        ?>
    </table>

</div>
<span style="float:right;"><?php
    if (!$_POST['cari']) {
        include "pages_control.php";
    }
    ?>
</span>
</p>
