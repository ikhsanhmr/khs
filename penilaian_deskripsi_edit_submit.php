<?php
    session_start();
    include_once("lib/config.php");
    include_once("lib/check.php");

    $id 		 = $_POST['id'];
    $deskripsi	 = $_POST['deskripsi'];
    $bobot 	 	 = $_POST['bobot'];
    
    mysqli_query($mysqli, "START TRANSACTION");
    $sql = "UPDATE penilaian_deskripsi SET deskripsi = '$deskripsi',bobot = $bobot
			WHERE id_deskripsi = '$id'";
    //echo $sql;
    $query = mysqli_query($mysqli, $sql);
    
        if ($query==1) {
            echo '<script language="javascript">alert("Update Berhasil")</script>';
            echo '<script language="javascript">window.location = "penilaian_deskripsi.php"</script>';
            mysqli_query($mysqli, "COMMIT");
        } else {
            echo '<script language="javascript">alert("Update Gagal")</script>';
            echo '<script language="javascript">window.location = "penilaian_deskripsi.php"</script>';
            mysqli_query($mysqli, "ROLLBACK");
        }
