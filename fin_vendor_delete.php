<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");

$vendor_id = $_GET['vendor_id'];
$delQuery = mysqli_query("DELETE FROM tb_fin_vendor WHERE vendor_id = '$vendor_id'");
if ($delQuery==1) {
	echo '<script language="javascript">alert("Finansial Vendor Berhasil Dihapus")</script>';
	echo '<script language="javascript">window.location = "fin_vendor.php"</script>';
} else {
	echo '<script language="javascript">alert("ERROR : Finansial Vendor Gagal di Hapus !")</script>';
	echo '<script language="javascript">window.location = "fin_vendor.php"</script>';
}
?>
