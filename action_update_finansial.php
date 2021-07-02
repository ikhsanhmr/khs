<?php

include_once("lib/config.php");
ini_set('session.gc_maxlifetime', 30*60);
session_start();
$username 	= $_SESSION['username'];
$today 		= date('Y-m-d');

if (isset($_GET["verifikasi"])):
	if (isset($_GET["act"])) :
		$act = $_GET["act"];
		if($act=="setuju" || $act =="tolak") :
		$id_vendor = $_GET['id'];
		$rating_sesudah = $_GET["rating_sesudah"];
		$fin_sesudah = $_GET["fin_sesudah"];
		
				if ($act == "setuju") :
					$perintah = "UPDATE `tb_fin_vendor` SET `RATING_LAPORAN_AUDIT`='$rating_sesudah',
								`FIN_LIMIT`='$fin_sesudah' WHERE VENDOR_ID='$id_vendor'";
					$perintah2 = "UPDATE `tb_fin_vendor_update` SET `status`=1, `update_by`='$username', `update_date`='$today' WHERE VENDOR_ID='$id_vendor' and 
								`rating_laporan_audit_setelah_update`='$rating_sesudah' and `fin_limit_setelah_update`='$fin_sesudah'";	
				$isi_data = mysqli_query($perintah);
				$isi_data2 = mysqli_query($perintah2);
				if (isset($isi_data) and isset($isi_data2)) {
					//echo "<script>alert ('Data perubahan disimpan');</script>";
					echo '<script language="javascript">alert("Data perubahan disimpan")</script>';
					echo '<script language="javascript">window.location = "request_edit_finansial_vendor.php"</script>';
					//echo redirectPage($page);
				} else {
					echo "<script>alert('Data gagal disimpan');</script>";
					echo '<script language="javascript">window.location = "request_edit_finansial_vendor.php"</script>';
				}
				elseif ($act =="tolak") :	
					$perintah = "UPDATE `tb_fin_vendor_update` SET `status`=2 WHERE VENDOR_ID='$id_vendor' and 
								`rating_laporan_audit_setelah_update`='$rating_sesudah' and `fin_limit_setelah_update`='$fin_sesudah'";
					$isi_data = mysqli_query($perintah);
				if (isset($isi_data)) {
					//echo "<script>alert ('Data perubahan disimpan');</script>";
					echo '<script language="javascript">alert("Data perubahan disimpan")</script>';
					echo '<script language="javascript">window.location = "request_edit_finansial_vendor.php"</script>';
					//echo redirectPage($page);
				} else {
					echo "<script>alert('Data gagal disimpan');</script>";
					echo '<script language="javascript">window.location = "request_edit_finansial_vendor.php"</script>';
				}			
				endif;
				
		elseif($act == "remove") :
			$id = $_GET["id"];
			mysqli_query("DELETE FROM rayon WHERE idRayon='$id'");
			header("location:".$_SERVER['HTTP_REFERER']); 
		endif;
	endif;
	endif;
?>