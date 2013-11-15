
<script language="javascript">
    function getText()
    {
        var in1 = document.getElementById('nrp').value;
        var nama = $('#nama').val();
        $.ajax({
            type: "POST",
            url: "cek_nrp.php?nrp=" + in1,
            data: {nama: nama}
        }).done(function(data) {
            if (!data) {
                return;
            } else {
                alert("NRP : " + in1 + " SUDAH ADA a.n. " + data);
                //document.getElementById("form1").reset();
                document.form1.reset();
                document.form1.nrp.focus();
            }

        });
    }
</script>


<script>
    function get_id_val(val) {
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

<h2>TAMBAH DATA MAHASISWA</h2>
<table>
    <tr valign="top">
        <td widht="60%">
            <div class="cssform">
                <form name="form1" id="form1" method="post" action="?p=daftar">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" colspan="2">
                        <tr>
                            <td>NRP.</td>
                            <td>
                                <input name="nrp" type="text" id="nrp" size="19" maxlength="18" onchange="getText()" 
                                       onKeyPress="return handleEnter(this, event)">
                            </td>
                        </tr>
                        <tr>
                            <td>NAMA MAHASISWA</td>
                            <td>
                                <input name="nama" type="text" id="nama" size="50" onKeyPress="return handleEnter(this, event)">
                            </td>
                        </tr>
                        <tr>
                            <td>TEMPAT LAHIR</td>
                            <td>
                                <input name="tmlahir" type="text" id="tmlahir" size="40" onKeyPress="return handleEnter(this, event)">
                            </td>
                        </tr>
                        <tr>
                            <td>TGL. LAHIR</td>
                            <td>
                                <input class="easyui-datebox" name="tglahir" type="text" id="tglahir" size="10"
                                       onKeyPress="return handleEnter(this, event)">
                            </td>
                        </tr>
                        <tr>
                            <td>JURUSAN</td>
                            <td>
                                <select name="jurusan" class="sele" onchange="javascript:get_id_val(this)" onKeyPress="return handleEnter(this, event)">
                                    <option value="" <?php
                                    if (!(strcmp("", $pej))) {
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
                                        if (!(strcmp($row_list['nm_jurusan'], $nmjurusan))) {
                                            echo "SELECTED";
                                        }
                                        ?>><?php echo $row_list['nm_jurusan']; ?> </option>
                                            <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>PROGRAM STUDI</td>
                            <td><div  id="result">
                                    <select name="bidang">
                                        <option value="0" disabled="disabled">-- Please Select --</option>
                                    </select>
                                </div> 

                            </td>
                        </tr>
                        <tr>
                            <td>ALAMAT</td>
                            <td>
                                <input name="alamat" type="text" id="alamat" size="60" onKeyPress="return handleEnter(this, event)">
                            </td>
                        </tr>
                        <tr>
                            <td>DOSEN WALI </td>
                            <td>
                                <select name='dosenwali'>
                                    <option value="" <?php
                                    if (!(strcmp("", $vardosen))) {
                                        echo "SELECTED";
                                    }
                                    ?>  >  -- Pilih Dosen Wali --  </option>
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
                                        if (!(strcmp($data['id_dosen'], $vardosen))) {
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
                                <input name="Submit" type="submit" value="Simpan Data">
                            </td>
                        </tr>
                    </table>
                </form>

            </div>
        </td>
        <td>
            <div style="padding-left: 10px; padding-right: 10px;">
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
                    $pgurl = "?p=tambah";

                    $sql_data = mysql_query("select * from $table ORDER BY NRP ASC limit $offset,$jmlperhalaman");
                    while ($res_data = mysql_fetch_array($sql_data)) {
                        ?>	
                        <tr bgcolor="#FFFFFF" 
                            style=" border-bottom-width:thin; border-bottom-style:inset; border-bottom-color:#CCCCFF; padding-left: 4px; padding-right: 4px;" 
                            valign="top" height="36">

                            <td class='td'><div style=" padding-left: 3px; padding-right: 2px;">
                                    <a href="?p=edit&id=<?php echo $res_data[NRP]; ?>"><? echo $res_data[NRP]; ?></a></div>
                            </td>
                            <td class='td'>
                                <div style=" padding-left: 3px; padding-right: 2px;">
                                    <?php echo $res_data[NAMA]; ?><br>
                                    <?php echo $res_data[TMLAHIR]; ?>, <?php echo date('d/m/Y', strtotime($res_data[TGLAHIR])); ?>
                                </div>
                            </td>

                        </tr>
                    <?php } ?>
                </table>

                <?php include "pages_control.php"; ?>
            </div>
        </td>

    </tr>
</table>
</p>
