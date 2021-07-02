<?php
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
include_once("lib/function.php");

$get_var_id_vendor			= $_POST['var_id_vendor'];
$paket_jenis				= $_POST['paket_jenis'];
$pagu_kontrak				= $_POST['pagu_kontrak'];
$upgrade_pagu_kontrak		= $_POST['upgrade_pagu_kontrak'];
$today 		= date('Y-m-d');
$username 	= $_SESSION['username'];
$foldername = "bukti_pagu_kontrak_vendor/";

//dibuka kuncinya request rizky ren, tanggal 31 Desember 2018, pagu yang sudah ditop-up, mau diturunkan lagi
/*if ($upgrade_pagu_kontrak < $pagu_kontrak){
		echo '<script language="javascript">alert("gagal... pagu upgrade lebih kecil dari pagu awal")</script>';
		echo '<script language="javascript">window.location = "edit_pagu_vendor.php"</script>';
}else{*/

//$return_pagu_rating = pagu_rating_edit_second($get_var_rating,$get_var_limit,$get_var_id_vendor,$get_rating_pertama,$get_limit_pertama, $username, $today);
if (!empty($_FILES["file_bukti_upgrade"]["tmp_name"]));
$password = "file".str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
$image = $foldername . basename($_FILES['file_bukti_upgrade'] ['name']);
					$image = trim(addslashes($foldername .$get_var_id_vendor.$password.'-'. basename($_FILES['file_bukti_upgrade'] ['name'])));
					$image = str_replace(' ', '_', $image);
					(move_uploaded_file($_FILES['file_bukti_upgrade']['tmp_name'],$image));
$sql = "INSERT into `tb_pagu_kontrak_update` SET `VENDOR_ID`='$get_var_id_vendor', `paket_jenis`='$paket_jenis', 
				`pagu_kontrak_sebelum_update`='$pagu_kontrak',`pagu_kontrak_setelah_update`='$upgrade_pagu_kontrak', 
				`file_bukti`='$image',`update_by`='$username', `update_date`='$today'";	

$sql2 = "UPDATE `tb_pagu_kontrak` SET `pagu_kontrak`='$upgrade_pagu_kontrak',`pagu_kontrak_sblm_update`='$pagu_kontrak' WHERE VENDOR_ID='$get_var_id_vendor'
		AND `paket_jenis`='$paket_jenis'";	
		//echo $sql;
		$resultQuery=mysqli_query($sql);
		$resultQuery2=mysqli_query($sql2);

if (isset($resultQuery) and isset($resultQuery2)) {
	
	echo '<script language="javascript">alert("Nilai Pagu Kontrak Vendor Berhasil Direvisi")</script>';
	echo '<script language="javascript">window.location = "edit_pagu_vendor.php"</script>';
} else {
	echo '<script language="javascript">alert("Nilai Pagu Kontrak Vendor Gagal Direvisi")</script>';
	echo '<script language="javascript">window.location = "edit_pagu_vendor.php"</script>';
}
//}
?>
