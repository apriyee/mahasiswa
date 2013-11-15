<script src="js/jquery-1.9.1.js"></script>
<script>
    function get_id_prod(val) {
        var option = val.options[val.selectedIndex];
        $.ajax({
            type: "POST",
            url: "sql_bidang.php",
            data: "value=" + option.value,
            success: function(message) {
                $("#result").html(message);
            }
        });

    }
</script>

<?php
include 'koneksi.php';

$list = mysql_query("SELECT * FROM mahasiswa  WHERE NRP = '$_GET[id]'");
if ($row_list = mysql_fetch_assoc($list)) {
    $vnrp = $row_list['NRP'];
    $vnama = $row_list['NAMA'];
    $vtmlahir = $row_list['TMLAHIR'];
    $vtglahir =date('m/d/Y', strtotime($row_list[TGLAHIR]));
    $vjur = $row_list['JURUSAN'];
    $vbid = $row_list['BIDSTUDI'];
    $vala = $row_list['ALAMAT'];
    $vwali = $row_list['WALI'];
}
?>

<h2>EDIT DATA MAHASISWA</h2>

<table>
    <tr valign="top">
        <td widht="60%">
<div class="cssform">
    <form name="form1" method="POST" action="?p=daftar">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" colspan="2">
            <tr>
                <td>NRP.</td>
                <td>
                    <input name="nrp" type="text" id="nrp" size="19" maxlength="18" value='<?php echo $vnrp; ?>' readonly="false">
                </td>
            </tr>
            <tr>
                <td>NAMA MAHASISWA</td>
                <td>
                    <input name="nama" type="text" id="nama" size="50" value='<?php echo $vnama; ?>'>
                </td>
            </tr>
            <tr>
                <td>TEMPAT LAHIR</td>
                <td>
                    <input name="tmlahir" type="text" id="tmlahir" size="40"  value="<?php echo $vtmlahir; ?>" >
                </td>
            </tr>
            <tr>
                <td>TGL. LAHIR</td>
                <td>
                    <input  class="easyui-datebox" name="tglahir" type="text" id="tglahir" size="10" value="<?php echo $vtglahir; ?>">
                </td>
            </tr>
             <tr>
                <td>JURUSAN</td>
                <td>
                    <select name="jurusan" class="sele" onchange="javascript:get_id_prod(this)">
                        <option value="" <?php
                        if (!(strcmp("", $vjur))) {
                            echo "SELECTED";
                        }
                        ?>  > 
                            -- Pilih Jurusan -- 
                        </option>
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
                            if (!(strcmp($row_list['id_jurusan'], $vjur))) {
                                echo "SELECTED";
                            }
                            ?>><?php echo $row_list['nm_jurusan']; ?> </option>
<?php } ?>
                    </select>
                    
                </td>
            </tr>
            <tr>
                <td>PROGRAM STUDY </td>
                <td>
                    <div  id="result">
                    <select name="bidstudi">
                        <option value="" <?php
                        if (!(strcmp("", $vbid))) {
                            echo "SELECTED";
                        }
                        ?>  > 
                            -- Pilih Jurusan -- 
                        </option>
                        <?php
                        include 'koneksi.php';
                        $list = mysql_query("select * from bidang where kd_jurusan='$vjur' order by nm_bidang asc");
                        while ($row_list = mysql_fetch_assoc($list)) {
                            ?>
                            <option value="<?php echo $row_list['id_bidang']; ?>" 
                            <?php
                            if ($row_list['nm_bidang'] == $select) {
                                echo "selected";
                            }
                            ?>  
                            <?php
                            if (!(strcmp($row_list['id_bidang'], $vbid))) {
                                echo "SELECTED";
                            }
                            ?>><?php echo $row_list['nm_bidang']; ?> </option>
                            <?php } ?>
                        
                    </select>
                    </div> 
                </td>
            </tr>
           
            <tr>
                <td>ALAMAT</td>
                <td>
                    <input name="alamat" type="text" id="alamat" size="80" value='<?php echo $vala; ?>'>
                </td>
            </tr>
            <tr>
                <td>DOSEN WALI </td>
                <td>
                    <select name='dosenwali'>
                                    <option value="" <?php if (!(strcmp("", $vwali))) {
                                                echo "SELECTED";
                                            } ?>  >  -- Pilih Dosen Wali--  </option>
                                    <?php
                                    $data_dsn = mysql_query("select * from dosen  WHERE wali=1");
                                    while ($data = mysql_fetch_assoc($data_dsn)) {
                                        ?>
                                        <option value="<?php echo $data['id_dosen']; ?>" 
                                        <?php
                                        if ($data['nm_dosen'] == $select) {
                                            echo "selected";
                                        }
                                        ?>  
                                        <?php
                                        if (!(strcmp($data['id_dosen'], $vwali))) {
                                            echo "SELECTED";
                                        }
                                        ?>><?php echo $data['nm_dosen']; ?> </option>
<?php } ?>
                                </select>
                    
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input name="Submit" type="submit" value="Update Data">
                </td>
            </tr>
        </table>
    </form>

</div>
            </td>
        <td>
            <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; 
           font-family:'Courier New', Courier, monospace; font-size:12px;">

                <?php
                $hal = $_GET[hal];
                if (!isset($_GET['hal'])) {
                    $page = 1;
                } else {
                    $page = $_GET['hal'];
                }

                $jmlperhalaman = 10;  //JUMLAH RECORD PER HALAMAN 
                $offset = (($page * $jmlperhalaman) - $jmlperhalaman);
                $table = "mahasiswa";
                $pgurl = "?p=edit";

                $sql_data = mysql_query("select * from $table ORDER BY NRP ASC limit $offset,$jmlperhalaman");
                while ($res_data = mysql_fetch_array($sql_data)) {
                    ?>	
                    <tr bgcolor="#FFFFFF" style=" border-bottom-width:thin; border-bottom-style:inset; border-bottom-color:#CCCCFF;" 
                        valign="top" height="36">

                        <td class='td'>
                            <a href="?p=edit&id=<?php echo $res_data[NRP]; ?>"><? echo $res_data[NRP]; ?></a>
                        </td>
                        <td class='td'><?php echo $res_data[NAMA]; ?><br>
                    <?php echo $res_data[TMLAHIR]; ?>, <?php echo date('d/m/Y', strtotime($res_data[TGLAHIR])); ?>
                        </td>

                    </tr>
<?php } ?>
            </table>
<?php include "pages_control.php"; ?>
        </td>

    </tr>
</table>
</p>
