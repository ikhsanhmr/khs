<?php
session_start();
include_once("lib/config.php");
include_once("lib/check.php");
$vendor_id = $_GET['vendor_id'];

$sql ="SELECT AREA_KODE FROM tb_mapping_vendor WHERE VENDOR_ID ='$vendor_id'";
$resultQuery=mysqli_query($mysqli, $sql);
while ($rows=mysqli_fetch_row($resultQuery)){ 
	$data[] = $rows;
}

if(empty($data[0][0]))
{
	$delQuery = mysqli_query($mysqli, "DELETE FROM tb_vendor WHERE VENDOR_ID = '$vendor_id'");
	//if ($delQuery==1) {
	echo '<script language="javascript">alert("Vendor Berhasil Dihapus")</script>';
	echo '<script language="javascript">window.location = "master_vendor.php"</script>';
} else {
	echo '<script language="javascript">alert("ERROR : Vendor Gagal di Hapus karena Sudah ter Mapping!")</script>';
	echo '<script language="javascript">window.location = "master_vendor.php"</script>';
}
