<script language="javascript" type="text/javascript">
    function clearText(field)
    {
        if (field.defaultValue == field.value)
            field.value = '';
        else if (field.value == '')
            field.value = field.defaultValue;
    }


</script>
<?php
if ($_GET[opsi] == 'tambah') {
    include 'koneksi.php';
    $save = "INSERT INTO jurusan SET nm_jurusan='$_POST[nmjurusan]'";
    if (!mysql_query($save)) {
        echo "Gagal !, <br>" . mysql_error();
    }
} elseif ($_GET[opsi] == 'hapus') {
    include "koneksi.php";
    $varid = $_GET['id'];
    $hapus = "DELETE FROM jurusan WHERE id_jurusan = $varid";
    if (!mysql_query($hapus)) {
        echo "Gagal !, <br>" . mysql_error();
    }
} elseif ($_GET[opsi] == 'edit') {
    include "koneksi.php";
    $varid = $_GET['id'];
    $list = mysql_query("SELECT * FROM jurusan WHERE id_jurusan = '$varid'");
    if ($row_list = mysql_fetch_assoc($list)) {
        $varnm_jur = $row_list['nm_jurusan'];
    }
} elseif ($_GET[opsi] == 'update') {
    include "koneksi.php";
    $varid = $_POST['id'];
    $update = "UPDATE jurusan 
        SET nm_jurusan='$_POST[nmjurusan]' WHERE id_jurusan = $varid";
    if (!mysql_query($update)) {
        echo "Gagal !, <br>" . mysql_error();
    }
}

if ($_GET[opsi] == 'edit') {
    $var_taget = '?p=jurusan&opsi=update';
    $var_tombol = "Update data jurusan";
} else {
    $var_taget = '?p=jurusan&opsi=tambah';
    $var_tombol = "Tambah data baru";
}
?>
<style>
    .td {padding-left: 4px; }
</style>
<table width="100%" border='0'>
    <tr>
        <td><div style="float: left; padding-left: 12px;">
                <h2 align="center">DAFTAR JURUSAN </h2>
            </div>
        </td>
        <td>
            <div style="padding-right: 12px; float: right; padding-top: 10px;">
                <form name='form1' id='cilik' method="post" action="<?php echo $var_taget; ?>" >
                    <input name="id" type="hidden" value="<?php echo $varid; ?>"> 
                    <input name="nmjurusan" type="text"
                           value="<?php echo $varnm_jur; ?>" autocomplete='off' />
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
            <td><div align="center"><strong>NAMA JURUSAN</strong></div></td>	
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
        $table = "jurusan";
        $pgurl = "?p=jurusan";

        $sql_data = mysql_query("select * from $table ORDER BY nm_jurusan ASC limit $offset,$jmlperhalaman");
        while ($res_data = mysql_fetch_array($sql_data)) { //start jika ada datanya
            $no++;
            ?>	
            <tr bgcolor="#FFFFFF" style=" border-bottom-width:thin; border-bottom-style:inset; border-bottom-color:#CCCCFF;" 
                valign="top" height="36">
                <td  width='4%'><div align="center"><?php echo $no; ?></div></td>
                <td align='left' style='padding-left: 10px;'>
                    <a href="?p=jurusan&opsi=edit&id=<?php echo $res_data[id_jurusan]; ?>"><? echo $res_data[nm_jurusan]; ?></a>
                    <span style="float: right; padding-right: 6px;">
                        <a href="?p=jurusan&opsi=hapus&id=<?php echo $res_data[id_jurusan]; ?>" class='tombol'
                           onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Del</a>
                    </span>

                </td>
            </tr>
        <?php } ?>
    </table>


</div>
<span style="float:right;"><?php include "pages_control.php"; ?></span>
</p>
