<?php
include 'koneksi.php';

$thn1 = intval(date("Y")) - 2;
$thn2 = intval(date("Y")) + 2;

if ($_GET[opsi] == 'cetak') {
    $vartahun = $_POST['tahun'];
    $vsemes = $_POST['semester'];

    $src_link = "cetak_daftar_frs.php?tahun=" . $vartahun . "&semester=" . $vsemes;
} else {
    $src_link = "blank_report.php";
}
?> 
<style>
    .td {padding-left: 4px; }
</style>



<table width="98%" border='0'>
    <tr>
        <td><div style="float: left; padding-left: 12px;">
                <h3 align="center"> </h3>
            </div>
        </td>

    </tr>
    <tr>
        <td>
            <div style="padding-left:  12px; float: left;">
                <form name='form1' id='cilik' method='POST' action='?p=daftar_frs&opsi=cetak' >
                    <table>

                        <tr>
                            <td>Pilih opsi cetak </td>
                            <td>
                                <select name='tahun'>
                                    <option value="" <?php
                                    if (!(strcmp("", $vartahun))) {
                                        echo "SELECTED";
                                    }
                                    ?>  >  -- Tahun --  </option>
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
                                <select name="semester">
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
                                <a href="javascript:void(0);" onclick='submit();' class="tombol">Preview</a>
                                <a href="javascript:void(0);" onclick='cetak.print();' class="tombol">Cetak</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

        </td>
    </tr>
</table>

<iframe height="85%" width="100%" scrolling="auto" frameborder="0" name="cetak" src="<?= $src_link; ?>"></iframe>

</p>
