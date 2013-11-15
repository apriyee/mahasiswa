
<script language="javascript" type="text/javascript">
    function clearText(field)
    {
        if (field.defaultValue == field.value)
            field.value = '';
        else if (field.value == '')
            field.value = field.defaultValue;
    }
</script>
<?
if ($_GET[opsi] == 'tambah') {
    include 'koneksi.php';
    $save = "INSERT INTO bidang
        SET kd_jurusan = '$_POST[kdjur]',
            nm_bidang='$_POST[nmbidang]'";
    if (!mysql_query($save)) {
        echo "Gagal !, <br>" . mysql_error();
    } else {
        echo "<div id='message'>Penyimpanan Sukses</div>";
    }
} elseif ($_GET[opsi] == 'edit') {
    include "koneksi.php";
    $varid = $_GET['id'];
    $list = mysql_query("SELECT * FROM bidang WHERE id_bidang = '$varid'");
    if ($row_list = mysql_fetch_assoc($list)) {
        $var_kdjur = $row_list['kd_jurusan'];
        $varnm_bidang = $row_list['nm_bidang'];
    }
} elseif ($_GET[opsi] == 'update') {
    include "koneksi.php";
    $varid = $_POST['id'];
    $update = "UPDATE bidang 
        SET kd_jurusan = '$_POST[kdjur]',
            nm_bidang='$_POST[nmbidang]' 
                WHERE id_bidang = $varid";
    if (!mysql_query($update)) {
        echo "Gagal !, <br>" . mysql_error();
    }
} elseif ($_GET[opsi] == 'hapus') {
    include "koneksi.php";
    $varid = $_GET['id'];
    $hapus = "DELETE FROM bidang WHERE id_bidang = $varid";
    if (!mysql_query($hapus)) {
        echo "Gagal !, <br>" . mysql_error();
    }
}


if ($_GET[opsi] == 'edit') {
    $var_taget = '?p=bidangstudi&opsi=update';
    $var_tombol = "Update data bidang";
} else {
    $var_taget = '?p=bidangstudi&opsi=tambah';
    $var_tombol = "Tambah data baru";
}
?>
<style>
    .td {padding-left: 4px; }
</style>
<table width="100%" border='0'>
    <tr>
        <td><div style="float: left; padding-left: 12px;">
                <h2 align="center">DAFTAR BIDANG STUDY </h2>
            </div>
        </td>
        <td>
            <div style="padding-right: 12px; float: right; padding-top: 10px;">
                <form name='form1' id='cilik' method="post" action="<?php echo $var_taget; ?>" >
                    <input name="id" type="hidden" value="<?php echo $varid; ?>"> 
                    <select name="kdjur" class="sele">
                        <option value="" 
<?php
if (!(strcmp("", $pej))) {
    echo "SELECTED";
}
?>> -- Pilih Jurusan -- </option>
                        <?php
                        include 'koneksi.php';

                        $list = mysql_query("select * from jurusan order by nm_jurusan asc");
                        while ($row_list = mysql_fetch_assoc($list)) {
                            ?>
                            <option value="<?php echo $row_list['id_jurusan']; ?>" 
                                    <?php
                                    if ($row_list['nm_jurusan'] == $select) {
                                        echo "selected";
                                    }
                                    ?>  
                            <?php
                            if (!(strcmp($row_list['id_jurusan'], $var_kdjur))) {
                                echo "SELECTED";
                            }
                            ?>><?php echo $row_list['nm_jurusan']; ?> </option>
                        <?php } ?>
                    </select>

                    <input name="nmbidang" type="text"
                           value="<?php echo $varnm_bidang; ?>"  autocomplete='off' />
                    <a href="#" onclick='submit()' class="tombol"><?php echo $var_tombol; ?></a> 
                </form>

            </div>

        </td>
    </tr>
</table>

<?php
include "koneksi.php";
?>


<div style="padding-top:4px; text-align:justify; text-shadow:#666666;">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; 
           font-family:'Courier New', Courier, monospace; font-size:12px;">
        <tr bgcolor="#CCCCCC">
            <td width="4%" height="31"><div align="center"><strong>NO</strong></div></td>
            <td width="10%"><div align="center"><strong>JURUSAN</strong></div></td>	
            <td><div align="center"><strong>NAMA BIDANG</strong></div></td>	
        </tr>

<?php
$hal = $_GET[hal];
if (!isset($_GET['hal'])) {
    $page = 1;
} else {
    $page = $_GET['hal'];
}

$jmlperhalaman = 10;  //JUMLAH RECORD PER HALAMAN 
$offset = (($page * $jmlperhalaman) - $jmlperhalaman);
$table = "bidang";
$pgurl = "?p=bidangstudi";

$sql_data = mysql_query("select * from $table ORDER BY kd_jurusan ASC, nm_bidang ASC limit $offset,$jmlperhalaman");
while ($res_data = mysql_fetch_array($sql_data)) { //start jika ada datanya
    $no++;
    ?>	
            <tr bgcolor="#FFFFFF" style="border-bottom-width:thin; border-bottom-style:inset; border-bottom-color:#CCCCFF;" 
                valign="top" height="36">
                <td  width='2%'><div align="center"><?php echo $no; ?></div></td>
                <td  width='35%'><div align="left">&nbsp;<?php echo tempel('jurusan', 'id_jurusan', $res_data[kd_jurusan],'nm_jurusan'); ?></div></td>
                <td align='left' style="padding-right: 4px; padding-left: 4px;">
                    <a href="?p=bidangstudi&opsi=edit&id=<?php echo $res_data[id_bidang]; ?>"><? echo $res_data[nm_bidang]; ?></a>
                    <span style="float: right; padding-right: 6px;">
                        <a href="?p=bidangstudi&opsi=hapus&id=<?php echo $res_data[id_bidang]; ?>" 
                           onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Del</a>
                    </span>

                </td>
            </tr>
<?php } ?>
    </table>


</div>
<span style="float:right;"><?php include "pages_control.php"; ?></span>
</p>
