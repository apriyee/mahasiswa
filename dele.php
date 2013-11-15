<script language="javascript" type="text/javascript">
    function pesan()
    {
        alert('Maaf data mahasiswa tidak bisa di hapus, \n\
karena masih ada data pelajaran untuk mahasiswa ini di tabel frs.');
    }

    function sukses() {
        alert('Sukses !, data telah berhasil di hapus ');
    }
</script>

<?php 
include "koneksi.php";

$delnrp = $_GET['id'];
//echo $delnrp;
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
?>