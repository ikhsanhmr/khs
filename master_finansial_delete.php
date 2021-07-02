<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");
$vendor_id = $_GET['vendor_id'];

$sql ="SELECT FIN_CURRENT FROM tb_fin_vendor WHERE VENDOR_ID ='$vendor_id'";
$resultQuery=mysqli_query($mysqli, $sql);
while ($rows=mysqli_fetch_row($resultQuery)){ 
	$data[] = $rows;
}

if($data[0][0]== '0.00')
{
	$delQuery = mysqli_query($mysqli, "DELETE FROM tb_fin_vendor WHERE VENDOR_ID = '$vendor_id'");
	//if ($delQuery==1) {
	echo '<script language="javascript">alert("Finansial Vendor Berhasil Dihapus")</script>';
	echo '<script language="javascript">window.location = "master_finansial.php"</script>';
} else {
	echo '<script language="javascript">alert("ERROR : Finansial Vendor Gagal di Hapus karena Sudah ada SPJ Terbit!")</script>';
	echo '<script language="javascript">window.location = "master_finansial.php"</script>';
}
