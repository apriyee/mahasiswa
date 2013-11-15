<?php
include 'koneksi.php';
$delete = "DELETE FROM mahasiswa WHERE NRP = '$_GET[id]'";
    if (!mysql_query($delete)) {
        echo "Gagal !, <br>" . mysql_error();
    } else {
        echo "<div id='message'>DATA TELAH TERHAPUS</div>";
    }
?>
