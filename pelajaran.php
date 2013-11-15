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
    $save = "INSERT INTO pelajaran 
        SET kd_pel='$_POST[kode]',
            nm_pel='$_POST[nm_pelajaran]',
            sks='$_POST[sks]',
            kd_dosen='$_POST[dosen]'";
    if (!mysql_query($save)) {
        echo "Gagal !, <br>" . mysql_error();
    }
} elseif ($_GET[opsi] == 'hapus') {
    $varid = $_GET['id'];
    $hapus = "DELETE FROM pelajaran WHERE id_pel = $varid";
    if (!mysql_query($hapus)) {
        echo "Gagal !, <br>" . mysql_error();
    }
} elseif ($_GET[opsi] == 'edit') {
    $varid = $_GET['id'];
    $list = mysql_query("SELECT * FROM pelajaran WHERE id_pel = '$varid'");
    if ($row_list = mysql_fetch_assoc($list)) {
        $varkode = $row_list['kd_pel'];
        $varnmpel = $row_list['nm_pel'];
        $varsks = $row_list['sks'];
        $vardosen = $row_list['kd_dosen'];
    }
} elseif ($_GET[opsi] == 'update') {
    $varid = $_POST['id'];
    $update = "UPDATE pelajaran 
        SET kd_pel='$_POST[kode]',
            nm_pel='$_POST[nm_pelajaran]',
            sks='$_POST[sks]',
            kd_dosen='$_POST[dosen]' WHERE id_pel = $varid";
    if (!mysql_query($update)) {
        echo "Gagal !, <br>" . mysql_error();
    }
}

if ($_GET[opsi] == 'edit') {
    $var_taget = '?p=pelajaran&opsi=update';
    $var_tombol = "Update data";
} else {
    $var_taget = '?p=pelajaran&opsi=tambah';
    $var_tombol = "Tambah data";
}
?>
<style>
    .td {padding-left: 4px; }
</style>
<table width="100%" border='0'>
    <tr>
        <td><div style="float: left; padding-left: 12px;">
                <h2 align="center">DAFTAR MATA KULIAH </h2>
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
                            <td>KODE</td>
                            <td>NAMA PELAJARAN</td>
                            <td>SKS</td>
                            <td>DOSEN</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><input name="kode" type="text" size="12" maxlength="10" 
                                       value="<?= $varkode; ?>" autocomplete='off' /></td>
                            <td><input name="nm_pelajaran" type="text" size="40" 
                                       value="<?= $varnmpel; ?>" autocomplete='off' /></td>
                            <td><input name="sks" type="text" size="3" maxlength="1" 
                                       value="<?= $varsks; ?>" autocomplete='off' /></td>
                            <td><select name='dosen'>
                                    <option value="" <?php if (!(strcmp("", $vardosen))) {
                                                echo "SELECTED";
                                            } ?>  >  -- Pilih Dosen --  </option>
                                    <?php
                                    $data_dosen = mysql_query("SELECT * FROM dosen");
                                    while ($data = mysql_fetch_assoc($data_dosen)) {
                                        ?>
                                        <option value="<?php echo $data['id_dosen']; ?>" 
                                        <?php
                                        if ($data['nm_dosen'] == $select) {
                                            echo "selected";
                                        }
                                        ?>  
                                        <?php
                                        if (!(strcmp($data['id_dosen'], $vardosen))) {
                                            echo "SELECTED";
                                        }
                                        ?>><?php echo $data['nm_dosen']; ?> </option>
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

<?php
include "koneksi.php";
?>


<div style="padding-top:4px; text-align:justify; text-shadow:#666666;">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; 
           font-family:'Courier New', Courier, monospace; font-size:12px;">
        <tr bgcolor="#CCCCCC" align='center'>
            <td width="4%" height="31"><b>NO</b></td>
            <td><b>KODE</b></td>	
            <td><b>NAMA PELAJARAN</b></td>	
            <td><b>SKS</b></td>	
            <td><b>DOSEN</b></td>
            <td><b>OPSI</b></td>
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
        $table = "pelajaran";
        $pgurl = "?p=pelajaran";

        $sql_data = mysql_query("select * from $table ORDER BY kd_pel ASC limit $offset,$jmlperhalaman");
        while ($res_data = mysql_fetch_array($sql_data)) { //start jika ada datanya
            $no++;
            ?>	
            <tr bgcolor="#FFFFFF" style=" border-bottom-width:thin; border-bottom-style:inset; border-bottom-color:#CCCCFF;" 
                valign="top" height="36">
                <td  width='4%'><div align="center"><?php echo $no; ?></div></td>
                <td align='left' style='padding-left: 10px;'>
                    <a href="?p=pelajaran&opsi=edit&id=<?php echo $res_data[id_pel]; ?>"><? echo $res_data[kd_pel]; ?></a>
                </td>
                <td>&nbsp;<?= $res_data[nm_pel]; ?></td>
                <td align='center'><?= $res_data[sks]; ?></td>
                <td>&nbsp;<?= tempel('dosen', 'id_dosen', $res_data[kd_dosen], 'nm_dosen'); ?></td>
                
                <td><span style="float: right; padding-right: 6px;">
                        <a href="?p=pelajaran&opsi=hapus&id=<?php echo $res_data[id_pel]; ?>" class='tombol'
                           onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Del</a>
                    </span>
                </td>
            </tr>
<?php } ?>
    </table>


</div>
<span style="float:right;"><?php include "pages_control.php"; ?></span>
</p>
