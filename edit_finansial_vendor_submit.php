<?php
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");

$get_var_id_vendor	= $_POST['var_id_vendor'];
$get_var_rating		= $_POST['var_rating'];
$get_var_limit		= $_POST['var_limit'];
$get_rating_pertama		= $_POST['rating_pertama'];
$get_limit_pertama		= $_POST['limit_pertama'];
$today 		= date('Y-m-d');
$username 	= $_SESSION['username'];
$foldername = "bukti_landasan_finansial/";

//$return_pagu_rating = pagu_rating_edit_second($get_var_rating,$get_var_limit,$get_var_id_vendor,$get_rating_pertama,$get_limit_pertama, $username, $today);
if (!empty($_FILES["file_bukti_landasan"]["tmp_name"]));
$password = "file".str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
$image = $foldername . basename($_FILES['file_bukti_landasan'] ['name']);
					$image = trim(addslashes($foldername .$get_var_id_vendor.$password.'-'. basename($_FILES['file_bukti_landasan'] ['name'])));
					$image = str_replace(' ', '_', $image);
					(move_uploaded_file($_FILES['file_bukti_landasan']['tmp_name'],$image));
$sql = "INSERT into `tb_fin_vendor_update` SET `VENDOR_ID`='$get_var_id_vendor', `rating_laporan_audit_sebelum_update`='$get_rating_pertama', 
				`rating_laporan_audit_setelah_update`='$get_var_rating',`fin_limit_sebelum_update`='$get_limit_pertama', `fin_limit_setelah_update`='$get_var_limit',
				`fin_update_user`='$username', `fin_update_date`='$today', `file_bukti`='$image', `status`=0";	
		//$sql2 = "UPDATE `tb_fin_vendor` SET `RATING_LAPORAN_AUDIT`='$get_var_rating',`FIN_LIMIT`='$var_limit' WHERE VENDOR_ID='$var_id_vendor'";	
		//echo $sql;
		$resultQuery=mysqli_query($sql);
		//$resultQuery2=mysqli_query($sql2);

if (isset($resultQuery)) {
	echo '<script language="javascript">alert("Nilai Finansial Vendor  Direvisi, Menungu Verifikasi")</script>';
	echo '<script language="javascript">window.location = "edit_finansial_vendor.php"</script>';
} else {
	echo '<script language="javascript">alert("Nilai Finansial Vendor Gagal Direvisi")</script>';
	echo '<script language="javascript">window.location = "edit_finansial_vendor.php"</script>';
}
?>
