<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");
	$id = $_GET['id'];
	$delQuery = mysqli_query("DELETE FROM penilaian_kriteria WHERE id_kriteria = '$id'");
	if ($delQuery==1) {
			echo '<script language="javascript">alert("Hapus Berhasil")</script>';
			echo '<script language="javascript">window.location = "penilaian_kriteria.php"</script>';
			mysqli_query("COMMIT");
	}else{
			echo '<script language="javascript">alert("Hapus Gagal")</script>';
			echo '<script language="javascript">window.location = "penilaian_kriteria.php"</script>';
			mysqli_query("ROLLBACK");
		}
?>
