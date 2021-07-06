<?php
    session_start();
    include_once("lib/config.php");
    include_once('lib/head.php');
    include_once("lib/check.php");
    $deskripsi = $_POST['deskripsi'];
    $kriteria = $_POST['kriteria'];
    $bobot = $_POST['bobot'];
    $id = $_POST['id'];
    
    mysqli_query($mysqli, "START TRANSACTION");
    
    $sql = "UPDATE penilaian_kriteria SET id_deskripsi = '$deskripsi',kriteria='$kriteria',bobot = '$bobot'
			WHERE id_kriteria = '$id'";
            
    $resultQuery=mysqli_query($mysqli, $sql);
            if ($resultQuery==1) {
                echo '<script language="javascript">alert("Update Berhasil")</script>';
                echo '<script language="javascript">window.location = "penilaian_kriteria.php"</script>';
                mysqli_query($mysqli, "COMMIT");
            } else {
                echo '<script language="javascript">alert("Update Gagal")</script>';
                echo '<script language="javascript">window.location = "penilaian_kriteria.php"</script>';
                mysqli_query($mysqli, "ROLLBACK");
            }
