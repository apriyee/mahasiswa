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
include 'koneksi.php';
if ($_GET[opsi] == 'tambah') {
    $save = "INSERT INTO dosen 
        SET nip='$_POST[nip]',
            nm_dosen='$_POST[nama]',
            gol='$_POST[gol]',
            wali='$_POST[wali]'";
    if (!mysql_query($save)) {
        echo "Gagal !, <br>" . mysql_error();
    }
} elseif ($_GET[opsi] == 'hapus') {
    $varid = $_GET['id'];
    $hapus = "DELETE FROM dosen WHERE id_dosen = $varid";
    if (!mysql_query($hapus)) {
        echo "Gagal !, <br>" . mysql_error();
    }
} elseif ($_GET[opsi] == 'edit') {
    $varid = $_GET['id'];
    $list = mysql_query("SELECT * FROM dosen WHERE id_dosen = '$varid'");
    if ($row_list = mysql_fetch_assoc($list)) {
        $varnip = $row_list['nip'];
        $varnama = $row_list['nm_dosen'];
        $vargol = $row_list['gol'];
        $varwali = $row_list['wali'];
    }
} elseif ($_GET[opsi] == 'update') {
    
    $varid = $_POST['id'];
    $update = "UPDATE dosen 
        SET nip='$_POST[nip]',
            nm_dosen='$_POST[nama]',
            gol='$_POST[gol]',
            wali='$_POST[wali]' WHERE id_dosen = $varid";
    if (!mysql_query($update)) {
        echo "Gagal !, <br>" . mysql_error();
    }
}

if ($_GET[opsi] == 'edit') {
    $var_taget = '?p=dosen&opsi=update';
    $var_tombol = "Update data";
} else {
    $var_taget = '?p=dosen&opsi=tambah';
    $var_tombol = "Tambah data";
}
?>
<style>
    .td {padding-left: 4px; }
</style>
<table width="100%" border='0'>
    <tr>
        <td><div style="float: left; padding-left: 12px;">
                <h2 align="center">DAFTAR DOSEN </h2>
            </div>
        </td>

    </tr>
    <tr>
        <td>
            <div style="padding-right: 12px; float: right; padding-top: 10px;">
                
                <form name='form1' id='cilik' method="POST" action="<?php echo $var_taget; ?>" >
                    <input name="id" type="hidden" value="<?php echo $varid; ?>">
                    <table>
                        <tr align='center' style='font-style: oblique;'>
                            <td>NIP</td>
                            <td>NAMA</td>
                            <td>GOL</td>
                            <td>APAKAH DOSEN WALI ?</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><input name="nip" type="text" size="18" maxlength="18" 
                                       value="<?= $varnip; ?>" autocomplete='off' /></td>
                            <td><input name="nama" type="text" size="40" 
                                       value="<?= $varnama; ?>" autocomplete='off' /></td>
                            <td><select name='gol'>
                                    <option value="" <?php if (!(strcmp("", $vargol))) {
                                                echo "SELECTED";
                                            } ?>  >  -- Golongan --  </option>
                                    <?php
                                    include 'koneksi.php';
                                    $data_gol = mysql_query("select * from golongan");
                                    while ($data = mysql_fetch_assoc($data_gol)) {
                                        ?>
                                        <option value="<?php echo $data['kd_gol']; ?>" 
                                        <?php
                                        if ($data['nm_gol'] == $select) {
                                            echo "selected";
                                        }
                                        ?>  
                                        <?php
                                        if (!(strcmp($data['kd_gol'], $vargol))) {
                                            echo "SELECTED";
                                        }
                                        ?>><?php echo $data['nm_gol']; ?> </option>
<?php } ?>
                                </select>

                            </td>
                            <td><input type='checkbox' value='1' name='wali' 
<?php if ($varwali == '1') {
    echo "checked='yes'";
} ?> /> Ya</td>
                            <td><a href="#" onclick='submit()' class="tombol"><?php echo $var_tombol; ?></a></td>
                        </tr>
                    </table>
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
        <tr bgcolor="#CCCCCC" align='center'>
            <td width="4%" height="31"><b>NO</b></td>
            <td><b>NAMA DOSEN</b></td>	
            <td><b>NIP</b></td>	
            <td><b>GOLONGAN</b></td>	
            <td><b>STATUS</b></td>
            <td><b>OPSI</b></td>
        </tr>

        <?php
        $hal = $_GET[hal];
        if (!isset($_GET['hal'])) {
            $page = 1;
        } else {
            $page = $_GET['hal'];
        }

        $jmlperhalaman = 6;  //JUMLAH RECORD PER HALAMAN 
        $offset = (($page * $jmlperhalaman) - $jmlperhalaman);
        $table = "dosen";
        $pgurl = "?p=dosen";

        $sql_data = mysql_query("select * from $table ORDER BY nm_dosen ASC limit $offset,$jmlperhalaman");
        while ($res_data = mysql_fetch_array($sql_data)) { //start jika ada datanya
            $no++;
            ?>	
            <tr bgcolor="#FFFFFF" style=" border-bottom-width:thin; border-bottom-style:inset; border-bottom-color:#CCCCFF;" 
                valign="top" height="36">
                <td  width='4%'><div align="center"><?php echo $no; ?></div></td>
                <td align='left' style='padding-left: 10px;'>
                    <a href="?p=dosen&opsi=edit&id=<?php echo $res_data[id_dosen]; ?>"><? echo $res_data[nm_dosen]; ?></a>
                </td>
                <td><?= $res_data[nip]; ?></td>
                <td><?= tempel('golongan', 'kd_gol', $res_data[gol], 'nm_gol'); ?></td>
                <td><?php if ($res_data[wali] == '0') {
                echo "---";
            } else {
                echo "Dosen Wali";
            } ?></td>
                <td><span style="float: right; padding-right: 6px;">
                        <a href="?p=dosen&opsi=hapus&id=<?php echo $res_data[id_dosen]; ?>" class='tombol'
                           onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Del</a>
                    </span>
                </td>
            </tr>
<?php } ?>
    </table>


</div>
<span style="float:right;"><?php include "pages_control.php"; ?></span>
</p>
