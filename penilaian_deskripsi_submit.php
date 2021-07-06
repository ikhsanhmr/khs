<?php
    session_start();
    include_once("lib/config.php");
    include_once('lib/head.php');
    include_once("lib/check.php");
    $deskripsi = $_POST['deskripsi'];
    $bobot = $_POST['bobot'];

    $tambah = mysqli_query($mysqli, "insert into penilaian_deskripsi (deskripsi, bobot)values
				('$deskripsi','$bobot')");
    $resultQuery=mysqli_query($mysqli, $tambah);
            if ($tambah==1) {
                echo '<script language="javascript">alert("Input Berhasil")</script>';
                echo '<script language="javascript">window.location = "penilaian_deskripsi.php"</script>';
                mysqli_query($mysqli, "COMMIT");
            } else {
                echo '<script language="javascript">alert("Input Gagal")</script>';
                echo '<script language="javascript">window.location = "penilaian_deskripsi.php"</script>';
                mysqli_query($mysqli, "ROLLBACK");
            }
