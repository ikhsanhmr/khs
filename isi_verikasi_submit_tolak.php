<?php
		session_start();
		include_once("lib/config.php");
		include_once('lib/head.php');
		include_once("lib/check.php");
		
		$no_spj = $_POST["no_spj"];
		$verifikasi = $_POST["verifikasi"];
		$alasan = $_POST["alasan_evaluasi"];
		
		$simp1= mysqli_query("UPDATE tb_termin set verifikasi_mb='$verifikasi', catatan_verifikasi_mb='$alasan' where spj_no='$no_spj'");	
		
	if($simp1==1){
				echo '<script language="javascript">alert("Verifikasi Berhasil Disimpan")</script>';
				echo '<script language="javascript">window.location = "verifikasi_evaluasi_mb.php"</script>';
				mysqli_query("COMMIT");
			}else{
				echo '<script language="javascript">alert("Verifikasi Gagal Disimpan")</script>';
				echo '<script language="javascript">window.location = "verifikasi_evaluasi_mb.php"</script>';
				mysqli_query("ROLLBACK");
			}
?>