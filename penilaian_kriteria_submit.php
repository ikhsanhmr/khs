<?php
    session_start();
    include_once("lib/config.php");
    include_once('lib/head.php');
    include_once("lib/check.php");
    $deskripsi = $_POST['deskripsi'];
    $kriteria = $_POST['kriteria'];
    $bobot = $_POST['bobot'];

    $tambah = mysqli_query($mysqli, "insert into penilaian_kriteria (id_deskripsi,kriteria,bobot)values
				('$deskripsi','$kriteria','$bobot')");
    $resultQuery=mysqli_query($mysqli, $tambah);
            if ($tambah==1) {
                echo '<script language="javascript">alert("Input Berhasil")</script>';
                echo '<script language="javascript">window.location = "penilaian_kriteria.php"</script>';
                mysqli_query($mysqli, "COMMIT");
            } else {
                echo '<script language="javascript">alert("Input Gagal")</script>';
                echo '<script language="javascript">window.location = "penilaian_kriteria.php"</script>';
                mysqli_query($mysqli, "ROLLBACK");
            }
