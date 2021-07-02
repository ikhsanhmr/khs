<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");

$var_vendor 		= $_POST['var_vendor'];
$vendor_id	 		= $_POST['vendor_id'];
$tahun_pekerjaan	 = $_POST['tahun_pekerjaan'];
$direksi_vendor	 	= $_POST['direksi_vendor'];
$jabatan	 		= $_POST['jabatan'];
$email	 			= $_POST['email'];
$telepon	 	    = $_POST['telepon'];

$today 		= date('Y-m-d');
$username 	= $_SESSION['username'];


mysqli_query($mysqli, "START TRANSACTION");
$sql = "UPDATE tb_vendor SET VENDOR_NAMA = '$var_vendor', TAHUN = '$tahun_pekerjaan',
			DIREKSI_VENDOR = '$direksi_vendor', EMAIL = '$email', TELEPON='$telepon',
			JABATAN='$jabatan',UPDATE_BY='$username', UPDATE_DATE='$today' 
			WHERE VENDOR_ID = '$vendor_id'";

$query = mysqli_query($mysqli, $sql);

if ($query == 1) {
	echo '<script language="javascript">alert("Data Vendor Berhasil Diupdate!")</script>';
	echo '<script language="javascript">window.location = "master_vendor.php"</script>';
	mysqli_query($mysqli, "COMMIT");
} else {
	echo '<script language="javascript">alert("Data Vendor Gagal Diupdate!")</script>';
	echo '<script language="javascript">window.location = "master_vendor.php"</script>';
	mysqli_query($mysqli, "ROLLBACK");
}
	
		/*if($query==1){
			mysqli_query("COMMIT");
			
		}else{
			mysqli_query("ROLLBACK");
		}
		echo '<script language="javascript">window.location = "master_pagu_edit.php?scs=EDIT SUKSES&vendor_id='.$vendor_id.'&paket_jenis='.$paket_jenis.'"</script>';
	 */
