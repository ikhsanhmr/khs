<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");
    $id = $_GET['id'];
    $delQuery = mysqli_query($mysqli, "DELETE FROM penilaian_deskripsi WHERE id_deskripsi = '$id'");
    if ($delQuery==1) {
        echo '<script language="javascript">alert("Hapus Berhasil")</script>';
        echo '<script language="javascript">window.location = "penilaian_deskripsi.php"</script>';
        mysqli_query($mysqli, "COMMIT");
    } else {
        echo '<script language="javascript">alert("Hapus Gagal")</script>';
        echo '<script language="javascript">window.location = "penilaian_deskripsi.php"</script>';
        mysqli_query($mysqli, "ROLLBACK");
    }
